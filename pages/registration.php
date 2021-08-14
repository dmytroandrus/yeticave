<?php
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
require_once '../data/avatar.inc.php';
require_once '../data/categories.inc.php';

$title = 'Регистрция';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Валидация полей
	$required = ['email', 'password', 'name', 'message'];
	$desc = ['email' => 'E-mail', 'password' => 'Пароль', 'name' => 'Имя', 'message' => 'Контактные данные'];

	foreach ($required as $field) {
		if (empty($_POST[$field])) {
			$errors[$field] = "Поле $desc[$field] не заполнено";
		}
	}

	if (count($errors)) {
		$content = template('../templates/signup.php', ['errors' => $errors]);
	} else {
		$email = strip_tags($_POST['email']);
		$password = password_hash(strip_tags($_POST['password']), PASSWORD_DEFAULT);
		$name = strip_tags($_POST['name']);
		$message = strip_tags($_POST['message']);

		// проверка email на уникальность
		$sql = "SELECT email FROM users";
		$emailsFromDB = mysqli_query($mysqli, $sql);
		$emailsFromDB = mysqli_fetch_all($emailsFromDB, MYSQLI_ASSOC);

		foreach ($emailsFromDB as $userEmail) {
			if ($userEmail['email'] == $email) {
				$errors['email_exist'] = 'Такой email уже используется';
				break;
			}
		}

		// Валидация изображения
		if (isset($_FILES['user_avatar'])) {
			$file_type = $_FILES['user_avatar']['type'];

			if ($file_type != 'image/jpeg') {
				$errors['user_img'] = 'Загрузите изображение в формате .jpg';
			}
		}

		if (!count($errors)) {
			// вставляем в базу
			$filename = $_FILES['user_avatar']['name'];
			$filepath = __DIR__ . '/img/' . $filename;

			$sql = "INSERT INTO users (email, name, img, password, message) VALUES(?, ?, ?, ?, ?)";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, 'sssss', $email, $name, $filepath, $password, $message);
			$res = mysqli_stmt_execute($stmt);

			if (!$res) {
				$errors['add_data_error'] = 'Ошибка сохраненмя данных в БД';
			}else {
				header('Location: /');
			}
		}
	}
}

if (count($errors)) {
	$content = template('../templates/signup.php', ['errors' => $errors]);
} else {
	$content = template('../templates/signup.php');
}
print(template(
	'../templates/layout.php',
	[
		'title' => $title,
		'user_avatar'=>$user_avatar ?? '',
		'content' => $content,
		'categories' => $categories,
	]
));
