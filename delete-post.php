<?php
require('./database/query-build.php');

$getData1 = new QueryBuild('localhost', 'blog', 'arsen', 'arsenroot');
$getData1->connect();

if (!isset($_GET['post_id'])) {
    header('Location: ./index.php');
}

$postId = $_GET['post_id'];

$getData->setQuery('DELETE FROM comments WHERE post_id = :postId');
$getData1->setQuery('DELETE FROM posts WHERE id = :postId');

$getData->execQuery($postId);
$getData1->execQuery($postId);

header('Location: ./index.php');
