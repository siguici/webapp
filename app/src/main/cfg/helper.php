<?php use Ske\Util\{
    Template,
    Http\Server,
    User,
    App,
    Locale,
    Translation,
    TranslationFile,
    Translator
};

function server(?string $root = null): Server {
    static $server;
    if (!isset($server))
        $server = new Server($root);
    return $server;
}

function user(): User {
    static $user;
    if (!isset($user)) {
        $user = new User('en-US');
    }
    return $user;
}

function app(): App {
    static $app;
    if (!isset($app)) {
        $app = new App('fr-CI', 'en-US');
    }
    return $app;
}

function vals(Locale ...$locales): Translator {
    $translations = [];
    foreach ($locales as $locale) {
        $language = $locale->getLanguage();
        $country = $locale->getCountry();
        if ($file = pathOf("app.res.values.$language-$country", '.json'))
            $translations[] = new TranslationFile("$language-$country", $file);
        else
            $translations[] = new Translation("$language-$country");
        if ($file = pathOf("app.res.values.$language", '.json'))
            $translations[] = new TranslationFile($language, $file);
        else
            $translations[] = new Translation($language);
    }
    return new Translator($translations);
}

function val(string $val, string ...$args): string {
    static $vals;
    if (!isset($vals)) {
       $vals = vals(user()->getLocale(), ...app()->getLocales());
    }
    return $vals->translate($val, ...$args);
}

function tpl(string $path, array $data = [], bool $required = true): Template {
    return new Template(pathOf("app.res.views.$path", '.php') ?: $path, $data, $required);
}

function pathOf(string $name, string $extension = '.php'): ?string {
    return server()->pathOf($name, $extension);
}

function send(null|int|string $content = null): void {
    if (!isset($content))
        exit;
    exit($content);
}

function style(string $name): string {
    return url("static.$name", '.css');
}

function script(string $name): string {
    return url("static.$name", '.js');
}

function url(string $name, string $extension): ?string {
    if (!pathOf("web.$name", $extension)) {
        throw new \RuntimeException("Unknown $name ($extension) in " . pathOf('web'));
    }
    return '/' . str_replace('.', '/', $name) . $extension;
}

function parse_cmd(int $argc, array $argv): array {
    if ($argc !== count($argv)) {
        throw new \UnexpectedArgumentCountException('Wrong count of arguments');
    }

    if ($argc === 0) {
        throw new \InvalidArgumentException('No arguments given');
    }

    $name = array_shift($argv);
    $args = [];
    $options = [];

    $arg_key = null;
    $option_key = null;
    $options_checked = false;
    while ($arg = array_shift($argv)) {
        if ($arg == '--' || $arg == '-') {
            $options_checked = true;
            if ($arg_key) {
                $args[$arg_key] = null;
                $arg_key = null;
            }
            if ($option_key) {
                $options[$option_key] = true;
                $option_key = null;
            }
            continue;
        }
        if ($options_checked || $arg[0] != '-') {
            if ($option_key) {
                $options[$option_key] = $arg;
                $option_key = null;
            }
            elseif ($arg_key) {
                $args[$arg_key] = $arg;
                $arg_key = null;
            }
            else {
                $arg_key = $arg;
            }
            continue;
        }
        if (preg_match('/^--([^-]+)=(.+)$/', $arg, $matches)) {
            $options[$matches[1]] = $matches[2];
        }
        elseif (preg_match('/^--([^-]+)$/', $arg, $matches)) {
            $options[$matches[1]] = true;
        }
        elseif (preg_match('/^-([^-]+)$/', $arg, $matches)) {
            if ($option_key) {
                $options[$option_key] = $matches[1];
                $option_key = null;
            }
            else {
                $option_key = $matches[1];
            }
        }
        else {
            throw new \InvalidArgumentException("Unknown option: $arg");
        }
    }

    if ($arg_key) {
        $args[$arg_key] = null;
        unset($arg_key);
    }

    if ($option_key) {
        $options[$option_key] = true;
        unset($option_key);
    }

    return ['name' => $name, 'options' => $options, 'args' => $args];
}