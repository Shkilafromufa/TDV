<?php
// Начало сессии
session_start();
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправление на страницу login.php
    header("Location: login-review");
    exit;
}

// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');

// Получение данных формы
$user_id = $_SESSION['user_id'];
$item_id = $_POST['item_id'];
$rating = $_POST['rating'];
$review_text = $_POST['review_text'];

// Вставка отзыва в базу данных
$stmt = $pdo->prepare("INSERT INTO reviews (user_id, item_id, rating, review_text) VALUES (?, ?, ?, ?)");
$stmt->execute([$user_id, $item_id, $rating, $review_text]);
$review_id = $pdo->lastInsertId();

// Загрузка и вставка изображений в базу данных
$target_dir = "uploads/";
foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    // Проверка, что элемент input файла не пустой
    if (!empty($tmp_name)) {
        $target_file = $target_dir . basename($_FILES['images']['name'][$key]);

        // Проверка успешности загрузки файла
        if (move_uploaded_file($tmp_name, $target_file)) {
            $stmt = $pdo->prepare("INSERT INTO review_images (review_id, image_path) VALUES (?, ?)");
            $stmt->execute([$review_id, $target_file]);
        } else {
            // Обработка ошибки загрузки файла, например, запись в журнал ошибок или отображение сообщения пользователю
            echo "Ошибка загрузки файла: " . $_FILES['images']['name'][$key];
        }
    }
}



// Получение имени пользователя из базы данных
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$username = $user['username'];

// Настройки почтового сервера
$smtp_host = 'smtp.yandex.ru';
$smtp_port = 465;
$smtp_username = 'stepachkin000@yandex.ru';
$smtp_password = 'ccjhaqgsqysskusl';

// Отправка сообщения на почту
$mail = new PHPMailer(true);

try {
    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->isSMTP();
    $mail->Host = $smtp_host;
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_username;
    $mail->Password = $smtp_password;
    $mail->SMTPSecure = 'ssl';
    $mail->Port = $smtp_port;

    $mail->setFrom('stepachkin000@yandex.ru', 'TDV-ENGINEERING-SITE');
    $mail->addAddress('TDV-Engineering@mail.ru', 'Денис Владимирович');
    $mail->isHTML(true);
    $mail->Subject = 'Новый отзыв на сайте tdv-engineering.ru';
    $mail->Body = "Здравствуйте, от '$username' загружен отзыв на сайте tdv-engineering.ru. Необходимо подтвердить или отклонить.";

    $mail->send();
    header("Location: Отзывы");
} catch (Exception $e) {
    echo "Error sending message: {$mail->ErrorInfo}";
}
exit();
?>
