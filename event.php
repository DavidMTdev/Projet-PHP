<?php require_once("include/header.php") ?>

<div><?= $event["title"] ?></div>
<div><?= $event["description_e"] ?></div>
<?php if ($event["validation_events"] == 2) : ?>
    <div><?= $event["date_events"] ?></div>
<?php elseif ($event["validation_events"] == 1) :
    if (!empty($rejoin)) :
        if ($rejoin["id_user"] == $_SESSION["login"]) :
            ?>
            <form action="" method="post">
                <?php foreach ($survey_date as $key => $value) :
                    echo $value["date_events"] ?>
                    <?php if($rejoin["to_vote"] == 1): ?>
                    <p>nombre de vote : <?= $value["number_votes"] ?></p>
                    <?php else : ?>
                    <input type="checkbox" name="event<?= $value["id_date_survey"] ?>">
                <?php endif; endforeach; ?>
                <?php if($rejoin["to_vote"] != 1): ?>
                <button type="submit" name="submit_survey_date">Valider la date</button>
                <?php endif; ?>

            </form>
            <div>Deadline <?= $event["deadline"] ?></div>
        <?php endif;
    endif;
endif; ?>


<div>
    <?php if ($event["public"] == 0) : ?>
        publique
    <?php else : ?>
        privé
    <?php endif; ?>
</div>

<?php if (!empty($rejoin)) :
    var_dump($rejoin["statut"]);
    if ($rejoin["statut"] == 0) :?>

        <form action="" method="post">
            <button type="submit" name="submit_signup_event_privé">S'inscrire</button>
        </form>
    <?php else : ?>
        <form action="" method="post">
            <button type="submit" name="submit_unsignup_event">Se desinscrire</button>
        </form>
    <?php endif;
else : ?>
    <form action="" method="post">
        <button type="submit" name="submit_signup_event_public">S'inscrire</button>
    </form>
<?php endif; ?>

<?php require_once("include/footer.php") ?>