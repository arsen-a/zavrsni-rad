<?php
require('./database/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comname = $_POST['fullname'];
    $comment = $_POST['text'];
    $cpost_id = $_POST['post_id'];
    $query = 'INSERT INTO comments (author, text, post_id) VALUES (:author, :text, :post_id)';
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':author', $comname);
    $stmt->bindParam(':text', $comment);
    $stmt->bindParam(':post_id', $cpost_id);
    $stmt->execute();

    header('Location: ./single-post.php?post_id=' . $cpost_id);
} else {
    header('Location: ./index.php');
}
