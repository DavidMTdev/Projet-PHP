<?php require_once("include/function.php") ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/navbar.css">

    <?php if ($_SERVER["SCRIPT_NAME"] === "/projet-php/login.php") : ?>
        <link rel="stylesheet" href="css/login.css">
        <title>Connexion</title>
    <?php endif; ?>
</head>

<body>
    <header>
        <?php require_once("include/nav.php") ?>
    </header>
    <main>