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
$sql = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- レコード作成時のタイムスタンプ
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- 更新時に自動でタイムスタンプ更新
    deleted_at TIMESTAMP NULL DEFAULT NULL -- 論理削除用。削除されていない場合はNULL
)";


if ($conn->query($sql) === TRUE) {
    echo "テーブル 'users' が作成されました。";
} else {
    echo "テーブル作成エラー: " . $conn->error;
}

// // 接続を閉じる
$conn->close();
