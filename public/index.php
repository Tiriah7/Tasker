<?php
require '../includes/auth.php';
require '../includes/functions.php';
require '../config/db.php';
checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Task Dashboard</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header>
    <h1>Tasker</h1>
    <nav>
      <span>Hello, <?= $_SESSION['name'] ?>!</span>
      <?php if (isAdmin()): ?>
        <a href="assign_task.php">Assign Task</a>
        <a href="register.php">Add User</a>
      <?php endif; ?>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="container">
    <?php if (isAdmin()): ?>
      <h2>All Users</h2>
      <table>
        <thead>
          <tr><th>Name</th><th>Email</th><th>Actions</th></tr>
        </thead>
        <tbody>
          <?php
          $users = $pdo->query("SELECT * FROM users")->fetchAll();
          foreach ($users as $user):
          ?>
          <tr>
            <td><?= $user['name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td>
              <a href='edit_user.php?id=<?= $user['id'] ?>'>Edit</a> | 
              <a href='delete_user.php?id=<?= $user['id'] ?>' onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <h2>All Tasks</h2>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Status</th>
          <th>Deadline</th>
          <?php if (isAdmin()): ?>
            <th>Assigned To</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php
          if (isAdmin()) {
              $stmt = $pdo->query("
                  SELECT tasks.*, users.name AS user_name, users.email AS user_email
                  FROM tasks
                  JOIN users ON tasks.user_id = users.id
                  ORDER BY tasks.deadline ASC
              ");
              $tasks = $stmt->fetchAll();
          } else {
              $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
              $stmt->execute([$_SESSION['user_id']]);
              $tasks = $stmt->fetchAll();
          }


        foreach ($tasks as $task): ?>
        <tr>
          <td><?= $task['title'] ?></td>
          <td><?= $task['description'] ?></td>
          <td>
            <form class="status-form" method="POST" action="update_task_status.php">
              <select name="status" onchange="this.form.submit()">
                <option <?= $task['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option <?= $task['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option <?= $task['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
              </select>
              <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
            </form>
          </td>
          <td><?= $task['deadline'] ?></td>
          <?php if (isAdmin()): ?>
            <td><?= htmlspecialchars($task['user_name']) ?> (<?= htmlspecialchars($task['user_email']) ?>)</td>
          <?php endif; ?>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script src="assets/script.js"></script>
</body>
</html>
