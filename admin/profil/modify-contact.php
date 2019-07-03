<?php require_once("../../include/header.php") ?>

<div class="display-flex-center">
    <div class="modify-title-container">
        <h1>Modifier vos informations de contact</h1>
        <div class="border"></div>
    </div>
</div>

<form action="" method="post" enctype="multipart/form-data" class="modify-infos">
    <div class="display-flex-center">
        <div class="modify-infos-container">
            <input type="text" name="phone" id="" placeholder="N° de Téléphone" class="modify-info-input">
            <input type="text" name="mail" id="" placeholder="Mail" class="modify-info-input">
            <button type="submit" class="modify-submit-button">Valider</button>
        </div>
    </div>
</form>

<?php require_once("../../include/footer.php") ?>