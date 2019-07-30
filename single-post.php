<?php
require('./database/dbconnect.php');
$post_id = $_GET['post_id'];

$query1 = 'SELECT * FROM posts WHERE id = :post_id';
$query2 = 'SELECT * FROM comments WHERE post_id = :post_id';

$stmt1 = $connection->prepare($query1);
$stmt2 = $connection->prepare($query2);

$stmt1->bindParam(':post_id', $post_id);
$stmt2->bindParam(':post_id', $post_id);

$stmt1->execute();
$stmt2->execute();

$stmt1->setFetchMode(PDO::FETCH_ASSOC);
$stmt2->setFetchMode(PDO::FETCH_ASSOC);

$post = $stmt1->fetch();
$comments = $stmt2->fetchAll();


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

                <button type="button" class="btn btn-default" id="show-hide-btn">Hide Comments</button>

                <div class="comments" id="comment-section">
                    <ul>
                        <?php foreach ($comments as $comm) { ?>
                            <li><strong><?php echo $comm['author'] . ': '; ?></strong><?php echo $comm['text']; ?></li>
                            <hr>
                        <?php } ?>
                    </ul>
                </div>

            </div><!-- /.blog-main -->
            <?php include('./templates/sidebar.php'); ?>
        </div><!-- /.row -->

    </main><!-- /.container -->

    <?php include('./templates/footer.php') ?>

    <script type="text/javascript">
        const showHideBtn = document.getElementById("show-hide-btn");
        const comments = document.getElementById("comment-section");

        showHideBtn.addEventListener("click", function() {
            if (comments.style.display === "block") {
                comments.style.display = "none";
                showHideBtn.innerHTML = "Show Comments";
            } else {
                comments.style.display = "block";
                showHideBtn.innerHTML = "Hide Comments";
            }
        });
    </script>

</body>

</html>