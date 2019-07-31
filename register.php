<?php
require('./database/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    $query = 'INSERT INTO users (firstName, lastName) VALUES (:fname, :lname)';
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);

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


                <div class="register-container">
                    <div class="alert alert-danger" id="alertBox">
                        <strong>Failed submit!</strong> Please fill out all remaining fields.
                    </div>
                    <form class="register-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div>
                            <h4>First name:</h4><input type="text" id="fname" name="fname" placeholder="John" required>
                        </div>

                        <div>
                            <h4>Last name:</h4><input type="text" id="lname" name="lname" placeholder="Doe" required>
                        </div>

                        <div class="submit-btn-div">
                            <input class="submit-btn" id="register" type="submit" value="Register">
                        </div>

                    </form>
                </div>


            </div><!-- /.blog-main -->
            <?php include('./templates/sidebar.php'); ?>
        </div><!-- /.row -->
        <script>
            const fname = document.getElementById('fname').value;
            const lname = document.getElementById('lname').value;
            const registerBtn = document.getElementById('register');

            registerBtn.addEventListener('click', function() {
                if (fname === "" || lname === "") {
                    alertBox.style.display = 'block';
                }
            });
        </script>
    </main><!-- /.container -->

    <?php include('./templates/footer.php') ?>
</body>

</html>