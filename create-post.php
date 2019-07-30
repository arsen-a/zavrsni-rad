<?php
require('./database/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author = $_POST['author'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $created_at = date("Y-m-d");


    $query = 'INSERT INTO posts (title, body, author, created_at) VALUES (:title, :body, :author, :created_at)';
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':body', $body);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':created_at', $created_at);

    $stmt->execute();
}

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
                <div class="form-container">
                    <form class="create-post-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div>
                            <h4>Your full name:</h4><input type="text" name="author" placeholder="John Doe" required>
                        </div>
                        <div>
                            <h4>Post title:</h4><input type="text" name="title" placeholder="My new post" required>
                        </div>
                        <div>
                            <textarea class="post-body" name="body" placeholder="Post body"></textarea>
                        </div>

                        <div class="submit-btn-div">
                            <input class="submit-btn" type="submit" value="Create a new post">
                        </div>

                    </form>
                </div>

            </div><!-- /.blog-main -->
            <?php include('./templates/sidebar.php'); ?>
        </div><!-- /.row -->

    </main><!-- /.container -->

    <?php include('./templates/footer.php') ?>
</body>

</html>