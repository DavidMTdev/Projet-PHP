<?php
$path = explode("/", $_SERVER["SCRIPT_NAME"]);
if (count($path) > 3) {
    $path = "/" . $path[1] . "/" . $path[2] . "/" . $path[3];
}

if ($path === "/projet-php/admin/profil") {
    require_once("../../include/function.php");
} else {
    require_once("include/function.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php if ($path === "/projet-php/admin/profil") : ?>
        <link rel="stylesheet" href="../../css/navbar.css">
        <script src="https://kit.fontawesome.com/c3feb606cd.js"></script>

    <?php else : ?>
        <link rel="stylesheet" href="css/navbar.css">
        <script src="https://kit.fontawesome.com/c3feb606cd.js"></script>
    <?php endif; ?>


    <?php if ($_SERVER["SCRIPT_NAME"] === "/projet-php/signup.php") : ?>
        <link rel="stylesheet" href="css/signup.css">
        <title>Inscription</title>
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/login.php") : ?>
        <link rel="stylesheet" href="css/login.css">
        <title>Connexion</title>
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/profil.php") : ?>
        <link rel="stylesheet" href="css/profil.css">
        <title>Votre Profil</title>
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/createEvent.php") : ?>
        <link rel="stylesheet" href="css/createEvent.css">
        <title>Créer un événement</title>
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/listUsers.php") : ?>
        <link rel="stylesheet" href="css/listUsers.css">
        <title>Liste des utilisateurs</title>
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/dashbord.php") : ?>
        <link rel="stylesheet" href="css/dashbord.css">
        <title>Dashboard</title>
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/list-event.php") : ?>
        <link rel="stylesheet" href="css/list-event.css">
        <title>Liste des événements</title>
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/event.php") : ?>
        <link rel="stylesheet" href="css/event.css">
        <title>L'événement</title>
    <?php elseif ($_SERVER["SCRIPT_NAME"] === "/projet-php/modify-main.php" || "/projet-php/modify-address.php" || "/projet-php/modify-password.php" || "/projet-php/modify-contact.php") : ?>
        <link rel="stylesheet" href="css/modify-profil.css">
        <title>Modifier</title>
    <?php if ($_SERVER["SCRIPT_NAME"] === "/projet-php/home.php") : ?>
        <link rel="stylesheet" href="css/home.css">
        <title>Accueil</title>
    <?php endif; endif;?>
</head>

<body>
    <header>
        <?php
        if ($path === "/projet-php/admin/profil") {
            require_once("../../include/nav.php");
        } else {
            require_once("include/nav.php");
        }
        ?>
    </header>
    <main>