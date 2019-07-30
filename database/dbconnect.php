<?php

try {
    $connection = new PDO(
        'mysql:host=localhost;dbname=blog',
        'arsen',
        'arsenroot'
    );
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
