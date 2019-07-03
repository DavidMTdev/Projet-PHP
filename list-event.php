<?php require_once("include/header.php") ?>

<!-- liste des events de l'utilisateur -->
<div>
    <h2>event du user</h2>
    <?php if (empty($listEventUser)) : ?>
        <p>Aucun Event trouver</p>
    <?php else : ?>
        <?php foreach ($listEventUser as $key => $value) : ?>
            <div>
                <a href=<?= "event.php?event=" . $value["id_events"] ?>>
                    <div><?= $value["title"] ?></div>
                    <div><?= $value["deadline"] ?></div>
                    <div>
                        <?php if ($value["public"] == 0) : ?>
                            publique
                        <?php else : ?>
                            privé
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once("include/footer.php") ?>