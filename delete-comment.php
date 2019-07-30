<?php
require('./database/dbconnect.php');

if (!isset($_GET['comm_id'])) {
    header('Location: ./index.php');
}

$commentId = $_GET['comm_id'];
$postId = $_GET['post_id'];

$query = 'DELETE FROM comments WHERE id = :id AND post_id = :postId';
$stmt = $connection->prepare($query);
$stmt->bindParam(':id', $commentId);
$stmt->bindParam(':postId', $postId);
$stmt->execute();
header('Location: ./single-post.php?post_id=' . $postId);
