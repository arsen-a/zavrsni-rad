<?php
require('./database/dbconnect.php');
$query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
$stmt = $connection->prepare($query);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$latest = $stmt->fetchAll();

?>

<aside class="col-sm-3 ml-sm-auto blog-sidebar">

    <div class="sidebar-module sidebar-module-inset">
        <h4>Latest Posts</h4>
        <?php foreach ($latest as $post) { ?>
            <p> <a href="./single-post.php?post_id=<?php echo $post['id']; ?>">
                    <?php echo $post['title']; ?>
                </a>
            </p>
        <?php } ?>
    </div>

</aside>