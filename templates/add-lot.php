<?php
$lot_name = $_POST['lot_name'] ?? '';
$category = $_POST['category'] ?? 'Выберите категорию';
$message = $_POST['message'] ?? '';
$lot_rate = $_POST['lot_rate'] ?? '';
$lot_step = $_POST['lot_step'] ?? '';
$lot_date = $_POST['lot_date'] ?? '';

$class_name = isset($errors) ? 'form--invalid' : '';
$err_bottom = isset($errors) ? 'Заполните все поля' : '';
// var_dump($errors);
// var_dump($_POST);
?>
<form class="form form--add-lot container <?= $class_name ?>" action="../pages/add.php" method="post" enctype="multipart/form-data">
  <!-- form--invalid -->
  <h2>Добавление лота</h2>
  <div class="form__container-two">

    <div class="form__item <?= $name_invalid ?>">
      <!-- form__item--invalid -->
      <label for="lot-name">Наименование</label>
      <input id="lot-name" type="text" name="lot_name" placeholder="Введите наименование лота" value=<?= $lot_name ?>>
      <span class="form__error"><?= $name_err ?></span>
    </div>

    <div class="form__item <?= $category_invalid ?>">
      <label for="category">Категория</label>
      <select id="category" name="category" required>
        <option><?= $category ?></option>
        <?php foreach ($categories as $category) : ?>
          <option><?= $category['name'] ?></option>
        <?php endforeach ?>
      </select>
      <span class="form__error"><?= $category_err ?></span>
    </div>
  </div>

  <div class="form__item form__item--wide" class="form__item <?= $message_invalid ?>">
    <label for="message">Описание</label>
    <textarea id="message" name="message" placeholder="Напишите описание лота"><?= $message ?></textarea>
    <span class="form__error"><?= $message_err ?></span>
  </div>

  <div class="form__item form__item--file">
    <!-- form__item--uploaded -->
    <label>Изображение</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" name="lot_img" type="file" id="photo2" value="">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
  </div>
  <div class="form__container-three">

    <div class="form__item form__item--small" class="form__item <?= $rate_invalid ?>">
      <label for="lot-rate">Начальная цена</label>
      <input id="lot-rate" type="number" name="lot_rate" placeholder="0" value=<?= $lot_rate ?>>
      <span class="form__error"><?= $rate_err ?></span>
    </div>

    <div class="form__item form__item--small">
      <label for="lot-step">Шаг ставки</label>
      <input id="lot-step" type="number" name="lot_step" placeholder="0" value=<?= $lot_step ?>>
      <span class="form__error"><?= $step_err ?></span>
    </div>

    <div class="form__item">
      <label for="lot-date">Дата окончания торгов</label>
      <input class="form__input-date" id="lot-date" type="date" name="expire_date" value=<?= $lot_date ?>>
      <span class="form__error">Введите дату завершения торгов</span>
    </div>

  </div>
  <span class="form__error form__error--bottom">
    <ul>

      <?php foreach ($errors as $error) : ?>
        <li>
          <?= $error ?>
        </li>
      <?php endforeach ?>

    </ul>

    <?= $err_bottom ?>

  </span>
  <button type="submit" class="button">Добавить лот</button>
</form>