<?php
header('Content-Type: application/json');

define('DB_HOST', 'localhost');
define('DB_NAME', 'u937314v_tdv');
define('DB_USER', 'u937314v_tdv');
define('DB_PASS', 'Tdv123');

try {
    // Подключаемся к базе данных
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);

    // Устанавливаем режим обработки ошибок PDO на исключения
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Проверяем, указан ли параметр id в URL-адресе
    if (isset($_GET['id'])) {
        // Если указан параметр id, извлекаем айтем с указанным ID
        $stmt = $pdo->prepare('SELECT * FROM items WHERE id = :id AND actual = 1');
        $stmt->execute(['id' => $_GET['id']]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        // Экранируем специальные символы в результатах запроса для безопасного отображения на веб-странице
        $item['image_url'] = htmlspecialchars($item['image_url']);
        $item['title'] = htmlspecialchars($item['title']);
        $item['content'] = htmlspecialchars($item['content']);
        $item['created_at'] = htmlspecialchars($item['created_at']);

        // Возвращаем результаты запроса в формате JSON
        echo json_encode($item);
    } else {
        // Если параметр id не указан, извлекаем все айтемы в указанной категории
        $category = isset($_GET['category']) ? $_GET['category'] : 'Производимые товары';

        $stmt = $pdo->prepare('SELECT * FROM items WHERE category_id = (SELECT id FROM categories WHERE title = :category) AND actual = 1 ORDER BY created_at DESC');
        $stmt->execute(['category' => $category]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as &$item) {
            $item['image_url'] = htmlspecialchars($item['image_url']);
            $item['title'] = htmlspecialchars($item['title']);
            $item['content'] = htmlspecialchars($item['content']);
            $item['created_at'] = htmlspecialchars($item['created_at']);
        }

        echo json_encode($items);
    }
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Database connection error: ' . $e->getMessage()));
}
