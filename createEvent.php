<?php require_once("include/header.php") ?>

<form action="" method="post">
<input type="text" name="title" placeholder="titre">
<textarea name="description_e" placeholder="description" cols="30" rows="10"></textarea> 
<input type="datetime-local" name="date1" placeholder="1er date">
<input type="datetime-local" name="date2" placeholder="2eme date">
<input type="datetime-local" name="date3" placeholder="3eme date">
<input type="date" name="deadline" placeholder="deadline">
<input type="checkbox" name="privé">
<label for="">privé</label>
<button type="submit" name="submit_create_event">valider</button>
</form>

<?php require_once("include/footer.php") ?>