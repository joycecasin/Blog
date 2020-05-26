<?php
include ("includes/header.php");
// controleren of men is ingelogd
if (!$session->is_signed_in()){
    redirect('sign-in.php');
}
//Controle of het id van de user die we willen verwijderen meegegeven is naar deze pagina
// Geen id meegegeven wordt de gebruiker terug gestuurd naar overzichtspagina van de foto's
if (empty($_GET['id'])){
    redirect('users.php');
}
// Wel een id meegegeven, gaan we de foto opvragen uit de database en verwijderen
$user = User::find_by_id($_GET['id']);
if ($user){
    $user->delete();
    redirect('users.php');
}else{
    redirect('users.php');
}
include ("includes/sidebar.php");
include ("includes/content-top.php");
?>
<h1>Welkom op de delete user pagina</h1>
<?php include ("includes/footer.php"); ?>
