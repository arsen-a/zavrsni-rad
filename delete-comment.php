<?php
require('./database/query-build.php');

if (!isset($_GET['comm_id'])) {
    header('Location: ./index.php');
}

$commentId = $_GET['comm_id'];
$postId = $_GET['post_id'];

$getData->setQuery('DELETE FROM comments WHERE id = :id AND post_id = :postId');
$getData->execQuery($commentId, $postId);

header('Location: ./single-post.php?post_id=' . $postId);
