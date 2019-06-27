<?php
/*

fct=1    => fct se connecter

*/
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

// fct=1 vérification de la connexion 
if (isset($_POST["login"]) && isset($_POST["password"])) {

    $login = $_POST["login"];
    $password = $_POST["password"];

    $user = selectOne("SELECT * FROM user WHERE mail = :login", array(
        'login' => $login
    ));

    if ($user) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["login"] = $login;
            $_SESSION["connected"] = true;
            $_SESSION["connectedAt"] = new DateTime();
        } else {
            $error = "Mot de passe incorrect";
        }
    } else {
        $error = "Aucun compte avec ce login";
    }
}


/*

fct=2    => fct s'inscrire'

*/
class error_signup extends Exception{ }
if (isset($_POST['submit_signup'])) {
    echo 1;
    $pdo = getPdo();
    $error_mail = mail_unique();
    $PostalCode = strlen($_POST['postal_code']);
    $Phone = strlen($_POST['phone']);
    var_dump($_POST['password']);
    try {
        if ($_POST['name'] == "") {
            throw new error_signup("tu n'a pas rempli ton nom");
        }
        if ($_POST['first-name'] == "") {
            throw new error_signup("tu n'a pas rempli ton prenom");
        }
        if ($_POST['password'] == "") {
            throw new error_signup("tu n'a pas rempli ton mot de passe");
        }
        if ($_POST['password'] != $_POST['password_verif']) {
            throw new error_signup("les deux mot de passe ne sont pas pareil");
        }
        if ($_POST['age'] == "Age") {
            throw new error_signup("tu n'a pas rempli ton age");
        }
        if ($_POST['mail'] == "") {
            throw new error_signup("tu n'a pas rempli ton mail");
        }
        if ($error_mail == 1) {
            throw new error_signup("compte déja existant");
        }
        if ($PostalCode != 5 && $PostalCode != '') {
            throw new error_signup("code postal non valide");
        }
        if ($Phone != 10) {
            throw new error_signup("numero de telephone non valide non valide");
        }
        $inscription = execute("INSERT INTO user ( name_u, first_name_u, password_u, age_u, adress_u, city_u, postal_code_u, mail_u, phone_u) 
                   VALUES (:name_u , :first_name_u, :password_u, :age_u, :adress_u, :city_u, :postal_code_u, :mail_u, :phone_u)",array(
            ':name_u' => $_POST['name'],
            ':first_name_u' => $_POST['first-name'],
            ':password_u' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ':age_u' => $_POST['age'],
            ':adress_u' => $_POST['adress'],
            ':city_u' => $_POST['city'],
            ':postal_code_u' => $_POST['postal_code'],
            ':mail_u' => $_POST['mail'],
            ':phone_u' => $_POST['phone'],
                   ));
            header("location: home.php");
        
    }  catch(error_signup $e) {
        echo $e->getMessage();
    } catch(Exception $e) {
        echo "Si tu tombe sur cette erreur tu es vraiment le plus grand des abrutis de l'histoire";
    }
   
}

function mail_unique(){
    $pdo = getPdo();
    $mail_u = $pdo->prepare("SELECT mail_u FROM user");
    $mail_u->execute();
    $mail_u = $mail_u->fetchAll(PDO::FETCH_ASSOC);
    // $mail_u = selectOne("SELECT mail_u FROM user",null);
    foreach ($mail_u as $key => $value) {
        if($_POST["mail"] === $value["mail_u"]){
            return 1;
        }
    }
}
