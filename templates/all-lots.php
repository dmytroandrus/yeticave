  <div class="container">
    <section class="lots">
      <h2><span><?=$title ?? 'История просмотров'?></span></h2>
      <ul class="lots__list">
          <?php 
          if(isset($lots)):
          foreach ($lots as $lot):?>
          <li class="lots__item lot">
          <a href="../pages/lot.php?id=<?=$lot['id']?>">
          <div class="lot__image">
            <img src="/<?=stristr($lot['img'], 'img')?>" width="350" height="260" alt="img">
          </div>
          <div class="lot__info">
            <!-- <span class="lot__category"></span> -->
            <h3 class="lot__title"><a class="text-link" href="../pages/lot.php?id=<?=$lot['id']?>"><?=$lot['title']?></a></h3>
            <div class="lot__state">
              <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?=priceToUah($lot['price'])?></span>
              </div>
              <div class="lot__timer timer">
                <p>Дата завершения</p>
                <?=$lot['deleted_at']?>
              </div>
            </div>
          </div>
          </a>
        </li>
          <?php endforeach;
          endif?>
      </ul>
    </section>
  </div>
  </div>
