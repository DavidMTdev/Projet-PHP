<div class="nav-header">
    <div class="nav">
        <ul class="nav-menu">
            <li><a href="/projet-php/home.php">Accueil</a></li>
            <li><a href="/projet-php/createEvent.php">Événements</a></li>
            <?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]) : ?>
                <li><a href=<?= "/projet-php/dashbord.php?user=" . $_SESSION['login'] ?>>Dashbord</a></li>
                <li><a href=<?= "/projet-php/profil.php?user=" . $_SESSION["login"] ?>>Profil</a></li>
            <?php endif; ?>
        </ul>
        <ul class="nav-login">
            <?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]) : ?>
                <li><a href="/projet-php/disconnection.php">Deconnexion</a></li>
            <?php else : ?>
                <li><a href="/projet-php/login.php">Se connecter</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="menu-burger">
        <img src="icons/icons8-menu-70.png" alt="">
    </div>
</div>