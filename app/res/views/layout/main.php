<!DOCTYPE html>
<html lang="<?= val('lang') ?>">
    <head>
        <base href="/"/>
        <meta charset="UTF-8"/>
        <title><?= val('app_name') ?></title>
        <meta name="description" content="<?= val('The %s Website', val('app_name')) ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="<?= style('normalize') ?>"/>
        <link rel="stylesheet" href="<?= style('app') ?>"/>
    </head>
    <body>
        <div id="wrapper">
            <header>
                <p><a href="/"><img class="ske-logo" src="logo.svg" alt="<?= val('app_name') ?>"/></a></p>
                <?= $main_menu ?>
            </header>
            <main><?= $main_view ?></main>
            <footer>
                <p class="copyright"><?= val('Copyright &copy; 2021-%d %s', date('Y'), val('app_author_name')) ?><br/><?= val('All right reseved') ?></p>
                <div class="settings"><?= tpl('form.settings') ?></div>
            </footer>
        </div>
    </body>
</html>
