<?php
/*

fct=1    => fct se connecter
fct=2    => fct s'inscrire'
fct=3    => fct liste utilisateur
fct=4    => fct pour creer un event
fct=5    => fct upload un fichier
fct=6    => fct modifier le profil de l'utilisateur

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


// fct=4    => fct pour creer un event
if (isset($_POST["submit_create_event"])) {
    if (isset($_POST["privé"])) {
        $_POST["privé"] = 1;
    } else {
        $_POST["privé"] = 0;
    }
    $len_description_e = strlen($_POST['description_e']);
    $date = date("Y-m-d");

    var_dump($_POST['date1']);
    var_dump($_POST['date2']);
    var_dump($_POST['date3']);
    $date = strtotime($date);
    $deadline = strtotime($_POST['deadline']);
    var_dump($date);
    $date1 = strtotime($_POST['date1']);
    $date2 = strtotime($_POST['date2']);
    $date3 = strtotime($_POST['date3']);
    var_dump($date1);
    var_dump($date2);
    var_dump($date3);
    class error_create_event extends Exception
    { }

    try {
        if ($_POST['title'] == "") {
            throw new error_create_event("tu n'a pas rempli le titre de l'evenement");
        }
        if ($len_description_e > 250) {
            throw new error_create_event("il y'a maximum 250 caractere dans une description");
        }
        if ($_POST['description_e'] == "") {
            throw new error_create_event("tu n'a pas rempli la description de l'evenement");
        }
        if ($_POST['date1'] == "") {
            throw new error_create_event("tu n'a pas rempli une des dates possible pour l'evenement");
        }
        if ($_POST['date2'] == "") {
            throw new error_create_event("tu n'a pas rempli une des dates possible pour l'evenement");
        }
        if ($_POST['date3'] == "") {
            throw new error_create_event("tu n'a pas rempli une des dates possible pour l'evenement");
        }
        if ($_POST['deadline'] == "") {
            throw new error_create_event("tu n'a pas rempli la deadline pour l'evenement");
        }
        if ($deadline < $date) {
            throw new error_create_event("la dealine que tu as rentrer est déjà passé");
        }
        if ($date1 < $date) {
            throw new error_create_event("l'une des dates que tu as rentrer est déjà passé");
        }
        if ($date2 < $date) {
            throw new error_create_event("l'une des dates que tu as rentrer est déjà passé");
        }
        if ($date3 < $date) {
            throw new error_create_event("l'une des dates que tu as rentrer est déjà passé");
        }

        $createEvent = execute("INSERT INTO events ( title, description_e, deadline, public, id_user) 
                   VALUES (:title , :description_e, :deadline, :public, :id_user)", array(
            ':title' => $_POST['title'],
            ':description_e' => $_POST['description_e'],
            ':deadline' => $_POST['deadline'],
            ':public' => $_POST["privé"],
            ':id_user' => $_SESSION["login"]
        ));

        $id_event = selectOne("SELECT MAX(id_events) id_events FROM events");
        for ($i = 1; $i < 4; $i++) {
            $create_date_survey = execute("INSERT INTO date_survey ( date_events, id_events) 
        VALUES (:date_events, :id_events)", array(
                ':date_events' => $_POST['date' . $i],
                ':id_events' => $id_event["id_events"]
            ));
        }
    } catch (error_create_event $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo "notre équipe travail actuellement sur ce probléme";
    }
}

class ExceptionError extends Exception
{ }
// fct=5    => fct upload un fichier
function uploadFile($fileInfo, $folder, $fileName)
{
    $source = $fileInfo["tmp_name"];

    $destination = $folder . DIRECTORY_SEPARATOR . $fileName . ".png";

    if (move_uploaded_file($source, $destination) == true) {
        echo "Ca a marché";
    } else {
        echo "Ca n'a pas marché";
    }
}

// fct=6    => fct modifier le profil de l'utilisateur
try {
    //modif telephone
    if (isset($_POST["phone"]) && $_POST["phone"] != "") {
        if (strlen($_POST["phone"]) != 10) {
            throw new ExceptionError("numero de telephone non valide");
        }
        $update = execute("UPDATE user SET phone_u = :phone_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':phone_u' => $_POST["phone"]
        ));

        if (!isset($update) && $_POST["phone"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

    //modif mail
    if (isset($_POST["mail"]) && $_POST["mail"] != "") {
        $update = execute("UPDATE user SET mail_u = :mail_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':mail_u' => $_POST["mail"]
        ));

        if (!isset($update) && $_POST["mail"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

    //modif image
    if (isset($_FILES["image"])) {
        $folder = "../../upload" . DIRECTORY_SEPARATOR . $_SESSION["login"] . DIRECTORY_SEPARATOR . "profil";

        $update = execute("UPDATE user SET picture_u = :picture_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':picture_u' => $_SESSION["login"] . ".png"
        ));

        if (!isset($update) && $_POST["firstname"] != "") {
            throw new ExceptionError("un problème est survenue");
        } else {
            uploadFile($_FILES["image"], $folder, $_SESSION["login"]);
        }
    }

    //modif prenom
    if (isset($_POST["firstname"]) && $_POST["firstname"] != "") {
        $update = execute("UPDATE user SET first_name_u = :first_name_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':first_name_u' => $_POST["firstname"]
        ));

        if (!isset($update) && $_POST["firstname"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

    //modif nom
    if (isset($_POST["lastname"]) && $_POST["lastname"] != "") {
        $update = execute("UPDATE user SET name_u = :name_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':name_u' => $_POST["lastname"]
        ));

        if (!isset($update) && $_POST["lastname"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

    //modif age
    if (isset($_POST["age"]) && $_POST["age"] != "Age") {
        $update = execute("UPDATE user SET age_u = :age_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':age_u' => $_POST["age"]
        ));

        if (!isset($update) && $_POST["age"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

    //modif description
    if (isset($_POST["description"]) && $_POST["description"] != "") {
        $update = execute("UPDATE user SET description_u = :description_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':description_u' => $_POST["description"]
        ));

        if (!isset($update) && $_POST["description"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }
} catch (ExceptionError $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo "notre équipe travail actuellement sur ce probléme";
}
