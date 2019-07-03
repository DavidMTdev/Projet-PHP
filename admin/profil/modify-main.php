<?php require_once("../../include/header.php") ?>

<div class="display-flex-center">
    <div class="modify-title-container">
        <h1>Modifier vos informations personelles</h1>
        <div class="border"></div>
    </div>
</div>

<form action="" method="post" enctype="multipart/form-data" class="modify-infos">
    <div class="display-flex-center">
        <div class="modify-infos-container">
            <input type="file" name="image" id="" class="modify-info-input">
            <input type="text" name="firstname" id="" placeholder="Prénom" class="modify-info-input">
            <input type="text" name="lastname" id="" placeholder="Nom" class="modify-info-input">
            <SELECT name="age" size="1" class="modify-info-input">
                <OPTION> Age
                    <?php for ($i = 16; $i <= 100; $i++) : ?>
                    <OPTION><?= $i ?>
                    <?php endfor ?>
            </SELECT>
            <textarea name="description" id="" cols="30" rows="10" class="modify-description-input"></textarea>
            <button type="submit" class="modify-submit-button">Valider</button>
        </div>
    </div>
</form>

<?php require_once("../../include/footer.php") ?>