<?php include("includes/header.php");
// Enkel personen die zijn ingelogd mogen deze pagina zien
if (!$session->is_signed_in()){
    redirect('login.php');
}
$photos = Photo::find_all();


?>


<?php include ("includes/sidebar.php"); ?>

<?php include ("includes/content-top.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>PHOTOS</h2>
            <table class="table table-header">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Caption</th>
                    <th>File</th>
                    <th>Alternate text</th>
                    <th>Size</th>
                    <th>Comments</th>
                    <th>Wijzigen?</th>
                    <!-- Verwijderen van een foto -->
                    <th>DELETE?</th>
                    <th>View?</th>
                    <th>Add Comment</th>
                </tr>
                </thead>
                <tbody>
<!--                Alle fotos bekijken-->
                <?php
                foreach ($photos as $photo):
                ?>
                <tr>
                    <td><img src="<?php echo $photo->picture_path(); ?>" height="62" width="62" alt=""></td>
                    <td><?php echo $photo->id;?></td>
                    <td><?php echo $photo->tittle; ?></td>
                    <td><?php echo $photo->caption; ?></td>
                    <td><?php echo $photo->filename; ?></td>
                    <td><?php echo $photo->alternate_text; ?></td>
                    <td><?php echo $photo->size;?></td>
                    <td><a href="comments_photo.php?id=<?php echo $photo->id; ?>">
                            <?php
                            $comments = Comment::find_the_comment($photo->id);
                            echo count($comments);
                            ?>
                        </a></td>
                    <td><a href="edit_photo.php?id=<?php echo $photo->id; ?>" class="btn btn-danger rounded-0"><i class="fas fa-edit"></i></a></td>
                    <!-- Verwijderen van foto -->
                    <td><a href="delete_photo.php?id=<?php echo $photo->id; ?>" class="btn btn-danger rounded-0"><i class="fas fa-trash-alt"></i></a></td>
                    <td><a href="../photo.php?id=<?php echo $photo->id; ?>" class="btn btn-danger rounded-0"><i class="fas fa-eye"></i></a></td>
                    <td><a href="edit_comment.php" class="btn btn-primary rounded-0"><i class="fas fa-commment"></i>Add comment</a></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php //include ("includes/content.php"); ?>

<?php include ("includes/footer.php"); ?>

