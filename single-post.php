<?php
require('./database/dbconnect.php');

$post_id = $_GET['post_id'];

$query1 =
    "SELECT posts.id AS id, posts.title AS title, posts.body AS body, 
posts.created_at AS created_at, users.firstName AS firstName, users.lastName as lastName
FROM posts 
LEFT JOIN users
ON posts.author = users.id WHERE posts.id = :post_id";

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
                    <p class="blog-post-meta"><?php echo $post['created_at'] . " "; ?> by <a href="#"><?php echo " " . $post['firstName'] . " " . $post['lastName']; ?></a></p>
                    <button type="button" id="del-post-btn" class="btn btn-primary">Delete Post</button>
                    <hr>
                    <p><?php echo $post['body']; ?></p>

                </div>

                <div class="alert alert-danger" id="alertBox">
                    <strong>Failed submit!</strong> Please fill out all remaining fields.
                </div>
                <h2>Add New Comment</h2>
                <div class="add-new-comment">
                    <form action="./create-comment.php" method="POST" class="add-comm-form">

                        <input type="hidden" id="postId" name="post_id" value="<?php echo $post['id']; ?>">
                        <div>
                            <h4>Full Name:</h4> <input type="text" name="fullname" id="fullName" placeholder="John Doe" required>
                        </div>
                        <div>
                            <h4>Your Comment:</h4>
                        </div>
                        <div>
                            <textarea name="text" id="commentBox" required></textarea>
                        </div>
                        <button type=" submit" id="commentSubmit" class="btn btn-default">Submit</button>

                    </form>
                </div>

                <button type=" button" class="btn btn-default" id="show-hide-btn">Hide Comments</button>

                <div class="comments" id="comment-section">
                    <ul class="comment-list">
                        <?php foreach ($comments as $comm) { ?>
                            <li>
                                <strong><?php echo $comm['author'] . ': '; ?></strong><?php echo $comm['text']; ?>
                                <button type="button" class="btn btn-default"><a href="./delete-comment.php?comm_id=<?php echo $comm['id']; ?>&post_id=<?php echo $_GET['post_id']; ?>">Delete</a></button>
                            </li>
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

        const fullName = document.getElementById('fullName').value;
        const commentBox = document.getElementById('commentBox').value;
        const alertBox = document.getElementById('alertBox');
        const commentSubmitBtn = document.getElementById('commentSubmit');

        commentSubmitBtn.addEventListener('click', function() {
            if (fullName === "" || commentBox === "") {
                alertBox.style.display = 'block';
            }
        });

        const delPostBtn = document.getElementById('del-post-btn');
        const postId = document.getElementById('postId').value;
        delPostBtn.addEventListener('click', function() {
            let del = confirm("Do you really want to delete this post?");
            if (del === true) {
                let delPost = "/delete-post.php?post_id=";
                let delLoc = delPost.concat(postId);
                window.location.href = delLoc;
            }
        });
    </script>

</body>

</html>