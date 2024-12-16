<?php
$host = 'localhost'; // サーバー名
$dbname = 'php'; // データベース名
$username = 'root'; // ユーザー名
$password = ''; // パスワード

try {
    // PDOによる接続
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // エラーモードの設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
