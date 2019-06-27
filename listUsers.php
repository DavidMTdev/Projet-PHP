<?php require_once("include/header.php") ?>

<form action="" method="post">
<input type="search" name="search" placeholder="Recherche...">
<button type="submit" name="submit_listUsers">valider</button>
</form>

<?php if (empty($listUsers)): ?>
<p>Aucun utilisateur trouver</p>
<?php else :
foreach ($listUsers as $key => $value): ?>
<li><?= $value["name_u"] ?></li>
<?php endforeach; endif; ?>

<?php require_once("include/footer.php") ?>