<?php use Ske\Util\{
    Template,
    Http\Server,
    User,
    App,
    Locale,
    Translation,
    TranslationFile,
    Translator,
    Dotenv,
    Env
};

function root(): string {
	return dirname(__DIR__, 4) . DIRECTORY_SEPARATOR;
}

function pathOf(string $file, string $extension = '.php'): ?string {
	return file_exists($path = root() . str_replace('.', DIRECTORY_SEPARATOR, $file) . $extension) ? $path : null;
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

function env(?string $name = null, mixed $default = null): mixed {
    static $env;
    if (!isset($env)) {
        $dotenv = new Dotenv(root());
        $env = $dotenv->load('env.ini');
    }

    if (!isset($name))
        return $env;

    if (isset($env[$name]))
        return $env[$name];

    return $env[$name] = getenv($name) ?? $_ENV[$name] ?? $_SERVER[$name] ?? $default;
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
