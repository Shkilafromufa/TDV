<?php
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправление на страницу login.php
    header("Location: login.php");
    exit;
}
$pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');
// Получение данных пользователя из базы данных
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Проверка на роль администратора
if ($user['role'] !== 'admin') {
    // Если пользователь не является администратором, перенаправление на страницу доступа запрещен
    header("Location: user_dashboard");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT actual FROM items WHERE id = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    $actual = $item['actual'] ? 0 : 1;
    $stmt = $pdo->prepare('UPDATE items SET actual = ? WHERE id = ?');
    $stmt->execute([$actual, $id]);
    header('Location: admin_dashboard'); // Redirect back to the admin page
}
?>
