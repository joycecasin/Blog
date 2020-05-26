<?php require_once("includes/header.php");

/*
if (!$session->is_signed_in()){
    redirect('sign-in.php');
}*/

/*
$user = new User();
if (isset($_POST['submit'])){
    if ($user){
        $user->username = $_POST['username'];
        $user->paswoord = $_POST['paswoord'];
        $user->voornaam = $_POST['voornaam'];
        $user->familienaam = $_POST['familienaam'];
        $user->email = $_POST['email'];
        $user->save();
    }
}*/

require_once("includes/sidebar.php");

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Welkom op de add user pagina</h2>
            <form action="add_user.php" method="post">
                <div class="col-md-8" style="margin-left: 350px ; margin-top: 100px">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="paswoord">Paswoord</label>
                        <input type="password" name="paswoord" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="voornaam">Voornaam</label>
                        <input type="text" name="voornaam" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="familienaam">Familienaam</label>
                        <input type="text" name="familienaam" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="file">User Foto</label>
                        <input type="file" name="file" class="form-control" value="">
                    </div>
                    <input type="submit" name="submit" value="User Toevoegen" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once("includes/footer.php"); ?>