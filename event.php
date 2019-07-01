<?php require_once("include/header.php") ?>

<div><?= $event["title"] ?></div>
<div><?= $event["description_e"] ?></div>
<div><?= $event["date_events"] ?></div>
<div><?= $event["deadline"] ?></div>

<div>
    <?php if ($event["public"] == 0) : ?>
        publique
    <?php else : ?>
        privé
    <?php endif; ?>
</div>


<?php require_once("include/footer.php") ?>