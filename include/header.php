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
<<<<<<< HEAD
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/profil.php") : ?>
        <link rel="stylesheet" href="css/profil.css">
        <title>Votre Profil</title>
=======
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/signup.php") : ?>
        <link rel="stylesheet" href="css/signup.css">
        <title>inscription</title>
>>>>>>> 969eb0e3e0764e411219a87d33002a0a0c5648f6
    <?php endif; ?>
    </head>

    <body>
        <header>
            <?php require_once("include/nav.php") ?>
        </header>
        <main>