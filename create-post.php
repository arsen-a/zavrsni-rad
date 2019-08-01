<?php
require('./database/dbconnect.php');

$query1 = "SELECT id, firstName, lastName FROM users";
$stmt1 = $connection->prepare($query1);
$stmt1->execute();
$stmt1->setFetchMode(PDO::FETCH_ASSOC);
$users = $stmt1->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $created_at = date("Y-m-d");


    $query =
        'INSERT INTO posts (title, body, author, created_at) 
    VALUES (:title, :body, :author, :created_at)';
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':body', $body);
    $stmt->bindParam(':author', $user);
    $stmt->bindParam(':created_at', $created_at);

    $stmt->execute();
    header('Location: /index.php');
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
                    <div class="alert alert-danger" id="alertBox">
                        <strong>Failed submit!</strong> Please fill out all remaining fields.
                    </div>
                    <form class="create-post-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div>
                            <h4>User:</h4>
                            <select name="user">
                                <?php foreach ($users as $u) { ?>
                                    <option value="<?php echo $u['id'] ?>"><?php echo $u['firstName'] . " " . $u['lastName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <h4>Post title:</h4><input type="text" id="title" name="title" placeholder="My new post" required>
                        </div>
                        <div>
                            <textarea class="post-body" id="body" name="body" placeholder="Post body" required></textarea>
                        </div>

                        <div class="submit-btn-div">
                            <input class="btn btn-primary" id="submitPost" type="submit" value="Create a new post">
                        </div>

                    </form>
                </div>

            </div><!-- /.blog-main -->
            <?php include('./templates/sidebar.php'); ?>
        </div><!-- /.row -->
        <script>
            const title = document.getElementById('title').value;
            const body = document.getElementById('body').value;
            const commentSubmitBtn = document.getElementById('submitPost');

            commentSubmitBtn.addEventListener('click', function() {
                if (title === "" || body === "") {
                    alertBox.style.display = 'block';
                }
            });
        </script>
    </main><!-- /.container -->

    <?php include('./templates/footer.php') ?>
</body>

</html>