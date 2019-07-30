<?php
require('./database/dbconnect.php');
$post_id = $_GET['post_id'];

$query = 'SELECT * FROM posts WHERE id = :post_id';
$stmt = $connection->prepare($query);
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$post = $stmt->fetch();


?>

<!doctype html>
<html lang="en">

<head>
    <?php include('./templates/head.php'); ?>
</head>

<body>

    <?php include('./templates/header.php'); ?>

    <main role="main" class="container">

        <div class="row">

            <div class="col-sm-8 blog-main">

                <div class="blog-post">
                    <a href="./single-post.php?post_id=<?php echo $post['id']; ?>">
                        <h2 class="blog-post-title"><?php echo $post['title'] ?></h2>
                    </a>
                    <p class="blog-post-meta"><?php echo $post['created_at'] . " "; ?> by <a href="#"><?php echo " " . $post['author']; ?></a></p>
                    <hr>
                    <p><?php echo $post['body']; ?></p>

                </div>

            </div><!-- /.blog-main -->
            <?php include('./templates/sidebar.php'); ?>
        </div><!-- /.row -->

    </main><!-- /.container -->

    <?php include('./templates/footer.php') ?>
</body>

</html>