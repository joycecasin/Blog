<?php include("includes/header.php"); ?>
<?php
//kijken of we ingelogd zijn, indien niet ingelogd doorgestuurd naar loginpagina
if (!$session->is_signed_in()){
    redirect("login.php");

}

$aantalUsers = User::find_all();
$aantalComments = Comment::find_all();
$aantalPhotos = Photo::find_all();
?>

<?php include ("includes/sidebar.php"); ?>

<?php include ("includes/content-top.php"); ?>

<?php include ("includes/content.php"); ?>

<?php include ("includes/footer.php"); ?>


