<?php
// データベース接続を含める
include 'db.php';

// タスクを取得するためのクエリ
$query = 'SELECT * FROM tasks ORDER BY created_at DESC';
$stmt = $pdo->query($query);

// タスクを連想配列として取得
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク一覧</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>タスク管理アプリ</h1>
    <a class="new_task_link" href="add_task.php">新しいタスクを追加</a>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">タスク名</th>
                <th style="width: 60%;">詳細</th>
                <th style="width: 5%;">ステータス</th>
                <th style="width: 5%;">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($tasks): ?>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['task_name']) ?></td>
                        <td style="max-height: 3em; overflow: hidden;"><?= htmlspecialchars($task['task_description']) ?></td>
                        <td><?= htmlspecialchars($task['status']) ?></td>
                        <td class="action_area">
                            <a href="edit_task.php?id=<?= $task['id'] ?>">編集</a>
                            <a href="delete_task.php?id=<?= $task['id'] ?>" class="delete-link">削除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">タスクはありません</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- モーダル -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <h2>削除の確認</h2>
            <p>本当にこのタスクを削除しますか？</p>
            <button id="confirmDelete">削除</button>
            <button id="cancelDelete">キャンセル</button>
        </div>
    </div>

    <script>
        // 削除ボタンのリンクを取得
        let deleteLinks = document.querySelectorAll('a.delete-link');

        // モーダル要素を取得
        let modal = document.getElementById('confirmationModal');
        let confirmDeleteBtn = document.getElementById('confirmDelete');
        let cancelDeleteBtn = document.getElementById('cancelDelete');

        // 削除リンクをクリックしたときの処理
        deleteLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // リンクのデフォルト動作（ページ遷移）を防ぐ

                // モーダルを表示
                modal.style.display = 'flex';

                // 確認ボタンのクリック処理
                confirmDeleteBtn.onclick = function() {
                    window.location.href = link.href; // 実際の削除リンクに遷移
                }

                // キャンセルボタンのクリック処理
                cancelDeleteBtn.onclick = function() {
                    modal.style.display = 'none'; // モーダルを非表示
                }
            });
        });
    </script>
</body>

</html>