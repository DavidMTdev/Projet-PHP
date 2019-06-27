<?php require_once("include/header.php") ?>

<div class="login-container">
    <form action="" method="POST" class="login-box">
        <h1>Login</h1>
        <div class="border"></div>
        <div class="login">
            <div class="user-infos">
                <input class="login-info" type="text" name="login" placeholder="Username">
                <input class="login-info" type="password" name="password" placeholder="Password">
                <input class="login-submit" type="submit" id="" value="Login">
                <a href="signup.php">Vous n'avez pas de compte créez en un !<br></a>
                <a href="">Mot de passe oublié ?<br> </a>
            </div>
        </div>
    </form>
</div>

<?php require_once("include/footer.php") ?>