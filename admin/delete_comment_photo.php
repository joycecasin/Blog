<?php
include("includes/header.php");
// controleren of men is ingelogd
if (!$session->is_signed_in()){
    redirect('login.php');
}
//Controle of het id van de photo die we willen verwijderen meegegeven is naar deze pagina
// Geen id meegegeven wordt de gebruiker terug gestuurd naar overzichtspagina van de foto's
if (empty($_GET['id'])){
    redirect('comments.php');
}
// Wel een id meegegeven, gaan we de foto opvragen uit de database en verwijderen
$comment = Comment::find_by_id($_GET['id']);
if ($comment){
    $comment->delete();
    redirect('comments_photo.php?id={$comment->photo_id}');
}else{
    redirect('comments_photo.php?id={$comment->photo_id}');
}
include ("includes/sidebar.php");
include ("includes/content-top.php");
?>
<h1>Welkom op de delete comment pagina</h1>
<?php include("includes/footer.php"); ?>
