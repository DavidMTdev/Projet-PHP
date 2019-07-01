<?php require_once("include/header.php") ?>

<div>
    <form action="" method="post">
        <input type="search" name="search" placeholder="Recherche...">
        <button type="submit" name="submit_listUsers">rechercher</button>
    </form>

    <?php if (empty($listUsers)) : ?>
        <p>Aucun utilisateur trouver</p>
    <?php else : ?>
        <form action="" method="get">
            <?php foreach ($listUsers as $key => $value) : ?>
                <div>
                    <a href=<?= "profil?user=" . $value["id_user"] ?>>
                        <img src=<?= "upload/" . $value["id_user"] . "/profil/" . $value["picture_u"] ?> alt=""><?= $value["name_u"] . " " . $value["first_name_u"] ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </form>
    <?php endif; ?>
</div>

<div>
    <h2>event public</h2>
    <form action="" method="post">
        <input type="search" name="search_event" placeholder="Recherche...">
        <button type="submit">rechercher</button>
        <?php if (empty($listEventPublic)) : ?>
            <p>Aucun Event trouver</p>
        <?php else : ?>
            <?php $count = 0; ?>
            <?php foreach ($listEventPublic as $key => $value) : ?>
                <div>
                    <a href=<?= "event.php?event=" . $value["id_events"] ?>>
                        <div><?= $value["title"] ?></div>
                        <div><?= $value["deadline"] ?></div>
                        <div><?= $value["description_e"] ?></div>
                    </a>
                </div>
                <?php if ($count == 4) {
                    break;
                } else {
                    $count++;
                } ?>
            <?php endforeach; ?>
        </form>
    <?php endif; ?>
</div>

<div>
    <h2>event du user</h2>
    <form action="" method="post">
        <?php if (empty($listEventPublic)) : ?>
            <p>Aucun Event trouver</p>
        <?php else : ?>
            <?php $count = 0; ?>
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
                <?php if ($count == 4) {
                    break;
                } else {
                    $count++;
                } ?>
            <?php endforeach; ?>
            <button type="submit">Tout voir</button>
        </form>
    <?php endif; ?>
</div>
<?php require_once("include/footer.php") ?>