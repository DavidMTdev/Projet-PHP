<div class="nav-header">

    <a href="home.php" class="nav-logo"><img src="images/logo.png" alt=""></a>

    <div class="nav">
        <ul class="nav-menu">
            <li><a href="food-supplements.php">Nutrition</a></li>
            <?php if (isset($_SESSION["connectedUser"]) && $_SESSION["connectedUser"]) :
                if (empty($premium[0]['id_premium'])) : ?>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="home.php#premium">Premium</a></li>
                <?php else : ?>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="coach.php">Coach</a></li>
                <?php endif; ?>
                <li><a href="meeting.php">Seance</a></li>

            <?php elseif (isset($_SESSION["connectedCoach"]) && $_SESSION["connectedCoach"]) : ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="client.php">Client</a></li>
            <?php endif; ?>
        </ul>

        <ul class="nav-login">
            <?php if (isset($_SESSION["connectedUser"]) && $_SESSION["connectedUser"] || isset($_SESSION["connectedCoach"]) && $_SESSION["connectedCoach"]) : ?>
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