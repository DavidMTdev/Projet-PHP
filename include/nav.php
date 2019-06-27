<div class="nav-header">
    <div class="nav">
        <ul class="nav-menu">
            <li><a href="">Accueil</a></li>
            <li><a href="">A remplir</a></li>
            <li><a href="">Événements</a></li>
            <li><a href="">Profil</a></li>
        </ul>
        <ul class="nav-login">
            <?php if ($_SESSION["connected"]) : ?>
                <li><a href="disconnection.php">Deconnexion</a></li>
            <?php else : ?>
                <li><a href="login.php">Se connecter</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="menu-burger">
        <img src="icons/icons8-menu-70.png" alt="">
    </div>
</div>