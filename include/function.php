<?php
/*

fct=1    => fct se connecter
fct=2    => fct s'inscrire'
fct=3    =>fct liste utilisateur

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

function setConnection($login)
{
    $_SESSION["login"] = $login;
    $_SESSION["connected"] = true;
    $_SESSION["connectedAt"] = new DateTime();
}

// fct=1 vérification de la connexion 
if (isset($_POST["login"]) && isset($_POST["password"])) {

    $login = $_POST["login"];
    $password = $_POST["password"];

    $user = selectOne("SELECT * FROM user WHERE mail_u = :login", array(
        'login' => $login
    ));

    if ($user) {
        if (password_verify($password, $user["password_u"])) {
            setConnection($user["id_user"]);
        } else {
            $error = "Mot de passe incorrect";
        }
    } else {
        $error = "Aucun compte avec ce login";
    }
}

//fct=2 fonction pour s'inscrire
class error_signup extends Exception
{ }
if (isset($_POST['submit_signup'])) {
    $pdo = getPdo();
    $error_mail = mail_unique();
    $PostalCode = strlen($_POST['postal_code']);
    $Phone = strlen($_POST['phone']);
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
            throw new error_signup("numero de telephone non valide");
        }
        $inscription = execute("INSERT INTO user ( name_u, first_name_u, password_u, age_u, adress_u, city_u, postal_code_u, mail_u, phone_u) 
                   VALUES (:name_u , :first_name_u, :password_u, :age_u, :adress_u, :city_u, :postal_code_u, :mail_u, :phone_u)", array(
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

        setConnection($inscription);

        $UsersSignup = selectOne('SELECT MAX(id_user) id_user FROM user');
        mkdir("upload" . DIRECTORY_SEPARATOR . $UsersSignup["id_user"]);
        mkdir("upload" . DIRECTORY_SEPARATOR . $UsersSignup["id_user"] . DIRECTORY_SEPARATOR . "profil");
        $folder = 'upload/' . $UsersSignup["id_user"] . DIRECTORY_SEPARATOR . "profil" . DIRECTORY_SEPARATOR . "0.png";
        $pictureFake = 'C:/wamp64/www/Projet-PHP/upload/0.png';
        copy($pictureFake, $folder); 
        
        // header("location: home.php");
    } catch (error_signup $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo "Si tu tombe sur cette erreur tu es vraiment le plus grand des abrutis de l'histoire";
    }
}

function mail_unique()
{
    $pdo = getPdo();
    $mail_u = select("SELECT mail_u FROM user");
    foreach ($mail_u as $key => $value) {
        if ($_POST["mail"] === $value["mail_u"]) {
            return 1;
        }
    }
}

//fct=3 fonction pour lister les utilisateurs
if (isset($_POST["submit_listUsers"])) {
    $pdo = getPdo();
    $listUsers = select('SELECT name_u FROM user WHERE name_u LIKE "' . $_POST["search"] . '%"');
}

if (isset($_GET["user"])) {
    $user = selectOne("SELECT * FROM user WHERE id_user = :id", array(
        "id" => $_GET["user"]
    ));

    $folder = "upload" . DIRECTORY_SEPARATOR . $_GET["user"] . DIRECTORY_SEPARATOR . "profil" . DIRECTORY_SEPARATOR . $user["picture_u"];
}
