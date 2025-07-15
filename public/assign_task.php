<?php
require '../includes/auth.php';
require '../config/db.php';
require '../mailer/send_mail.php';
checkAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $deadline = $_POST['deadline'];

    // Insert task
    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, deadline) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $description, $deadline]);

    // Fetch user email
    $stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Send task assignment email
    if ($user) {
        sendTaskEmail($user['email'], $title, $description, $deadline, $user['name']);
    }

    header("Location: index.php");
    exit();
}

// Load users
$users = $pdo->query("SELECT id, name FROM users WHERE role='user'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assign Task</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header>
    <h1>Tasker</h1>
    <nav>
      <a href="index.php">Dashboard</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="container">
    <h2>Assign New Task</h2>
    <form method="POST">
      <label for="user_id">Assign To:</label>
      <select name="user_id" id="user_id" required>
        <?php foreach ($users as $user): ?>
          <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <label for="title">Task Title:</label>
      <input name="title" id="title" required>

      <label for="description">Description:</label>
      <textarea name="description" id="description"></textarea>

      <label for="deadline">Deadline:</label>
      <input name="deadline" type="date" id="deadline" required>

      <button type="submit">Assign Task</button>
    </form>
  </div>
</body>
</html>
