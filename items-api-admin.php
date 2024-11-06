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

    // Получаем значение параметра category из URL-адреса, если оно указано, в противном случае используем значение по умолчанию
    $category = isset($_GET['category']) ? $_GET['category'] : 'Производимые товары';

    // Подготавливаем запрос к базе данных для выборки товаров или услуг в зависимости от значения параметра category
    $stmt = $pdo->prepare('SELECT * FROM items WHERE category_id = (SELECT id FROM categories WHERE title = :category) ORDER BY created_at DESC');

    // Выполняем запрос к базе данных с указанным значением параметра category
    $stmt->execute(['category' => $category]);

    // Извлекаем результаты запроса в виде ассоциативного массива
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Экранируем специальные символы в результатах запроса для безопасного отображения на веб-странице
    foreach ($items as &$item) {
        $item['image_url'] = htmlspecialchars($item['image_url']);
        $item['title'] = htmlspecialchars($item['title']);
        $item['content'] = htmlspecialchars($item['content']);
        $item['created_at'] = htmlspecialchars($item['created_at']);
    }

    // Возвращаем результаты запроса в формате JSON
    echo json_encode($items);
} catch (PDOException $e) {
    // Возвращаем сообщение об ошибке в формате JSON в случае ошибки подключения к базе данных
    echo json_encode(array('error' => 'Database connection error: ' . $e->getMessage()));
}
