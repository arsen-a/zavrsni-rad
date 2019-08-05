<?php
require_once('./database/query-build.php');
$userFetch = $getData;
$userFetch->connect();

$userFetch->setQuery("SELECT id, firstName, lastName FROM users");

$users = $userFetch->fetchMulti();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $created_at = date("Y-m-d");

    $getData->setQuery('INSERT INTO posts (title, body, author, created_at) VALUES (:title, :body, :author, :created_at)');
    $getData->execQuery($title, $body, $user, $created_at);

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