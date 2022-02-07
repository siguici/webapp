<!DOCTYPE html>
<html lang="<?= val('lang') ?>">
    <head>
        <base href="/"/>
        <meta charset="UTF-8"/>
        <title><?= val('app_name') ?></title>
        <meta name="description" content="<?= val('The %s Website', val('app_name')) ?>"/>
        <style>
        *::before, *, *::after {
            box-sizing: inherit;
        }

        :root {
            box-sizing: border-box;
            font: 1rem Arial;
        }

        * {
            padding: 0;
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        .action {
            display: inline-block;
            padding: 0.5rem 1rem;
            cursor: pointer;
            color: inherit;
            background: inherit;
        }

        .action.button {
            border: 1px solid inherit;
            border-radius: 0.25rem;
        }

        .action.link:hover {
            text-decoration: underline;
        }

        header {
            background-color: #fff;
            color: #000;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header .ske-logo {
            height: 30px;
        }

        header .action.link {
            color: rgb(0, 127, 128);
            font-weight: bold;
            padding-right: 0;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100vw;
            min-height: 80vh;
            background-color: rgb(0, 127, 128);
            color: #FFF;
            text-align: center;
        }

        main > h1 {
            font-weight: normal;
            font-size: 2.4rem;
            padding: 8px 12px;
        }

        main > h1 + p {
            font-size: 1.2rem;
            padding: 8px;
            line-height: 1.6;
        }

        main > h1 + p + p {
            margin: 24px 16px;
        }

        main > h1 + p + p .action {
            border-color: #FFF;
            padding: 12px 24px;
            border-radius: 4px;
            background-color: #000;
            color: #FFF;
        }

        main > h1 + p + p .action:hover {
            background-color: #FFF;
            color: #000;
        }

        footer {
            padding: 12px 8px;
        }

        footer .copyright {
            text-align: center;
            line-height: 1.5;
            font-size: 0.85rem;
        }
        </style>
    </head>
    <body>
        <header>
            <p><a href="/"><img class="ske-logo" src="logo.svg" alt="<?= val('app_name') ?>"/></a></p>
            <?= $main_menu ?>
        </header>
        <main><?= $main_view ?></main>
        <footer>
            <p class="copyright"><?= val('Copyright &copy; 2021-%d %s', date('Y'), val('app_author_name')) ?><br/><?= val('All right reseved') ?></p>
            <div><?= tpl('form.set') ?></div>
        </footer>
    </body>
</html>
