<?php
include 'db.php';

$errors = [
    'task_name' => '',
    'task_description' => '',
    'status' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $status = $_POST['status'];
    $id = $_POST['id'];

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

    $query = 'UPDATE tasks SET task_name = ?, task_description = ?, status = ? WHERE id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$task_name, $task_description, $status, $id]);

    header('Location: index.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = 'SELECT * FROM tasks WHERE id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク編集</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>タスク編集</h1>
    <form action="edit_task.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>">
        <label for="task_name">タスク名:</label>
        <input type="text" id="task_name" name="task_name" value="<?= htmlspecialchars($task['task_name']) ?>"><br>
        <?php if ($errors['task_name']) : ?>
            <p class="error"><?= $errors['task_name'] ?></p>
        <?php endif; ?>
        <label for="task_description">詳細:</label>
        <textarea id="task_description" name="task_description"><?= htmlspecialchars($task['task_description']) ?></textarea><br>
        <?php if ($errors['task_description']) : ?>
            <p class="error"><?= $errors['task_description'] ?></p>
        <?php endif; ?>
        <label for="status">ステータス:</label>
        <select id="status" name="status">
            <option value="未完了" <?= $task['status'] === '未完了' ? 'selected' : '' ?>>未完了</option>
            <option value="完了" <?= $task['status'] === '完了' ? 'selected' : '' ?>>完了</option>
        </select><br>
        <?php if ($errors['status']) : ?>
            <p class="error"><?= $errors['status'] ?></p>
        <?php endif; ?>
        <button type="submit">更新</button>
    </form>
</body>

</html>