<?php require_once("include/header.php");
if (!empty($last_id_event_user)) {
    $last_id_event_user = $id_event_user[count($id_event_user) - 1];
    if ($last_id_event_user["validation_events"] == 0) {
        header("location: listUsers.php");
    }
}
?>
<div class="display-flex-center">
    <div class="create-event-title-container">
        <h1>Créer un événement</h1>
        <div class="border"></div>
    </div>
</div>

<form action="" method="post" class="event-infos">
    <div class="display-flex-center">
        <div class="event-infos-container">
            <input type="text" name="title" placeholder="Titre" class="event-info-input">
            <textarea name="description_e" placeholder="Description" cols="30" rows="10" class="event-description-input"></textarea>
            <h3>Deadline du choix de la date</h3>
            <input type="date" name="deadline" placeholder="Deadline" class="event-info-input">
            <h3>Proposition date N°1</h3>
            <input type="datetime-local" name="date1" placeholder="1er date" class="event-info-input">
            <h3>Proposition date N°2</h3>
            <input type="datetime-local" name="date2" placeholder="2eme date" class="event-info-input">
            <h3>Proposition date N°3</h3>
            <input type="datetime-local" name="date3" placeholder="3eme date" class="event-info-input">
            <div class="checkbox-container">
                <input type="checkbox" name="privé">
                <label for="">privé</label>
            </div>
            <button type="submit" name="submit_create_event" class="event-submit-button">Continuer</button>
        </div>
    </div>
</form>

<?php require_once("include/footer.php") ?>