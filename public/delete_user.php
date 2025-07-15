<?php
require '../config/db.php';
$id = $_GET['id'];
$pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
header("Location: index.php");
?>
