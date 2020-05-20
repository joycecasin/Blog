<?php include ('includes/header.php'); ?>
<?php
if (!$session->is_signed_in()){
    redirect("sign-in.php");
}
?>



<?php include ('includes/sidebar.php'); ?>
<?php include ('includes/content.php'); ?>
<?php include ('includes/footer.php'); ?>




