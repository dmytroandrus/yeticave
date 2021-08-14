  <?php
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  ?>
  <form class="form container" action="../pages/login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$email?>">
      <span class="form__error"></span>
    </div>
    <div class="form__item form__item--last">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?=$password?>">
      <span class="form__error"></span>
      <?php if(isset($errors['fail'])) echo($errors['fail']) ?>
    </div>
    <button type="submit" class="button">Войти</button>
    <span style="color:red">
      <ul>
        <?php if (isset($errors)){
          foreach ($errors as $error){?>
            <li>
              <?=$error?>
            </li>
          <?php }}?>
      </ul>
      </span>
  </form>
</main>

