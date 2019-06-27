<?php require_once("../../include/header.php") ?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="image" id="">
    <input type="text" name="firstname" id="" placeholder="Prénom">
    <input type="text" name="lastname" id="" placeholder="Nom">
    <SELECT class="" name="age" size="1">
        <OPTION> Age
            <?php for ($i = 16; $i <= 100; $i++) : ?>
            <OPTION><?= $i ?>
            <?php endfor ?>
    </SELECT>
    <textarea name="description" id="" cols="30" rows="10"></textarea>
    <button type="submit">Valider</button>
</form>

<?php require_once("../../include/footer.php") ?>