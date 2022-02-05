<?php
const APP_NAME = 'SIKessEm';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="/"/>
        <meta charset="UTF-8"/>
        <title><?= APP_NAME ?></title>
        <meta name="description" content="The <?= APP_NAME ?> Website"/>
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
        
        header {
            background-color: #fff;
            color: #000;
            padding: 15px 30px;
        }
        
        .ske-logo {
            height: 30px;
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
            <p><a href="/"><img class="ske-logo" src="logo.svg" alt="The SIKessEm logo"/></a></p>
        </header>
        <main>
            <h1>Carry out your web, mobile and desktop development projects</h1>
            <p>SIKessEm is SIGUI Kessé Emmanuel's web application on which you can access its various projects and follow the development of the projects that interest you.</p>
        </main>
        <footer>
            <p class="copyright">Copyright &copy; 2021-<?= date('Y') ?> SIGUI Kessé Emmanuel<br/>All right reseved</p>
        </footer>
    </body>
</html>
