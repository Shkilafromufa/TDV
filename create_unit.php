<?php
// Подключение к базе данных
$host = 'localhost';
$dbname = 'u937314v_tdv';
$user = 'u937314v_tdv';
$pass = 'Tdv123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получение данных из формы
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];

    // Обработка загруженной картинки
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Проверка типа файла
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Перемещение загруженного файла в целевую директорию
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Подготовка SQL-запроса для вставки данных в базу данных
    $stmt = $pdo->prepare("INSERT INTO items (category_id, title, content, image_url, created_at, actual) VALUES (?, ?, ?, ?, NOW(), 1)");
    $stmt->execute([$category_id, $title, $content, $target_file]);

    header('Location: admin_dashboard');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Закрытие соединения с базой данных
$pdo = null;
?>
