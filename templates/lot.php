<?php require_once '../core/functions.php'?>

<span class="form__error form__error--bottom">
  <ul>

    <?php foreach ($errors as $error) : ?>
      <li>
        <?= $error ?>
      </li>
    <?php endforeach ?>

  </ul>

</span>
<section class="lot-item container">
  <h2><?= $title ?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="../<?= stristr($lot['img'], 'img') ?>" width="730" height="548" alt="Сноуборд">
      </div>
      <p class="lot-item__category">Категория: <span><?= $category['name'] ?></span></p>
      <p class="lot-item__description">
        <?= $lot['description'] ?>

      </p>
    </div>
    <div class="lot-item__right">
      <?php
      if (isset($_SESSION['name'])) : ?>
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?=$lot['deleted_at']?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?=$max_stake['value'] ?? $lot['price'] ?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка <span><?=$max_stake['value'] ?? $lot['price'] ?> </span>
            </div>
          </div>
          <form class="lot-item__form" action="../pages/stakes.php?id=<?= $lot['id'] ?>" method="post">
            <p class="lot-item__form-item">
              <label for="cost">Ваша ставка</label>
              <input id="cost" type="number" name="cost" placeholder="12 000">
            </p>
            <button type="submit" class="button">Сделать ставку</button>
          </form>
        </div>
      <?php endif ?>
      <div class="history">
        <h3>История ставок (<span><?= $cnt_stakes ?></span>)</h3>
        <table class="history__list">
          <?php
          if (isset($stakes)) :
            foreach ($stakes as $stake) :
          ?>
              <tr class="history__item">
                <td class="history__name"><?= $stake['name'] ?></td>
                <td class="history__price"><?= priceToUah($stake['value']) ?></td>
                <td class="history__time"><?= $stake['created_at'] ?></td>
              </tr>
          <?php
            endforeach;
          endif;
          ?>
        </table>
      </div>
    </div>
  </div>
</section>