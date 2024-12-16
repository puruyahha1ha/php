<?php

// パラメータにrunを指定して実行する
if (!isset($_GET['run'])) {
    exit;
}

// MySQLサーバーへの接続設定
$servername = "localhost";
$username = "root"; // XAMPPのデフォルトユーザー名
$password = ""; // XAMPPのデフォルトパスワードは空白
$dbname = "php"; // ここに作成したデータベース名を入力

// MySQLに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続確認
if ($conn->connect_error) {
    die("接続に失敗しました: " . $conn->connect_error);
}
echo "接続成功";

// テーブルの作成
$sql = "CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL,
    task_description TEXT,
    status ENUM('未完了', '完了') DEFAULT '未完了',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "テーブル 'tasks' が作成されました。";
} else {
    echo "テーブル作成エラー: " . $conn->error;
}

// // 接続を閉じる
$conn->close();
