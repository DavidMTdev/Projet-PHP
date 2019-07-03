<?php require_once("include/header.php") ?>

<!-- rechercher un utilisateur -->
<div class="display-flex-center">
    <div class="event-title-container">
        <h1>Dashboard</h1>
        <div class="border"></div>
    </div>
</div>
<div>
    <form action="" method="post" class="">
        <div class="display-flex-center">
            <div class="userlist-search-container">
                <input type="search" name="search" placeholder="Recherche..." class="search-input">
                <button type="submit" name="submit_listUsers" class="listuser-submit-button">Rechercher</button>
            </div>
        </div>
    </form>

    <?php if (empty($listUsers)) : ?>
        <p>Aucun utilisateur trouvé</p>
    <?php else : ?>
        <form action="" method="get">
            <div class="userlist-container">
                <?php foreach ($listUsers as $key => $value) : ?>
                    <div class="user-infos">
                        <a href=<?= "profil?user=" . $value["id_user"] ?> class="user-infos">
                            <img class="user-img" src=<?= "upload/" . $value["id_user"] . "/profil/" . $value["picture_u"] ?> alt=""><?= $value["name_u"] . " " . $value["first_name_u"] ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    <?php endif; ?>
</div>

<!-- rechercher un event -->
<div>
    <div class="display-flex-center">
        <div class="event-title-container">
            <h1>Evénements Public</h1>
            <div class="border"></div>
        </div>
    </div>
    <form action="" method="post">
        <div class="display-flex-center">
            <div class="userlist-search-container">
                <input type="search" name="search_event" placeholder="Recherche..." class="search-input">
                <button type="submit" class="listuser-submit-button">Rechercher</button>
            </div>
        </div>
        <?php if (empty($listEventPublic)) : ?>
            <p>Aucun Event trouvé</p>
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

<!-- liste des events de l'utilisateur -->
<div>
    <div class="display-flex-center">
        <div class="event-title-container">
            <h1>Vos événements</h1>
            <div class="border"></div>
        </div>
    </div>
    <form action="/projet-php/list-event.php" method="get">
        <?php if (empty($listEventUser)) : ?>
            <p>Aucun Event trouvé</p>
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
            <input type="hidden" name="user" value=<?= $_GET['user'] ?>>
            <button type="submit">Tout voir</button>
        </form>
    <?php endif; ?>
</div>

<?php require_once("include/footer.php") ?>