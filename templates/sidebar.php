<?php
require_once('./database/query-build.php');

$latestPosts = $getData;
$latestPosts->setQuery("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5");

$latest = $latestPosts->fetchMulti();

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