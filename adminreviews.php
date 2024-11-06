<?php
// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');

// Получение отзывов из базы данных
$stmt = $pdo->query("SELECT reviews.*, users.username, items.title AS item_title, items.image_url AS item_image_url, GROUP_CONCAT(review_images.image_path) AS images FROM reviews INNER JOIN users ON reviews.user_id = users.id LEFT JOIN review_images ON reviews.id = review_images.review_id INNER JOIN items ON reviews.item_id = items.id GROUP BY reviews.id ORDER BY reviews.created_at DESC");

$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Возврат отзывов в формате JSON
header('Content-Type: application/json');
echo json_encode($reviews);
?>