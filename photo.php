<?php
include("includes/header.php");
//require_once("admin/includes/init.php");

if (empty($_GET['id'])) {
    redirect('index.php');
}

// foto ophalen
$photo = Photo::find_by_id($_GET['id']);
//echo $photo->tittle;

// Eerst controleren we of wel comment aanwezig is
if (isset($_POST['submit'])) {
    //echo "Hello";
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);

    $new_comment = Comment::create_comment($photo->id, $author, $body);

    if ($new_comment && $new_comment->save()) {
        redirect("photo.php?id={$photo->id}");
    } else {
        $message = "There are some problems saving";
    }
} else {
    $author = "";
    $body = "";
}

$comment = Comment::find_the_comment($photo->id);
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="mt-4"><?php echo $photo->tittle; ?></h1>

            <!-- Author -->
            <p class="lead">
                by
                <a href="index.php">Blog OOP</a>
            </p>

            <hr>

            <!-- Date/Time -->
            <p>Posted on January 1, 2019 at 12:00 PM</p>

            <hr>

            <!-- Preview Image -->
            <img class="img-fluid rounded" src="<?php echo 'admin' . DS . $photo->picture_path(); ?>" width="300"
                 height="300" alt="">
            <hr>

            <!-- Post Content -->
            <p>
                <?php echo $photo->description; ?>
            </p>

            <hr>

            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Leave a Comment:</h5>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="author" class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="body" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <?php foreach ($comment as $comments): ?>
                <!-- Single Comment -->
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?php echo $comments->author; ?> on
                            photo <?php echo $comments->photo_id; ?></h5>
                        <p><?php echo $comments->body; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<?php
include("includes/footer.php");
?>
