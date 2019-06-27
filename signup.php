<?php require_once("include/header.php"); ?>

<div class="signup-container">
    <form action="" method="POST" class="signup-box">
        <h1>Signup</h1>
        <div class="border"></div>
        <div class="signup">
            <div class="user-name">
                <input class="signup-info" type="text" name="name" placeholder="Nom">
                <input class="signup-info" type="text" name="first-name" placeholder="Prénom">
            </div>

            <div class="user-adress">
                <input class="signup-info" type="text" name="adress" placeholder="Rue">
                <input class="signup-info" type="text" name="city" placeholder="Ville">
                <input class="signup-info" type="text" name="postal_code" placeholder="Code postal">
            </div>

            <div class="user-infos">

                <SELECT class="signup-info special " name="age" size="1">
                    <OPTION> Age
                        <?php for ($i = 16; $i <= 100; $i++) : ?>
                        <OPTION> <?= $i;
                            endfor ?>
                </SELECT>
            </div>

            <div class="user-contact">
                <input class="signup-info" type="text" name="mail" placeholder="Mail">
                <input class="signup-info" type="text" name="phone" placeholder="N° de Téléphone">
            </div>

            <div class="user-password">
                <input class="signup-password" type="password" name="password" placeholder="Password">
                <input class="signup-password" type="password" name="password_verif" placeholder="Confirmer le password">
            </div>

            <input class="signup-submit" type="submit" value="Signup" name="submit_signup">
        </div>
    </form>
</div>
<?php require_once("include/footer.php"); ?>