<?php
// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');

// Получение идентификатора отзыва из параметра запроса URL
$reviewId = $_GET['id'];

// Получение отзыва из базы данных
$stmt = $pdo->prepare("SELECT reviews.*, users.username, items.title AS item_title, items.image_url AS item_image_url, GROUP_CONCAT(review_images.image_path) AS images FROM reviews INNER JOIN users ON reviews.user_id = users.id LEFT JOIN review_images ON reviews.id = review_images.review_id INNER JOIN items ON reviews.item_id = items.id WHERE reviews.id = ?  GROUP BY reviews.id");
$stmt->execute([$reviewId]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

// Возврат отзыва в формате JSON
header('Content-Type: application/json');
echo json_encode($review);
?>
