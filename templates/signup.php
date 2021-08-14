  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $message = $_POST['message'];
  }
  ?>

  <form class="form container" enctype="multipart/form-data" action="../pages/registration.php" method="post">
    <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <span style="color:red">
      <ul>
        <?php if (isset($errors)) {
          foreach ($errors as $error) { ?>
            <li>
              <?= $error ?>
            </li>
        <?php }
        } ?>
      </ul>
    </span>
    <div class="form__item">
      <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" required value="<?= $email ?? '' ?>">
      <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль" required value="<?= $password ?? '' ?>">
      <span class="form__error">Введите пароль</span>
    </div>
    <div class="form__item">
      <label for="name">Имя*</label>
      <input id="name" type="text" name="name" placeholder="Введите имя" required value="<?= $name ?? '' ?>">
      <span class="form__error">Введите имя</span>
    </div>
    <div class="form__item">
      <label for="message">Контактные данные*</label>
      <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?= $message ?? '' ?></textarea>
      <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <div class="form__item form__item--file form__item--last">
      <label>Аватар</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="../img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" name = "user_avatar" type="file" id="photo2" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="/pages/login.php">Уже есть аккаунт</a>
  </form>
  </main>