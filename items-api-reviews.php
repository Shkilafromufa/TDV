<?php
// Подключаемся к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');

// Получаем список актуальных товаров/услуг из базы данных
$stmt = $pdo->prepare('SELECT id, title FROM items');
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Возвращаем список товаров/услуг в формате JSON
header('Content-Type: application/json');
echo json_encode($items);