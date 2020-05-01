<?php

$baseUrl = 'index.php';
$page_size = 2;


$dbname = 'Energotech';
$user = 'root';
$password = '';



// establish conntction to db
$db = new PDO(  "mysql:host=localhost;dbname=$dbname",
                $user, $password);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// get amount of records
$res = $db->query('SELECT count(*) from articles');
if($res!==false) {
    $count=$res->fetch()[0];
} else {
    $count=0;
    echo "<br> can't get amount of records in database </br>";
}

// get current page
$page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
$page = max(1, $page);

/////////////////////////////////////////////////////////////////////
// inserts one pagination button with aproupriated style
function instertPaginationItem($index, $currentPage, $maxPage) {
    global $baseUrl;
    $currentPageMark = ($index==$currentPage) ? 'pagination__item_active' : '';
    echo "<li class='pagination__item $currentPageMark'>
            <a href='$baseUrl?page=$index' class='pagination__link'>$index</a>
          </li>";
}

/////////////////////////////////////////////////////////////////////
// inserts ellipses
function insertPaginationEllepsis() {
    echo "<li class='pagination__item'>
            <span class='pagination__span'>...</span>
          </li>";
}

/////////////////////////////////////////////////////////////////////
// inserts pagination system in a point
function insertPagination($currentPage, $maxPage) {
    // list as whole
    echo "<ul class='pagination'>";
        instertPaginationItem(1, $currentPage, $maxPage); // the first item - show always
        // show ellipses if it is necessary
        if($currentPage >= 4 && $maxPage > 4) {
            insertPaginationEllepsis();
        }
        for($i=2; $i<$maxPage; $i++) { // center items
            if(abs($currentPage-$i)<2
                    || ($currentPage<3 && $i <= 4)
                    || ($maxPage-$currentPage<3 && $i> $maxPage-4)) {
                instertPaginationItem($i, $currentPage, $maxPage);
            }
        }
        // show ellipses if it is necessary
        if($maxPage - $currentPage >= 3 && $maxPage > 4) {
            insertPaginationEllepsis();
        }
        // the last item - show always, except there is only one page
        if($maxPage>1) {
            instertPaginationItem($maxPage, $currentPage, $maxPage);
        }
    echo '</ul>';
}
/////////////////////////////////////////////////////////////////////
// inserts list of articles
function insertArticles ($db, $page) {
    global $page_size;
    // prepare and make query
    $query = $db->prepare(" SELECT `article__title`, `article__text`, `article__image`
    FROM `articles` LIMIT :pagesize OFFSET :ofs");
    if(! $query->execute(['pagesize' => $page_size,'ofs' => ($page-1) * $page_size])) {
        $err = $query->errorInfo();
        print_r($err);
        die("<br>Problem with acess to database<br>");
    }
    // for each entry
    while($entry = $query->fetch()) {
        ?>
          <article class="article">
                    <div class="article__item">
                        <h2 class="article__title"><?= $entry["article__title"] ?></h2>
                        <img src="img/<?= $entry["article__image"] ?>" alt="" class="article__image">
                        <div class="article__discription">
                            <p class="article__text"><?= $entry["article__text"] ?></p>
                        </div>
                    </div>
                </article>


     
        <?php
    } 
}

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   
    <title>Энерготех</title>
</head>

<body>
    <header class="header">
         <nav class="navbar">
             <div class="container">
                <button type="button" class="burger" onclick="document.querySelector('.nav-menu').classList.toggle('burger__expanded');">
                    <span class="burger__line">&nbsp;</span>
                    <span class="burger__line">&nbsp;</span>
                    <span class="burger__line">&nbsp;</span>
                </button>
                <ul class="nav-menu">
                    <li class="main-menu__menu-item"><a class="nav-menu__link" href="#">О компании</a></li>
                    <li class="main-menu__menu-item"><a class="nav-menu__link" href="#">Доставка</a></li>
                    <li class="main-menu__menu-item"><a class="nav-menu__link" href="#">Оплата</a></li>
                    <li class="main-menu__menu-item"><a class="nav-menu__link" href="#">Сервис</a></li>
                    <li class="main-menu__menu-item"><a class="nav-menu__link" href="#">Возврат</a></li>
                    <li class="main-menu__menu-item"><a class="nav-menu__link" href="#">Статьи</a></li>
                    <li class="main-menu__menu-item"><a class="nav-menu__link" href="#">Контакты</a></li>
                </ul>

             </div>
            

        </nav>

        </div>
        <div class="border__line">Линия</div>
        <div class="container">
            <div class="panel">
                <a class="site-logo" href="#"></a>
                <div class="search panel__search">
                    <div class="search__icon"></div>
                    <input type="search" placeholder="Поиск по товарам" class="search__input">
                    <input class="search__btn" type="button" value="search">
                </div>
                <div class="control__strut"></div>
                <div class="work-hour">
                    <div class="phone">8 (800) 707-99-24</div>
                    <time class="time">9.00 - 20.00 <span>ежедневно</span></time>
                </div>
                <div class="signs">
                    <a href="#" class="signs__item signs__chart signs__muted">0</a>
                    <a href="#" class="signs__item signs__likes">6</a>
                    <a href="#" class="signs__item signs__basket">17</a>
                </div>
            </div>
        </div>
        <div class="border__line">Линия</div>
        <div class="container">
            <ul class="production">
                <li class="production__item">
                    <a href="javascript:document.querySelector('.production').classList.toggle('production__expanded');void(0);"
                        class="production__link production__link_main">Продукция<br>
                        <div class="production__link-logo"></div>
                    </a>
                </li>
                <li class="production__item">
                    <a href="#" class="production__link">Стабилизаторы 220В</a>
                </li>
                <li class="production__item">
                    <a href="#" class="production__link">Стабилизаторы 380В</a>
                </li>
                <li class="production__item">
                    <a href="#" class="production__link">Генераторы 220В</a>
                </li>
                <li class="production__item">
                    <a href="#" class="production__link">Генераторы 380В</a>
                </li>
                <li class="production__item">
                    <a href="#" class="production__link">ИБП и батареи</a>
                </li>
                <li class="production__item">
                    <a href="#" class="production__link">Прочая техника</a>
                </li>
                <li class="production__item">
                    <a href="#" class="production__link">Услуги</a>
                </li>
                <li class="production__item">
                    <a href="#" class="production__link production__link--inviting">Акции</a>
                </li>
            </ul>


        </div>
        <div class="border__line  border__line--shadow">Линия</div>
        <div class="container">
            <ul class="bread-cramb">
                <li class="bread-cramb__item"><a href="#" class="bread-cramb__link">Главная</a></li>
                <li class="bread-cramb__item"><a href="#" class="bread-cramb__link">Статьи</a></li>
            </ul>
        </div>
        <div class="border__line">Линия</div>


    </header>
    <main class="main article-pagination__main ">
        <div class="container">
            <h1 class="title">Полезная информация</h1>

            <?php insertPagination($page, ceil( $count / $page_size)) ?>

            <div class="articles-list">

            <?php insertArticles($db, $page); ?>

            </div>
            <?php insertPagination($page, ceil( $count / $page_size)) ?>

    </main>


    </div>
    </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer__inner">
                <div class="address__items">
                    <address class="address">121471, г. Москва ул. Рябиновая 55 стр. 28</address>
                    <a href="mailto:prestizh06@mail.ru" class="email">prestizh06@mail.ru</a>
                    <div class="footer__phone">8(800)707-99-24</div>
                    <a href="#" class="footer__link">контакты</a>
                </div>

                <div class="schedule__items">
                    <div class="schedule__header">Режим работы:</div>
                    <div class="schedule__item">Пн-чт c 8.00 до 19.00</div>
                    <div class="schedule__item">Пт c 8.00 до 17.00</div>
                    <div class="schedule__item">Сб c 10.00 до 15.00</div>
                    <div class="schedule__item">Вс (по предварительной договоренности).</div>
                </div>

                <div class="links__items">
                    <a href="#" class="links__item">О компании</a>
                    <a href="#" class="links__item">Оплата</a>
                    <a href="#" class="links__item">Акции</a>
                    <a href="#" class="links__item">Сервис</a>
                    <a href="#" class="links__item">Доставка</a>
                    <a href="#" class="links__item">Возврат</a>
                    <a href="#" class="links__item links__item--long">Политика обработки персональных данных</a>
                </div>

              

                
            </div>

        </div>



    </footer>
</body>

</html>