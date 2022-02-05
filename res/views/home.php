<!DOCTYPE html>
<html lang="<?= locale() ?>">
    <head>
        <base href="/"/>
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta http-equiv="Content-Language" content="<?= locale() ?>"/>
        <title><?= text('app_name') ?></title>
        <meta name="description" content="<?= text('home_description') ?>"/>
        <link rel="stylesheet" href="<?= style('app') ?>"/>
        <link rel="stylesheet" href="<?= style('home') ?>"/>
    </head>
    <body>
        <main>
            <h1><?= text('app_name') ?></h1>
            <p><?= ucfirst(text('Welcome_to', text('app_name'))) ?></p>
            <form action="#" method="GET">
                <p>
                    <input class="field" type="email" name="email" placeholder="<?= text('Enter_email') ?>"/>
                    <button class="button" name="action" type="submit" value="continue"><?= text('Continue') ?></button>
                </p>
            </form>
        </main>
    </body>
</html>