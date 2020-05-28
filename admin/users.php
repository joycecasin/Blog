<?php include("includes/header.php");
// Enkel personen die zijn ingelogd mogen deze pagina zien
if (!$session->is_signed_in()){
    redirect('sign-in.php');
}
$users = User::find_all();

?>

<?php include ("includes/sidebar.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12" style="margin-left: 350px ; margin-top: 150px">
            <h2>USER</h2>
            <td><a href="add_user.php" class="btn btn-primary rounded-0"><i class="fas fa-user-plus"></i>User toevoegen </a></td>
            <table class="table table-header">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Username</th>
                    <th>Voornaam</th>
                    <th>Familienaam</th>
                    <th>Email</th>
                    <!--Wijzigen van user -->
                    <th>Wijzigen?</th>
                    <!-- Verwijderen van een user -->
                    <th>DELETE?</th>
                </tr>
                </thead>
                <tbody>
                <!--Alle users bekijken-->
                <?php
                foreach ($users as $user):
                    ?>
                    <tr>
                        <td><?php echo $user->id;?></td>
                        <td><img src="<?php echo $user->image_path_and_placeholder(); ?>" height="40" width="40" alt=""></td>
                        <td><?php echo $user->username; ?></td>
                        <td><?php echo $user->voornaam; ?></td>
                        <td><?php echo $user->familienaam; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td><a href="edit_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger rounded-0"><i class="fas fa-edit"></i></a></td>
                        <!-- Verwijderen van foto -->
                        <td><a href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger rounded-0"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include ("includes/footer.php"); ?>

