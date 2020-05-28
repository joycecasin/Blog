<?php include("includes/header.php");
// Enkel personen die zijn ingelogd mogen deze pagina zien
if (!$session->is_signed_in()){
    redirect('sign-in.php');
}

$user = new User();
if (isset($_POST['submit'])){
    if ($user){
        $user->username = $_POST['username'];
        $user->voornaam = $_POST['voornaam'];
        $user->familienaam = $_POST['familienaam'];
        $user->paswoord = $_POST['paswoord'];
        $user->email = $_POST['email'];
        $user->set_file($_FILES['user_foto']);
        $user->save_user_and_image();


    }
    redirect('users.php');
}


?>


<?php include ("includes/sidebar.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 style="margin-left: 350px ; margin-top: 100px">Welkom op de add user pagina</h2>
            <form action="add_user.php" method="post" enctype="multipart/form-data">
                <div class="col-md-8" style="margin-left: 350px">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="voornaam">Voornaam</label>
                        <input type="text" name="voornaam" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="familienaam">Familienaam</label>
                        <input type="text" name="familienaam" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="paswoord">Paswoord</label>
                        <input type="password" class="form-control" name="paswoord">
                    </div>
                    <div class="form-group">
                        <label for="file">User image</label>
                        <input type="file" class="form-control" name="user_foto">
                    </div>
                    <input type="submit" name="submit" value="Add User" class="btn btn-primary">
                </div>
            </form>

        </div>
    </div>
</div>


<?php include ("includes/footer.php"); ?>


