<?php require_once("include/header.php");
not_validate_event_privé(); ?>

<div class="display-flex-center">
    <div class="event-title-container">
        <h1><?= $event["title"] ?></h1>
        <div class="border"></div>
    </div>
</div>

<div class="event-info description">
    <h3>Description :</h3>
    <?= $event["description_e"] ?>
</div>
<?php if ($event["validation_events"] == 2) : ?>
    <div>Date de l'evenement : <?= $event["date_events"] ?></div>
<?php elseif ($event["validation_events"] == 1) :
    if (!empty($rejoin)) :
        if ($rejoin["id_user"] == $_SESSION["login"]) :
            ?>
            <form action="" method="post">
                <h3>Proposition de dates (1 seule case a cocher)</h3>
                <div class="date-container">
                    <?php foreach ($survey_date as $key => $value) : ?>
                        <div class="event-date">
                            <?php echo $value["date_events"] ?>
                            <?php if ($rejoin["to_vote"] != 0) : ?>
                                <p>Nombre de vote : <?= $value["number_votes"] ?></p>
                            <?php else : ?>
                                <input type="checkbox" name="event<?= $value["id_date_survey"] ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($rejoin["to_vote"] == 0) : ?>
                    <div class="display-flex-center">
                        <button type="submit" name="submit_survey_date" class="submit-button">Valider la date</button>
                    </div>
                <?php endif; ?>

            </form>
            <div>
                <h3>Deadline :</h3>
                <?= $event["deadline"] ?>
            </div>
        <?php endif;
    endif;
endif; ?>


<div>
    <h3>Confidentialité :</h3>
    <?php if ($event["public"] == 0) : ?>
        Public
    <?php else : ?>
        Privé
    <?php endif; ?>
</div>

<?php if (!empty($rejoin)) : ?>
    <!-- // var_dump($rejoin["statut"]); -->
    <div class="display-flex-center">
        <?php if ($rejoin["statut"] == 0) : ?>

            <form action="" method="post">
                <button type="submit" name="submit_signup_event_privé" >S'inscrire</button>
            </form>
        <?php else : ?>
            <form action="" method="post">
                <button type="submit" name="submit_unsignup_event" >Se désinscrire</button>
            </form>
        <?php endif;
    else : ?>
        <form action="" method="post">
            <button type="submit" name="submit_signup_event_public" >S'inscrire</button>
        </form>
    <?php endif; ?>

    <?php if ($event["id_user"] == $_SESSION["login"]) : ?>
        <form action="" method="post">
            <button type="submit" name="submit_cancel_event" >Annuler l'événement</button>
        </form>
    <?php endif; ?>
</div>
<?php require_once("include/footer.php") ?>