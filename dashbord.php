<?php require_once("include/header.php") ?>

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

<?php require_once("include/footer.php") ?>