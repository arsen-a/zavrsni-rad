<?php
require('./database/query-build.php');

$getData->setQuery("SELECT posts.id AS id, posts.title AS title, posts.body AS body, 
          posts.created_at AS created_at, users.firstName AS firstName, users.lastName as lastName
          FROM posts 
          LEFT JOIN users
          ON posts.author = users.id
          ORDER BY created_at DESC");

$posts = $getData->fetchMulti();

?>

<?php foreach ($posts as $p) { ?>
    <div class="blog-post">
        <a href="../single-post.php?post_id=<?php echo $p['id']; ?>">
            <h2 class="blog-post-title"><?php echo $p['title'] ?></h2>
        </a>
        <p class="blog-post-meta"><?php echo $p['created_at'] . " "; ?> by <a href="#"><?php echo " " . $p['firstName'] . " " . $p['lastName']; ?></a></p>
        <hr>
        <p><?php echo $p['body']; ?></p>

    </div>
<?php } ?>