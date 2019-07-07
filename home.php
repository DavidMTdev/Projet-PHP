<?php require_once("include/header.php");
not_validate_event_privé(); ?>

<div class="title">
    <h1>Projet PHP</h1>
</div>
<div class="text">
    <h3>Bienvenue sur notre site</h3>
    <p>Vous aurez desormais la possibilité de créer un nouvel événement avec :
        <ul>
            <li>Un titre</li>
            <li>Une description</li>
            <li>Une deadline pour choisir la date</li>
            <li>Une liste de dates possibles</li>
            <li>Une liste d’invités</li>
            <li>Une visibilité (public, privé)</li>
            <li>De s’inscrire et se désinscrire d’un évenement</li>
        </ul>
    </p>
</div>
<div class="button">
    <a href="createEvent.php" class="btn">Événements</a>
</div>

<?php require_once("include/footer.php") ?>