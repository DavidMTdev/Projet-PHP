<?php require_once("../../include/header.php") ?>

<div class="display-flex-center">
    <div class="modify-title-container">
        <h1>Modifier votre mot de passe</h1>
        <div class="border"></div>
    </div>
</div>

<form action="" method="post" enctype="multipart/form-data" class="modify-infos">
    <div class="display-flex-center">
        <div class="modify-infos-container">
            <input type="password" name="password" id="" placeholder="Password" class="modify-info-input">
            <input class="signup-password modify-info-input" type="password" name="password_verif" placeholder="Confirmer le password">
            <button type="submit" class="modify-submit-button">Valider</button>
        </div>
    </div>
</form>

<?php require_once("../../include/footer.php") ?>