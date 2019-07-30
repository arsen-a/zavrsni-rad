<?php
require('./database/dbconnect.php');

$query = "SELECT * FROM posts ORDER BY created_at DESC";
$stmt = $connection->prepare($query);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$posts = $stmt->fetchAll();

?>

<?php foreach ($posts as $p) { ?>
    <div class="blog-post">
        <a href="../single-post.php?post_id=<?php echo $p['id']; ?>">
            <h2 class="blog-post-title"><?php echo $p['title'] ?></h2>
        </a>
        <p class="blog-post-meta"><?php echo $p['created_at'] . " "; ?> by <a href="#"><?php echo " " . $p['author']; ?></a></p>
        <hr>
        <p><?php echo $p['body']; ?></p>
        <hr>

    </div>
<?php } ?>