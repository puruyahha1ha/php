<?php
include 'db.php';

$errors = [
    'task_name' => '',
    'task_description' => '',
    'status' => ''
];

$task_name = '';
$task_description = '';
$status = '未完了';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $status = $_POST['status'];

    // バリデーション
    // タスク名：必須、255文字以内
    if (empty($task_name)) {
        $errors['task_name'] = 'タスク名を入力してください';
    } else if (mb_strlen($task_name) > 255) {
        $errors['task_name'] = 'タスク名は255文字以内で入力してください';
    }

    // タスク詳細：任意、1000文字以内
    if (mb_strlen($task_description) > 1000) {
        $errors['task_description'] = 'タスク詳細は1000文字以内で入力してください';
    }

    // ステータス：未完了、完了
    if ($status !== '未完了' && $status !== '完了') {
        $errors['status'] = 'ステータスは「未完了」または「完了」を選択してください';
    }

    // エラーがなければタスクを追加
    if (!$errors['task_name'] && !$errors['task_description'] && !$errors['status']) {
        $query = 'INSERT INTO tasks (task_name, task_description, status) VALUES (?, ?, ?)';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$task_name, $task_description, $status]);

        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新しいタスクの追加</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>タスク追加</h1>
    <form action="add_task.php" method="post">
        <label for="task_name">タスク名:</label>
        <input type="text" id="task_name" name="task_name" value="<?= htmlspecialchars($task_name) ?>" required><br>
        <?php if ($errors['task_name']) : ?>
            <span class="error"><?= $errors['task_name'] ?></span><br>
        <?php endif; ?>
        <label for="task_description">詳細:</label>
        <textarea id="task_description" name="task_description"><?= htmlspecialchars($task_description) ?></textarea><br>
        <?php if ($errors['task_description']) : ?>
            <span class="error"><?= $errors['task_description'] ?></span><br>
        <?php endif; ?>
        <label for="status">ステータス:</label>
        <select id="status" name="status">
            <option value="未完了" <?= $status === '未完了' ? 'selected' : '' ?>>未完了</option>
            <option value="完了" <?= $status === '完了' ? 'selected' : '' ?>>完了</option>
        </select><br>
        <?php if ($errors['status']) : ?>
            <span class="error"><?= $errors['status'] ?></span><br>
        <?php endif; ?>
        <button type="submit">追加</button>
    </form>
</body>

</html>