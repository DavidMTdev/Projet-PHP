<?php require_once("../../include/header.php") ?>

<div class="display-flex-center">
    <div class="modify-title-container">
        <h1>Modifier votre adresse</h1>
        <div class="border"></div>
    </div>
</div>

<form action="" method="post" enctype="multipart/form-data" class="modify-infos">
    <div class="display-flex-center">
        <div class="modify-infos-container">
            <input type="text" name="address" id="" placeholder="Rue" class="modify-info-input">
            <input type="text" name="city" id="" placeholder="Ville" class="modify-info-input">
            <input type="text" name="postalcode" id="" placeholder="Code postal" class="modify-info-input">
            <button type="submit" class="modify-submit-button">Valider</button>
        </div>
    </div>
</form>

<?php require_once("../../include/footer.php") ?>