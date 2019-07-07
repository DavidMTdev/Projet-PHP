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

    header("location: dashbord.php?user=" . $_SESSION["login"]);
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

        header("location: home.php");
    } catch (error_signup $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo "notre équipe travail actuellement sur ce probléme";
    }
}

function mail_unique()
{
    $mail_u = select("SELECT mail_u FROM user");
    foreach ($mail_u as $key => $value) {
        if ($_POST["mail"] === $value["mail_u"]) {
            return 1;
        }
    }
}

//fct=3 fonction pour lister les utilisateurs
if (isset($_POST["submit_listUsers"])) {
    $listUsers = select('SELECT id_user, name_u, first_name_u, picture_u FROM user WHERE name_u LIKE :search', array("search" => $_POST["search"] . "%"));
}

if (isset($_GET["user"])) {
    $user = selectOne("SELECT * FROM user WHERE id_user = :id", array(
        "id" => $_GET["user"]
    ));

    $folder = "upload" . DIRECTORY_SEPARATOR . $_GET["user"] . DIRECTORY_SEPARATOR . "profil" . DIRECTORY_SEPARATOR . $user["picture_u"];
}


// fct=4    => fct pour creer un event
if (isset($_SESSION["login"])) {
    $id_event_user = select("SELECT id_events, validation_events, public, id_user FROM events WHERE id_user = :id_user ORDER BY id_events", array(
        ':id_user' => $_SESSION["login"]
    ));
}

if (!empty($id_event_user)) {
    $last_id_event_user = $id_event_user[count($id_event_user) - 1];
}


if (isset($_POST["submit_create_event"])) {
    if (isset($_POST["privé"])) {
        $_POST["privé"] = 1;
    } else {
        $_POST["privé"] = 0;
    }
    $len_description_e = strlen($_POST['description_e']);
    $date = date("Y-m-d");

    $date = strtotime($date);
    $deadline = strtotime($_POST['deadline']);
    $date1 = strtotime($_POST['date1']);
    $date2 = strtotime($_POST['date2']);
    $date3 = strtotime($_POST['date3']);
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
        if ($date1 == $date2) {
            throw new error_create_event("tu ne peux pas mettre 2 dates identiques");
        }
        if ($date1 == $date2) {
            throw new error_create_event("tu ne peux pas mettre 2 dates identiques");
        }
        if ($date1 == $date3) {
            throw new error_create_event("tu ne peux pas mettre 2 dates identiques");
        }
        if ($date2 == $date3) {
            throw new error_create_event("tu ne peux pas mettre 2 dates identiques");
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
    $id_event_user = select("SELECT id_events, validation_events, public FROM events WHERE id_user = :id_user", array(
        ':id_user' => $_SESSION["login"]
    ));
}


// invité des personnes a un evenement
function invitation($allUsers, $id_event)
{
    foreach ($allUsers as $key => $value) {
        if (isset($_POST["" . $key + 1 . ""])) {
            $add_user_event = execute("INSERT INTO rejoin ( id_user, id_events) 
    VALUES (:id_user , :id_events)", array(
                ':id_user' => $key + 1,
                ':id_events' => $id_event["id_events"]
            ));
        }
    }
}
if (isset($_POST["submit_create_event_add_users"])) {
    $allUsers = select("SELECT id_user FROM user");
    $id_event = selectOne("SELECT MAX(id_events) id_events FROM events");
    $user_in_event = select('SELECT user.id_user FROM user 
    JOIN rejoin ON rejoin.id_user = user.id_user
    WHERE id_events = "' . $id_event["id_events"] . '"');
    foreach ($allUsers as $key => $value) {
        if (isset($_POST["" . $key + 1 . ""])) {
            $user_no_repeat = selectOne('SELECT user.id_user FROM user 
                JOIN rejoin ON rejoin.id_user = user.id_user
                WHERE id_events = "' . $id_event["id_events"] . '"
                AND rejoin.id_user = "' . ($key + 1) . '"');
        }
    }
    if (empty($user_in_event)) {
        invitation($allUsers, $id_event);
    } elseif (empty($user_no_repeat)) {
        invitation($allUsers, $id_event);
    } else {
        foreach ($allUsers as $key => $value) {
            foreach ($user_no_repeat as $key2 => $value2) {
                if (isset($_POST["" . ($key + 1) . ""])) {
                    if (($key + 1) != $user_no_repeat["id_user"]) {
                        $add_user_event = execute("INSERT INTO rejoin ( id_user, id_events) 
                VALUES (:id_user , :id_events)", array(
                            ':id_user' => $key,
                            ':id_events' => $id_event["id_events"]
                        ));
                    } else {
                        echo "tu as déjà invité cette personne";
                    }
                }
            }
        }
    }
}

function not_validate_event_privé()
{
    if (isset($_SESSION["login"])) {
        $id_event_user = select("SELECT id_events, validation_events, public, id_user FROM events WHERE id_user = :id_user ORDER BY id_events", array(
            ':id_user' => $_SESSION["login"]
        ));
    }
    
    if (!empty($id_event_user)) {
        $last_id_event_user = $id_event_user[count($id_event_user) - 1];
    }
    if ($last_id_event_user["validation_events"] == 0) {
        header("location: listUsers.php");
    }
}

// validation inviter pour un evenement
$id_event = selectOne("SELECT MAX(id_events) id_events FROM events");
if (!empty($id_event)) {
    $user_in_event = select('SELECT id_events, user.id_user ,name_u FROM user 
JOIN rejoin ON rejoin.id_user = user.id_user
WHERE id_events = "' . $id_event["id_events"] . '"');
    if (isset($_POST["submit_invite"])) {
        if (count($user_in_event) <= 0) {
            echo "tu es obliger d'invité au moins une personne";
        } else {
            $update = execute("UPDATE events SET validation_events = :validation_events WHERE id_events = :id_events", array(
                ':id_events' => $id_event["id_events"],
                ':validation_events' => 1
            ));
            header("location: dashbord.php");
        }
    }
}
// annuler un evenement si evenement privé et que la personne est entrain de faire le choix des invités
// si l'user n'a pas valider l'invation des autres user et si il veut aller sur la page createEvent redirection sur listUsers
if (isset($_POST["submit_annuler_evenement"])) {
    $last_id_event_user = $id_event_user[count($id_event_user) - 1];
    $delete_event_not_valid = execute('DELETE FROM events 
    WHERE id_events = "' . $last_id_event_user["id_events"] . '"
    AND id_user = "' . $_SESSION["login"] . '"');

    $delete_rejoin_not_valid = execute('DELETE FROM rejoin 
    WHERE id_events = "' . $last_id_event_user["id_events"] . '"');
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
    //modif mdp
    if (isset($_POST["password"]) && isset($_POST["password_verif"])) {
        if ($_POST['password'] == "") {
            throw new ExceptionError("tu n'a pas rempli ton mot de passe");
        } elseif ($_POST['password'] != $_POST['password_verif']) {
            throw new ExceptionError("les deux mot de passe ne sont pas pareil");
        }

        $update = execute("UPDATE user SET password_u = :password_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':password_u' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ));

        if (!isset($update) && $_POST["address"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

    //modif adresse
    if (isset($_POST["address"]) && $_POST["address"] != "") {
        $update = execute("UPDATE user SET adress_u = :adress_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':adress_u' => $_POST["address"]
        ));

        if (!isset($update) && $_POST["address"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

    //modif ville
    if (isset($_POST["city"]) && $_POST["city"] != "") {
        $update = execute("UPDATE user SET city_u = :city_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':city_u' => $_POST["city"]
        ));

        if (!isset($update) && $_POST["city"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

    //modif code postal
    if (isset($_POST["postalcode"]) && $_POST["postalcode"] != "") {
        if (strlen($_POST["postalcode"]) != 5) {
            throw new ExceptionError("code postal non valide");
        }
        $update = execute("UPDATE user SET postal_code_u = :postal_code_u WHERE id_user = :id_user", array(
            ':id_user' => $_SESSION["login"],
            ':postal_code_u' => $_POST["postalcode"]
        ));

        if (!isset($update) && $_POST["postalcode"] != "") {
            throw new ExceptionError("un problème est survenue");
        }
    }

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

        if (!isset($update) && $_FILES["image"]["name"] != "") {
            throw new ExceptionError("un problème est survenue");
        } else {
            if ($_FILES["image"]["name"] != "") {
                uploadFile($_FILES["image"], $folder, $_SESSION["login"]);
            }
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

if (isset($_GET['user']) && !isset($_POST['search_event'])) {
    $listEventPublic = select("SELECT * FROM events WHERE public = :public", array(
        "public" => 0
    ));
} elseif (isset($_GET['user']) && isset($_POST['search_event'])) {
    $listEventPublic = select("SELECT * FROM events WHERE public = :public AND title LIKE :search", array(
        "public" => 0,
        "search" => $_POST["search_event"] . "%"
    ));
}


if (isset($_GET["event"])) {
    $event = selectOne("SELECT * FROM events WHERE id_events = :id_events", array(
        "id_events" => $_GET["event"]
    ));
    $survey_date = select("SELECT * FROM date_survey WHERE id_events = :id_events", array(
        "id_events" => $_GET["event"]
    ));
    $rejoin = selectOne("SELECT * FROM rejoin WHERE id_events = :id_events AND id_user = :id_user", array(
        "id_events" => $_GET["event"],
        "id_user" => $_SESSION["login"]
    ));
}

if (isset($_GET['user'])) {
    $listEventUser = select("SELECT e.id_events, title, description_e, date_events, deadline, public FROM rejoin r JOIN events e ON r.id_events = e.id_events WHERE r.id_user = :id_user1 UNION SELECT e.id_events, title, description_e, date_events, deadline, public FROM rejoin r JOIN events e ON r.id_events = e.id_events WHERE e.id_user = :id_user2 ORDER BY `deadline` ASC", array(
        "id_user1" => $_GET['user'],
        "id_user2" => $_GET['user']
    ));
    // var_dump($listEventUser);
}



// sondage date
if (isset($_POST["submit_survey_date"])) {
    $count = 0;
    $event_checkbox = 0;
    $number_vote = 0;
    foreach ($survey_date as $key => $value) {
        if (isset($_POST['event' . $value["id_date_survey"]])) {
            $count += 1;
            $event_checkbox = $value["id_date_survey"];
            $number_vote = $value["number_votes"];
        }
    }
    switch ($count) {
        case 0:
            echo "tu n'a pas sélectionnez de date";
            break;
        case 1:
            $update_vote = execute("UPDATE date_survey SET number_votes = :number_votes WHERE id_date_survey = :id_date_survey", array(
                ':id_date_survey' => $event_checkbox,
                ':number_votes' => $number_vote + 1
            ));
            $update_vote_user = execute("UPDATE rejoin SET to_vote = :to_vote WHERE id_events = :id_events AND id_user = :id_user", array(
                "to_vote" => $event_checkbox,
                ':id_events' => $_GET["event"],
                ':id_user' => $_SESSION["login"]
            ));
            header("location: event.php?event=" . $_GET["event"]);
            break;
        case 2:
            echo "il ne faut sélectionnez qu'une seule date";
            break;
        case 3:
            echo "il ne faut sélectionnez qu'une seule date";
            break;
    }
    
}

//s'inscrire a un evenement public
if (isset($_POST["submit_signup_event_public"])) {
    $add_user_event_signup = execute("INSERT INTO rejoin ( id_user, id_events, statut) 
    VALUES (:id_user , :id_events, :statut)", array(
        ':id_user' => $_SESSION["login"],
        ':id_events' => $_GET["event"],
        ":statut" => 1
    ));
    $rejoin = selectOne("SELECT * FROM rejoin WHERE id_events = :id_events AND id_user = :id_user", array(
        "id_events" => $_GET["event"],
        "id_user" => $_SESSION["login"]
    ));
}

//se désinscrire a un evenement public
if (isset($_POST["submit_unsignup_event"])) {
    $rejoin = selectOne("SELECT * FROM rejoin WHERE id_events = :id_events AND id_user = :id_user", array(
        "id_events" => $_GET["event"],
        "id_user" => $_SESSION["login"]
    ));

    $unsignup_datesurvey_one = selectOne("SELECT number_votes FROM date_survey WHERE id_date_survey = :id_date_survey", array(
        "id_date_survey" => $rejoin["to_vote"]
    ));

    $unsignug_vote = execute("UPDATE date_survey SET number_votes = :number_votes WHERE id_date_survey = :id_date_survey", array(
        ":number_votes" => ($unsignup_datesurvey_one["number_votes"] - 1),
        ":id_date_survey" => $rejoin["to_vote"]
    ));


    $delete_event_unsignup = execute('DELETE FROM rejoin 
    WHERE id_events = "' . $_GET["event"] . '"
    AND id_user = "' . $_SESSION["login"] . '"');

    header("location: dashbord.php");
}

//date depasse la deadline ça conserve seulement la date qui a le plus de vote

$every_event = select("SELECT * FROM events");
if (!empty($every_event)) {
    foreach ($every_event as $key => $value) {
        if ($value["validation_events"] != 2) {
            $date = date("Y-m-d");
            $date = strtotime($date);
            $deadline = strtotime($value["deadline"]);
            if ($deadline <= $date) {
                $every_date_survey = selectOne("SELECT date_events FROM date_survey WHERE id_events = :id_events ORDER BY number_votes desc", array(
                    "id_events" => $value["id_events"]
                ));
                $update_date_events = execute("UPDATE events SET date_events = :date_events, validation_events = :validation_events WHERE id_events = :id_events", array(
                    ":date_events" => $every_date_survey["date_events"],
                    ':validation_events' => 2,
                    ':id_events' => $value["id_events"]
                ));
            }
        }
    }
}

// annuler un evenement quand c'est le sien
if (isset($_POST["submit_cancel_event"])) {
    $delete_event_user = execute('DELETE FROM events 
    WHERE id_events = "' . $_GET["event"] . '"');

    $delete_event_user = execute('DELETE FROM rejoin 
    WHERE id_events = "' . $_GET["event"] . '"');
    header("location: dashbord.php");
}

if (!isset($_SESSION["connected"])) {
    if ($_SERVER["SCRIPT_NAME"] === "/projet-php/createEvent.php" || $_SERVER["SCRIPT_NAME"] === "/projet-php/profil.php" || $_SERVER["SCRIPT_NAME"] === "/projet-php/listUsers.php") {
        header("location: login.php");
    }
}
