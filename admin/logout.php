<?php require_once ("includes/header.php"); ?>
<?php
$session->logout();
redirect("sign-in.php");
?>
