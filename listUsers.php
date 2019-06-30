<?php require_once("include/header.php");
if (!isset($_SESSION["login"])) {
    header("location: login.php");
};
if (!empty($last_id_event_user)) {
    $last_id_event_user = $id_event_user[count($id_event_user) - 1];
    if ($last_id_event_user["public"] == 0) {
        $update = execute("UPDATE events SET validation_events = :validation_events WHERE id_events = :id_events", array(
            ':id_events' => $last_id_event_user["id_events"],
            ':validation_events' => 1
        ));
        header("location: home.php");
    }
}
?>

<form action="" method="post">
    <input type="search" name="search" placeholder="Recherche...">
    <button type="submit" name="submit_listUsers">Rechercher</button>
</form>

<form action="" method="post">
    <?php if (empty($listUsers)) : ?>
        <p>Aucun utilisateur trouver</p>
    <?php else :
    foreach ($listUsers as $key => $value) :
        if ($_SESSION["login"] != $value["id_user"]) : ?>

                <li>
                    <img src="upload/<?= $value["id_user"] ?>/profil/<?= $value["picture_u"] ?>" alt="">
                    <?= $value["name_u"] ?>
                    <?= $value["first_name_u"] ?>
                    <?php if (!empty($last_id_event_user)) :
                        if ($last_id_event_user["validation_events"] == 0) : ?>
                            <input type="checkbox" name="<?= $value["id_user"] ?>">
                        </li>
                    <?php endif;
            endif;
        endif;
    endforeach;
    if (!empty($last_id_event_user)) :
        if ($last_id_event_user["validation_events"] == 0) : ?>
                <button type="submit" name="submit_create_event_add_users">Ajouter</button>
            <?php endif;
    endif;
endif; ?>
</form>

<?php if (!empty($last_id_event_user)) :
    if ($last_id_event_user["validation_events"] == 0) :
        if (!empty($user_in_event)) : ?>
            <h3>Liste des invités</h3>
            <?php foreach ($user_in_event as $key => $value) : ?>
                <li><?= $value["name_u"] ?> <a href="removeInvite.php?id_user=<?= $value["id_user"] ?>&id_events=<?= $value["id_events"] ?>">X</a></li>
            <?php endforeach;
    endif;
endif;
endif; ?>

<?php if (!empty($last_id_event_user)) :
    if ($last_id_event_user["validation_events"] == 0) : ?>
        <form action="" method="post">
            <button type="submit" name="submit_invite">Valider</button>
        </form>
        <form action="createEvent.php" method="post">
            <button type="submit" name="submit_annuler_evenement">Annuler</button>
        </form>
    <?php endif;
endif; ?>





<?php require_once("include/footer.php") ?>