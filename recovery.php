<?php
session_start();

// Импортируем классы PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['user_id'])) {
    // Если пользователь авторизован, перенаправляем на соответствующую страницу в зависимости от роли
    if ($_SESSION['user_role'] == 'admin') {
        header('Location: admin_dashboard');
    } else {
        header('Location: user_dashboard');
    }
    exit();
}

// Обработка формы восстановления пароля
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Проверяем, существует ли пользователь с указанной почтой
    $pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Генерируем новый пароль и отправляем его на почту пользователя
        $new_password = bin2hex(random_bytes(8));
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([$hashed_password, $user['id']]);

        // Настройки почтового сервера
        $smtp_host = 'smtp.yandex.ru';
        $smtp_port = 465;
        $smtp_username = 'stepachkin000@yandex.ru';
        $smtp_password = 'ccjhaqgsqysskusl';

        // Отправляем письмо с новым паролем
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = $smtp_port;

            $mail->setFrom($smtp_username, 'Your Name');
            $mail->addAddress($user['email']);
            $mail->isHTML(true);
            $mail->Subject = 'Password reset';
            $mail->Body = 'Your new password is: ' . $new_password;

            $mail->send();
            $success = 'A new password has been sent to your email address';
        } catch (Exception $e) {
            $error = 'Error sending email: ' . $mail->ErrorInfo;
        }
    } else {
        // Если пользователь с указанной почтой не найден, выводим сообщение об ошибке
        $error = 'No user found with that email address';
    }
}
?>






<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru"><head>
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(97936401, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/97936401" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Главная.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 6.8.9, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link rel="stylesheet" type="text/css" href="auth.css">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Личный кабинет">
    <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
  <body data-path-to-root="./" data-include-products="false" class="u-body u-xl-mode" data-lang="ru"><header class="u-clearfix u-container-align-center u-header" id="sec-41f8" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction=""><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <nav class="u-menu u-menu-one-level u-offcanvas u-menu-1">
          <div class="menu-collapse" style="font-size: 1rem; letter-spacing: 0px; font-weight: 700;">
            <a class="u-button-style u-custom-border u-custom-border-color u-custom-borders u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-text-active-color u-custom-text-color u-custom-text-hover-color u-custom-top-bottom-menu-spacing u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="#">
              <svg class="u-svg-link" viewBox="0 0 24 24"><use xlink:href="#menu-hamburger"></use></svg>
              <svg class="u-svg-content" version="1.1" id="menu-hamburger" viewBox="0 0 16 16" x="0px" y="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><g><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
</g></svg>
            </a>
          </div>
          <div class="u-custom-menu u-nav-container">
            <ul class="u-nav u-spacing-20 u-unstyled u-nav-1"><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-grey-90 u-text-hover-palette-2-base" href="Главная" style="padding: 10px;">Главная</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-grey-90 u-text-hover-palette-2-base" href="Товары-и-услуги" style="padding: 10px;">Товары и услуги</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-grey-90 u-text-hover-palette-2-base" href="Отзывы" style="padding: 10px;">Отзывы</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-grey-90 u-text-hover-palette-2-base" href="profileCheck.php" style="padding: 10px;">Личный кабинет</a>
</li></ul>
          </div>
          <div class="u-custom-menu u-nav-container-collapse">
            <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
              <div class="u-inner-container-layout u-sidenav-overflow">
                <div class="u-menu-close"></div>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="Главная">Главная</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="Товары-и-услуги">Товары и услуги</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="Отзывы">Отзывы</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="profileCheck.php">Личный кабинет</a>
</li></ul>
              </div>
            </div>
            <div class="u-black u-menu-overlay u-opacity u-opacity-70"></div>
          </div>
        </nav>
      </div></header>
    <section class="u-clearfix u-image u-shading u-section-1" id="sec-266b" data-image-width="2445" data-image-height="1357">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h1 class="u-text u-text-default u-text-1" data-animation-name="customAnimationIn" data-animation-duration="2000">TDV ENGINEERING </h1>
        <p class="u-text u-text-2">Технологические решения вашего бизнеса </p>
      </div>
    </section>
    <main>
            <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <h2>Восстановление пароля по почте</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Почта" required>
        <input type="submit" value="Отправить пароль" style="display: flex; justify-content: center; margin: auto; width: -webkit-fill-available;">
    </form>

    <p>Вы вспомнили пароль? <a href="login">Войти</a></p>
    </main>
    <style>
         @media screen and (max-width: 860px) {
   form {
        width: 90%;
        margin: 0 auto;
        padding: 10px;
  }
}
     </style>
    
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-59bd"><div class="u-clearfix u-sheet u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1"><b>«</b>ООО «ТДВ Инжиниринг»<b>»</b>
          <br>
          <br>&nbsp; &nbsp; &nbsp;Адрес: 450105, Республика
Башкортостан, город Уфа, ул. Юрия Гагарина, д. 28

Тел.: 8&nbsp;917&nbsp;486-777-6&nbsp;<br>E-mail: TDV-Engineering@mail.ru&nbsp;<br>ОГРН 1170280020316&nbsp;<br>ИНН 0276921062<br>&nbsp; КПП 027601001&nbsp;&nbsp;
        </p>
      </div></footer>

  
</body></html>
