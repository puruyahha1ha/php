<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = 'DELETE FROM tasks WHERE id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
}
