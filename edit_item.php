<?php
// Начало сессии
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправление на страницу login.php
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=u937314v_tdv;charset=utf8mb4', 'u937314v_tdv', 'Tdv123');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM items WHERE id = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $pdo->prepare('UPDATE items SET title = ?, content = ? WHERE id = ?');
    $stmt->execute([$title, $content, $id]);
    header('Location: admin_dashboard'); // Redirect back to the admin page
}
// Получение данных пользователя из базы данных
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Проверка на роль администратора
if ($user['role'] !== 'admin') {
    // Если пользователь не является администратором, перенаправление на страницу доступа запрещен
    header("Location: user_dashboard");
    exit;
}

// Обработка выхода из аккаунта
if (isset($_POST['logout'])) {
    // Уничтожение сессии
    session_destroy();

    // Перенаправление на страницу login.php
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru"><head>
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
    
    
    <form method="post">
    <input type="text" name="title" value="<?php echo $item['title']; ?>">
    <textarea name="content"><?php echo $item['content']; ?></textarea>
    <button type="submit">Сохранить</button> <br><br>
    <a href="admin_dashboard">Вернуться назад</a>
</form>


<br>
    <style>
           .my-form {
box-shadow: 8px 8px 8px rgb(0 73 255 / 10%);
  display: flex;
  flex-direction: column;
  max-width: 750px;
  margin-left: 20px;
    margin-top: 20px;
}
form {
    margin-top: 20px;
    width: 750px;
    margin-left: 30px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}
form input[type="text"],
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

form input[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

form input[type="submit"]:hover {
    background-color: #45a049;
}
form div {
  margin-bottom: 10px;
}

form label {
  font-weight: bold;
}

form input[type="text"],
form textarea {
  width: 100%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

form button {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

form button:hover {
  background-color: #45a049;
}
.tabs button {
    
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.tabs button:hover {
  background-color: #45a049;
}
    .custom-checkbox {
        width: 60px;
        height: 24px;
        accent-color: #4CAF50; /* Change the color to your desired green color */
        transform: scale(1.5); /* Adjust the scale value to make the checkbox larger or smaller */
}
        .tabs {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 8px 8px 8px rgb(0 73 255 / 10%);
            border-radius: 8px;
            overflow: hidden;
            padding-left: 20px;
        }

        .tabs input[type="radio"] {
            display: none;
        }

        .tabs ul {
            display: flex;
            justify-content: space-around;
            list-style: none;
            margin: 0;
            padding: 0;
            background: #f2f2f2;
            border-radius: 8px 8px 0 0;
        }

        .tabs ul li {
            flex: 1;
            text-align: center;
        }

        .tabs ul li label {
            display: block;
            padding: 20px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: bold;
            transition: background 0.3s ease, color 0.3s ease;
        }

        #tab1:checked ~ ul li:first-child label,
        #tab2:checked ~ ul li:last-child label {
            background: #4CAF50;
            color: white;
        }

        .tabs .slider {

            bottom: 0;
            left: 0;
            width: 50%;
            height: 10px;
            background: #4CAF50;
            transition: transform 0.3s ease;
        }

        #tab1:checked ~ .slider {
            transform: translateX(0);
        }

        #tab2:checked ~ .slider {
            transform: translateX(100%);
        }

        .tabs .content {
            position: relative;
            overflow: hidden;
        }

        .tabs .content section {
            display: none;
            padding: 20px;
            background: #fff;
            border-radius: 0 0 8px 8px;
            opacity: 0;
            width: 75%;
            top: 0;
            left: 0;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        #tab1:checked ~ .content #products {
            display: block;
            opacity: 1;
            transform: translateX(0);
            z-index: 1;
        }

        #tab2:checked ~ .content #services {
            display: block;
            opacity: 1;
            transform: translateX(0);
            z-index: 1;
        }

        #tab1:checked ~ .content #services {
            transform: translateX(100%);
            z-index: 0;
        }

        #tab2:checked ~ .content #products {
            transform: translateX(-100%);
            z-index: 0;
        }
.tabs hr {
  border: none;
  height: 1px;
  background-color: #4CAF50;
  margin: 25px 0;
  margin-bottom: 30px;
}
@media screen and (max-width: 860px) {
    .container {
        flex-direction: column-reverse;
                          }
    .tabs {
        width: 90%;
        max-width: 100%;
        margin: 0 auto;
        padding-right: 0;
        box-shadow: none;
        border-radius: 0;
  }

  .tabs ul li label {
        font-size: 1em;
        padding: 10px;
  }

  .tabs .content section {
        padding: 10px;
  }
   form {
        width: 90%;
        margin: 0 auto;
        padding: 10px;
  }
   .custom-checkbox {
    position: relative;
    left: 0;
    margin-left: 15px;
    margin-top: 10px;
  }
}
    </style>
    
    </div>
    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-59bd"><div class="u-clearfix u-sheet u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1"><b>«</b>ООО «ТДВ Инжиниринг»<b>»</b>
          <br>
          <br>&nbsp; &nbsp; &nbsp;Адрес: 450105, Республика
Башкортостан, город Уфа, ул. Юрия Гагарина, д. 28

Тел.: 8&nbsp;917&nbsp;486-777-6&nbsp;<br>E-mail: TDV-Engineering@mail.ru&nbsp;<br>ОГРН 1170280020316&nbsp;<br>ИНН 0276921062<br>&nbsp; КПП 027601001&nbsp;&nbsp;
        </p>
      </footer>

  
</body></html>
