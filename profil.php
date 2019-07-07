<?php require_once("include/header.php");
not_validate_event_privé(); ?>

<div class="profil">
    <div class="profil-presentation">
        <div class="profil-image">
            <img class="js-button-img" src=<?= $folder ?> alt="">
        </div>
        <div class="profil-principal">
            <h2><?= $user["name_u"] . " " . $user["first_name_u"] ?></h2>
            <h3><?= $user["age_u"] ?> ans</h3>
            <br>
            <h3>Description</h3>
            <p><?= $user["description_u"] ?></p>
            <?php if (isset($_SESSION["connected"]) && $_SESSION["login"] == $_GET["user"]) : ?>
                <div class="modify-principal-button-container">
                    <a href="admin/profil/modify-main.php" class="presentation-modify js-button-principal">Modifier</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="profil-contact">
        <div class="contact">
            <h2>Contact</h2>
            <div class="border"></div>
            <ul>
                <li><img src="icons/icons8-phonelink-ring-filled-24.png" alt=""><?= $user["phone_u"] ?></li>
                <li><img src="icons/icons8-email-filled-24.png" alt=""><?= $user["mail_u"] ?></li>
            </ul>
            <?php if (isset($_SESSION["connected"]) && $_SESSION["login"] == $_GET["user"]) : ?>
                <div class="modify-information-button-container">
                    <a href="admin/profil/modify-contact.php" class="contact-modify js-button-contact">Modifier</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="profil-address">
    <div class="address">
        <h2>Adresse</h2>
        <div class="border"></div>
        <ul>
            <li><img src="icons/icons8-address-24.png" alt=""><?= $user["adress_u"] ?></li>
            <li><img src="icons/icons8-map-pin-24.png" alt=""><?= $user["postal_code_u"] . " " . $user["city_u"] ?></li>
        </ul>
        <?php if (isset($_SESSION["connected"]) && $_SESSION["login"] == $_GET["user"]) : ?>
            <div class="modify-information-button-container">
                <a href="admin/profil/modify-address.php" class="address-modify js-button-adress">Modifier</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="profil-password">
    <div class="password">
        <h2>Informations confidentialité</h2>
        <div class="border"></div>
        <ul>
            <li><img src="icons/icons8-password-reset-24.png" alt="">**********</li>
        </ul>
        <?php if (isset($_SESSION["connected"]) && $_SESSION["login"] == $_GET["user"]) : ?>
            <div class="modify-information-button-container">
                <a href="admin/profil/modify-password.php" class="password-modify js-button-password">Modifier votre mot de passe</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once("include/footer.php") ?>