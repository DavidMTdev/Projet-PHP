<?php
require_once("include/header.php") ;

$delete_rejoin_user = execute('DELETE FROM rejoin 
WHERE id_user = "' . $_GET["id_user"] . '"
AND id_events = "' . $_GET["id_events"] . '"');

header("location: listUsers.php");

?>