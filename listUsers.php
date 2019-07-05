<?php require_once("include/header.php");

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


<div class="display-flex-center">
    <div class="userlist-title-container">
        <h1>Liste des utilisateurs</h1>
        <div class="border"></div>
    </div>
</div>

<form action="" method="post" class="userlist">
    <div class="display-flex-center">
        <div class="userlist-search-container">
            <input type="search" name="search" placeholder="Recherche..." class="search-input">
            <button type="submit" name="submit_listUsers" class="listuser-submit-button">Rechercher</button>
        </div>
    </div>
</form>

<form action="" method="post">
    <?php if (empty($listUsers)) : ?>
        <p>Aucun utilisateurs trouvés</p>
    <?php else : ?>
        <div class="userlist-container">
            <?php foreach ($listUsers as $key => $value) :
                if ($_SESSION["login"] != $value["id_user"]) : ?>

                    <li class="user-infos">
                        <img src="upload/<?= $value["id_user"] ?>/profil/<?= $value["picture_u"] ?>" alt="" class="user-img">
                        <?= $value["name_u"] ?>
                        <?= $value["first_name_u"] ?>
                        <?php if (!empty($last_id_event_user)) :
                            if ($last_id_event_user["validation_events"] == 0) : ?>
                                <input type="checkbox" name="<?= $value["id_user"] ?>" class="add-user-checkbox">
                            </li>
                        <?php endif;
                    endif;
                endif;
            endforeach; ?>
        </div>
        <?php if (!empty($last_id_event_user)) :
            if ($last_id_event_user["validation_events"] == 0) : ?>
                <div class="submit-button-container">
                    <button type="submit" name="submit_create_event_add_users" class="add-user-button">Ajouter</button>
                </div>
            <?php endif;
        endif;
    endif; ?>
</form>

<?php if (!empty($last_id_event_user)) :
    if ($last_id_event_user["validation_events"] == 0) :
        if (!empty($user_in_event)) : ?>
            <div class="display-flex-center">
                <div class="userlist-title-container">
                    <h1>Liste des invités</h1>
                    <div class="border"></div>
                </div>
            </div>
            <div class="guest-users">
                <?php foreach ($user_in_event as $key => $value) : ?>
                    <li><?= $value["name_u"] ?> <a class="remove-invite" href="removeInvite.php?id_user=<?= $value["id_user"] ?>&id_events=<?= $value["id_events"] ?>"><i class="fas fa-times"></i></a></li>
                <?php endforeach; ?>
            </div>
        <?php endif;
    endif;
endif; ?>

<?php if (!empty($last_id_event_user)) :
    if ($last_id_event_user["validation_events"] == 0) : ?>
        <div class="buttons-container">
            <form action="" method="post">
                <button type="submit" name="submit_invite" class="listuser-button submit"><i class="fas fa-check"></i></button>
            </form>
            <form action="createEvent.php" method="post">
                <button type="submit" name="submit_annuler_evenement" class="listuser-button cancel"><i class="fas fa-times"></i>

                </button>
            </form>
        </div>

    <?php endif;
endif; ?>

<?php require_once("include/footer.php") ?>