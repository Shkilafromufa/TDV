<?php
session_start();
header('Content-type: text/html; charset=utf-8');
// Импортируем классы PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$secret_key = '6LeUg_8pAAAAAO836tkcsZvnEUg6N8H3hVVn-C6U';
$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);
$response_data = json_decode($response);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$response_data->success) {
        die('Ошибка, проверка на робота не пройдена');
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Сохранение данных в базу данных
    $pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');

    $sql = "INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $phone, $message]);

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
        $mail->Subject = 'Сообщение от ' . $name;
        $mail->Body = "Новое сообщение из раздела консультаций и предложений на сайте tdv-engineering.ru <br> ФИО отправителя: $name<br>Почта: $email<br>Номер телефона: $phone<br>Предложение: $message";

        $mail->send();
        echo 'Message sent successfully';
    } catch (Exception $e) {
        echo "Error sending message: {$mail->ErrorInfo}";
    }
}
?>
