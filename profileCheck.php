<?php
session_start();
$host = 'localhost';
$dbname = 'u937314v_tdv';
$user = 'u937314v_tdv';
$pass = 'Tdv123';
// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправляем на страницу с авторизацией и регистрацией
    header('Location: login');
    exit();
}

// Получаем информацию о пользователе из базы данных
$user_id = $_SESSION['user_id'];
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Проверяем роль пользователя и перенаправляем на соответствующую страницу
if ($user['role'] == 'admin') {
    header('Location: admin_dashboard');
    exit();
} else {
    header('Location: user_dashboard');
    exit();
}
?>
