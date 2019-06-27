<?php require_once("includes/header.php"); ?>

<div class="signup-container">
    <form action="" method="POST" class="signup-box">
        <h1>Signup</h1>
        <div class="border"></div>
        <div class="signup">
            <div class="user-name">
                <input class="signup-info" type="text" name="nom" placeholder="Nom">
                <input class="signup-info" type="text" name="prenom" placeholder="Prénom">
            </div>

            <div class="user-adress">
                <input class="signup-info" type="text" name="adresse" placeholder="Rue">
                <input class="signup-info" type="text" name="ville" placeholder="Ville">
                <input class="signup-info" type="text" name="code" placeholder="Code postal">
            </div>

            <div class="user-infos">

                <SELECT class="signup-info special " name="age" size="1">
                    <OPTION> Age
                        <?php for ($i = 16; $i <= 100; $i++) : ?>
                        <OPTION> <?= $i;
                            endfor ?>
                </SELECT>

                <SELECT class="signup-info special" name="poid" size="1">
                    <OPTION> Poid(kg)
                        <?php for ($i = 40; $i <= 150; $i++) : ?>
                        <OPTION> <?= $i;
                            endfor ?>
                </SELECT>

                <SELECT class="signup-info special" name="taille" size="1">
                    <OPTION> Taille(cm)
                        <?php for ($i = 100; $i <= 230; $i++) : ?>
                        <OPTION> <?= $i;
                            endfor ?>
                </SELECT>


            </div>

            <div class="user-contact">
                <input class="signup-info" type="text" name="email" placeholder="Mail">
                <input class="signup-info" type="text" name="tel" placeholder="N° de Téléphone">
            </div>

            <div class="user-password">
                <input class="signup-password" type="password" name="mdp" placeholder="Password">
                <input class="signup-password" type="password" name="verification" placeholder="Confirmer le password">
            </div>

            <input class="signup-submit" type="submit" value="Signup" name="submit">
        </div>
    </form>
</div>
<?php require_once("includes/footer.php"); ?>