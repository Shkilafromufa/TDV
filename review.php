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
<style>
    .review {
         position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
   box-shadow: 10px 10px 10px rgba(0, 73, 255, 0.1), -10px -10px 10px rgba(0, 73, 255, 0.1), 10px -10px 10px rgba(0, 73, 255, 0.1), -10px 10px 10px rgba(0, 73, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding-left: 20px; 
            margin-top: 20px;
            margin-bottom: 20px;
    }
.item {
    border: 1px solid #ccc;
    margin-right: 20px;
}
    .item img {
        width: 30%
    }
    .images {
    display: flex;
    justify-content: center;
}
    .images img {
        width: 70%;
        margin-bottom: 10px;
    }
    .rating {
        padding: 30px;
            display: flex;
            justify-content: center;
    }
    .star {
        font-size: 100px;
               cursor: pointer;
        color: gray;
    }
    .star.active {
        color: gold;
    }

    .star.selected {
        color: gold;
    }
     button {
  padding: 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin: auto;
display: flex;
justify-content: center;
margin-bottom: 10px !important;
}
 button:hover {
  background-color: #45a049;
}

@media screen and (max-width: 860px) {
        .star {
        font-size: 60px;
               cursor: pointer;
        color: gray;
    }
}
</style>
<main>
<section id="reviews"> 
</section>

<button onclick="window.location.href='admin_dashboard'">Вернуться назад</button>
 </main> 
   <script> 
      document.addEventListener("DOMContentLoaded", function() {
    // Get the review ID from the URL query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const reviewId = urlParams.get('id');

    // Fetch the review from reviews.php
    fetch(`inputrevieid.php?id=${reviewId}`)
        .then(response => response.json())
        .then(data => displayReview(data))
        .catch(error => console.error('Error:', error));

    // Display the review on the page
    function displayReview(review) {
        const reviewSection = document.getElementById('reviews');

        const reviewDiv = document.createElement('div');
        reviewDiv.className = 'review';
        reviewDiv.innerHTML = `
            <h3>Пользователь ${review.username}</h3>
            ${review.item_image_url ? `
                <div class="item">
                 <p> Отзыв на товар "${review.item_title}"</p>
                    <img src="${review.item_image_url}" alt="${review.item_title}" width="50">
                </div>
            ` : ''}
            <div class="rating"> ${createStars(review.rating)}</div>
            <p>${review.review_text}</p>
        `;

        // Display images for the review
        if (review.images) {
            const images = review.images.split(',');
            const imagesDiv = document.createElement('div');
            imagesDiv.className = 'images';
            images.forEach(image => {
                const img = document.createElement('img');
                img.src = image;
                imagesDiv.appendChild(img);
            });
            reviewDiv.appendChild(imagesDiv);
        }

        reviewSection.appendChild(reviewDiv);
    }

    // Create star elements based on rating
    function createStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<span class="star selected">&#9733;</span>';
            } else {
                stars += '<span class="star">&#9733;</span>';
            }
        }
        return stars;
    }
});

    </script>
  

    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-59bd"><div class="u-clearfix u-sheet u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1"><b>«</b>ООО «ТДВ Инжиниринг»<b>»</b>
          <br>
          <br>&nbsp; &nbsp; &nbsp;Адрес: 450105, Республика
Башкортостан, город Уфа, ул. Юрия Гагарина, д. 28

Тел.: 8&nbsp;917&nbsp;486-777-6&nbsp;<br>E-mail: TDV-Engineering@mail.ru&nbsp;<br>ОГРН 1170280020316&nbsp;<br>ИНН 0276921062<br>&nbsp; КПП 027601001&nbsp;&nbsp;
        </p>
      </footer>
</body></html>