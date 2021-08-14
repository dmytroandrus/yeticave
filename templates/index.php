<?php
require_once 'core/functions.php';
?>
<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!-- <li class="promo__item promo__item--boards">
                <a class="promo__link" href="/pages/all-lots.html">Доски и лыжи</a>
            </li>
            <li class="promo__item promo__item--attachment">
                <a class="promo__link" href="all-lots.html">Крепления</a>
            </li>
            <li class="promo__item promo__item--boots">
                <a class="promo__link" href="all-lots.html">Ботинки</a>
            </li>
            <li class="promo__item promo__item--clothing">
                <a class="promo__link" href="all-lots.html">Одежда</a>
            </li>
            <li class="promo__item promo__item--tools">
                <a class="promo__link" href="all-lots.html">Инструменты</a>
            </li>
            <li class="promo__item promo__item--other">
                <a class="promo__link" href="all-lots.html">Разное</a>
            </li> -->
            <?php
            if (isset($categories)) :
                foreach ($categories as $category) : ?>
                    <li>
                        <a class="promo__link" href="/pages/category.php?id=<?= $category['id'] ?>"><?= $category['name'] ?></a>
                    </li>
            <?php
                endforeach;
            endif ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($lots as $lot) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="/<?= stristr($lot['img'], 'img') ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($lot['category']) ?></span>
                        <h3 class="lot__title"><a class="text-link" href="/pages/lot.php?id=<?= $lot['id'] ?>"><?= htmlspecialchars($lot['title']) ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><b class=""><?= priceToUah($lot['price']) ?></b></span>
                            </div>
                            <div class="lot__timer timer">
                                <p>Дата окончания:</p>
                                <?= $lot['deleted_at'] ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </section>

    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a href="../?page=<?=$previousPage?>">Назад</a></li>
        <?php
        if (isset($pages)) :
            foreach ($pages as $page) :
        ?>
                <!-- <li class="pagination-item pagination-item-active"><a>1</a></li> -->
                <li class="pagination-item"><a href="../?page=<?=$page?>"><?=$page?></a></li>
        <?php
            endforeach;
        endif;
        ?>

        <li class="pagination-item pagination-item-next"><a href="../?page=<?=$nextPage?>">Вперед</a></li>
    </ul>

</main>