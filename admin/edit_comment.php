<?php include("includes/header.php");
// Enkel personen die zijn ingelogd mogen deze pagina zien
if (!$session->is_signed_in()) {
    redirect('login.php');
}
//Controleren of er een id binnenkomt
/*if (empty($_GET['id'])) {
    redirect('comments.php');
} else {*/
$comment = Comment::find_by_id($_GET['id']);
    if (isset($_POST['submit'])) {
        if ($comment) {
            $comment->author = $_POST['author'];
            $comment->body = $_POST['body'];
            $comment->update();
        }
    }


?>

<?php include("includes/sidebar.php"); ?>

<?php include("includes/content-top.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Welkom op de edit comment pagina</h2>
            <form action="edit_comment.php?id=<?php echo $comment->photo_id; ?>" method="post">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" name="author" class="form-control" value="<?php  /*echo $comment->author; */?>">
                    </div>
                    <div class="form-group">
                        <label for="body">Comment</label>
                        <textarea class="form-control" name="body" id="" cols="30"
                                  rows="10"><?php  /*echo $comment->body; */ ?></textarea>
                    </div>
                </div>
                <div class="info-box-update">
                    <input type="submit" name="submit" value="submit" class="btn btn-primary btn-lg">
                </div>
            </form>
        </div>
    </div>
</div>
<?php //include ("includes/content.php"); ?>

<?php include("includes/footer.php"); ?>


