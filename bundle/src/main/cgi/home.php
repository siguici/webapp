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
            margin: inherit;
            padding: inherit;
        }
        
        :root {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100vw;
            height: 100vh;
            font: 1rem Arial;
            background-color: rgb(0, 127, 128);
            color: #FFF;
        }
        </style>
    </head>
    <body>
        <p>Welcome to the <?= APP_NAME ?> Website!</p>
    </body>
</html>
