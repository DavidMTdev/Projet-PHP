<?php
session_start();

function getPdo()
{
    try {
        $pdo = new PDO("mysql:host=localhost:3306;dbname=projet_php", "root", "");
    } catch (PDOException $e) {
        var_dump($e);
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function select($sql, $args = array())
{
    $pdo = getPdo();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function selectOne($sql, $args = array())
{
    $pdo = getPdo();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function execute($sql, $args = array())
{
    $pdo = getPdo();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);
    return $pdo->lastInsertId();
}

if (isset($_POST["login"]) && isset($_POST["password"])) {

    $login = $_POST["login"];
    $password = $_POST["password"];

    $user = selectOne("SELECT * FROM user WHERE mail_user = :login", array(
        'login' => $login
    ));

    if ($user) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["login"] = $_POST["login"];
            $_SESSION["connected"] = true;
            $_SESSION["connectedAt"] = new DateTime();

            echo "Connecté avec succès !";
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Aucun compte avec ce login";
    }
}
