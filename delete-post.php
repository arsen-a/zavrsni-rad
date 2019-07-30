<?php

require('./database/dbconnect.php');

if (!isset($_GET['post_id'])) {
    header('Location: ./index.php');
}

$postId = $_GET['post_id'];

$query1 = 'DELETE FROM comments WHERE post_id = :postId';
$query2 = 'DELETE FROM posts WHERE id = :postId';
$stmt1 = $connection->prepare($query1);
$stmt2 = $connection->prepare($query2);
$stmt1->bindParam(':postId', $postId);
$stmt2->bindParam(':postId', $postId);
$stmt1->execute();
$stmt2->execute();

header('Location: ./index.php');
