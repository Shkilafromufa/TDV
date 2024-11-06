<?php
// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');

// Получение идентификатора отзыва из запроса
$reviewId = $_POST['id'];

// Удаление картинок, связанных с отзывом
$stmt = $pdo->prepare('DELETE FROM review_images WHERE review_id = ?');
$stmt->execute([$reviewId]);

// Удаление отзыва
$stmt = $pdo->prepare('DELETE FROM reviews WHERE id = ?');
$stmt->execute([$reviewId]);

// Возврат результата в формате JSON
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>
