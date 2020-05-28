<?php include("includes/header.php");
// Enkel personen die zijn ingelogd mogen deze pagina zien
if (!$session->is_signed_in()) {
    redirect('sign-in.php');
}
if (empty($_GET['id'])) {
    redirect('users.php');
}

$user = User::find_by_id($_GET['id']);

if (isset($_POST['update'])) {
    if ($user) {
        $user->username = $_POST['username'];
        $user->voornaam = $_POST['voornaam'];
        $user->familienaam = $_POST['familienaam'];
        $user->paswoord = $_POST['paswoord'];
        $user->email = $_POST['email'];
        //$user->set_file($_FILES['user_foto']);
        //$user->save_user_and_image();
        if (empty($_FILES['user_foto'])) {
            $user->save();
        } else {
            $user->set_file($_FILES['user_foto']);
            $user->save_user_and_image();
            $user->save();
            redirect('edit_user.php?id={$user->id}');
        }
    }
    redirect('users.php');
}


?>


<?php include("includes/sidebar.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 style="margin-left: 350px ; margin-top: 50px">Welkom op de wijzig user pagina</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8" style="margin-left: 350px">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control"
                                   value="<?php echo $user->username; ?>">
                        </div>
                        <div class="form-group">
                            <label for="voornaam">Voornaam</label>
                            <input type="text" name="voornaam" class="form-control"
                                   value="<?php echo $user->voornaam; ?>">
                        </div>
                        <div class="form-group">
                            <label for="familienaam">Familienaam</label>
                            <input type="text" name="familienaam" class="form-control"
                                   value="<?php echo $user->familienaam; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $user->email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="paswoord">Paswoord</label>
                            <input type="password" class="form-control" name="paswoord"
                                   value="<?php echo $user->paswoord; ?>">
                        </div>
                        <div class="form-group">
                            <img src="<?php echo $user->image_path_and_placeholder(); ?>" alt="" class="img-fluit"
                                 width="40" height="40">
                            <label for="file">User image</label>
                            <input type="file" class="form-control" name="user_foto">
                        </div>
                        <input type="submit" name="update" value="Upload user" class="btn btn-primary">
                        <a href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger">Delete User?</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>


