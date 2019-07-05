<?php require_once("include/header.php") ?>

<!-- liste des events de l'utilisateur -->
<div>
    <div class="display-flex-center">
        <div class="event-title-container">
            <h1>Vos événements</h1>
            <div class="border"></div>
        </div>
    </div>
    <?php if (empty($listEventUser)) : ?>
        <p>Aucun Event trouvé</p>
    <?php else : ?>
        <div class="event-container">
            <?php foreach ($listEventUser as $key => $value) : ?>
                <div class="event">
                    <a href=<?= "event.php?event=" . $value["id_events"] ?>>
                        <div class="event-info title">
                            <h3>Titre : </h3>
                            <?= $value["title"] ?>
                        </div>
                        <div class="event-info deadline">
                            <h3>Deadline :</h3>
                            <?= $value["deadline"] ?>
                        </div>
                        <div class="event-info confidentiality">
                            <h3>Confidentialité :</h3>
                            <?php if ($value["public"] == 0) : ?>
                                Public
                            <?php else : ?>
                                Privé
                            <?php endif; ?>
                        </div>

                    </a>

                </div>

            <?php endforeach; ?>

        </div>
    <?php endif; ?>
</div>

<?php require_once("include/footer.php") ?>