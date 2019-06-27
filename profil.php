<?php require_once("include/header.php") ?>

<div class="profil">
    <div class="profil-presentation">
        <div class="profil-image">
            <img class="js-button-img" src="" alt="">
        </div>
        <div class="profil-principal">
            <h2>NOM Prénom</h2>
            <h3>Age ans</h3>
            <br>
            <h3>Description</h3>
            <p>Description de l'utilisateur</p>
            <div class="modify-principal-button-container">
                <button class="presentation-modify js-button-principal">Modifier</button>
            </div>
        </div>
    </div>
    <div class="profil-contact">
        <div class="contact">
            <h2>Contact</h2>
            <div class="border"></div>
            <ul>
                <li><img src="icons/icons8-sonnerie-phonelink-24.png" alt="">Téléphone</li>
                <li><img src="icons/icons8-email-filled-24.png" alt="">Mail</li>
            </ul>

            <div class="modify-information-button-container">
                <button class="contact-modify js-button-contact">Modifier</button>
            </div>
        </div>

    </div>
</div>

<div class="profil-address">
    <div class="address">
        <h2>Adresse</h2>
        <div class="border"></div>
        <ul>
            <li><img src="icons/icons8-adresse-24.png" alt="">Adresse</li>
            <li><img src="icons/icons8-epingle-de-carte-24.png" alt="">Code postal & Ville </li>
        </ul>

        <div class="modify-information-button-container">
            <button class="address-modify js-button-adress">Modifier</button>
        </div>

    </div>
</div>

<div class="profil-password">
    <div class="password">
        <h2>Informations confidentialité</h2>
        <div class="border"></div>
        <ul>
            <li><img src="icons/icons8-mot-de-passe-24.png" alt="">**********</li>
        </ul>
        <div class="modify-information-button-container">
            <button class="password-modify js-button-password">Modifier votre mot de passe</button>
        </div>
    </div>
</div>

<?php require_once("include/footer.php") ?>