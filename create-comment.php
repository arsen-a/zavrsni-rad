<?php
require('./database/query-build.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comname = $_POST['fullname'];
    $comment = $_POST['text'];
    $cpost_id = $_POST['post_id'];

    $getData->setQuery('INSERT INTO comments (author, text, post_id) VALUES (:author, :text, :post_id)');
    $getData->execQuery($comname, $comment, $cpost_id);

    header('Location: ./single-post.php?post_id=' . $cpost_id);
} else {
    header('Location: ./index.php');
}
