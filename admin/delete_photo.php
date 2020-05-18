<?php
include ("includes/header.php");
// controleren of men is ingelogd
if (!$session->is_signed_in()){
    redirect('login.php');
}
//Controle of het id van de photo die we willen verwijderen meegegeven is naar deze pagina
// Geen id meegegeven wordt de gebruiker terug gestuurd naar overzichtspagina van de foto's
if (empty($_GET['id'])){
    redirect('photos.php');
}
// Wel een id meegegeven, gaan we de foto opvragen uit de database en verwijderen
$photo = Photo::find_by_id($_GET['id']);
if ($photo){
    $photo->delete_photo();
    redirect('photos.php');
}else{
    redirect('photos.php');
}
include ("includes/sidebar.php");
include ("includes/content-top.php");
?>
<h1>Welkom op de delete foto pagina</h1>
<?php include ("includes/footer.php"); ?>
