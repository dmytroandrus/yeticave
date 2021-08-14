<?php
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
require_once '../data/avatar.inc.php';
include_once '../data/categories.inc.php';

$title = 'Вход';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Валидация
	$required = ['email', 'password'];
	$desc = ['email' => 'E-mail', 'password' => 'Пароль'];
	$errors = [];
	foreach ($required as $field) {
		if (empty($_POST[$field])) {
			$errors[$field] = "Поле $desc[$field] не заполнено";
		}
	}

	if (count($errors)) {
		$content = template('../templates/login.php', ['errors' => $errors]);
	} else {
			// Успешная валидация
			$email = strip_tags($_POST['email']);
			$password = strip_tags($_POST['password']);

			// Вытаскиваем пользователей из базы и проверяем хэши паролей
			$users = mysqli_query($mysqli, "SELECT * FROM users");
			$users = mysqli_fetch_all($users, MYSQLI_ASSOC);
			foreach ($users as $user) {
				if ($user['email'] == $email && password_verify($password, $user['password'])) {
					session_start();
					$_SESSION['name'] = $user['name'];
					header('Location: ../index.php');
					exit();
				}
		}

		$errors['fail'] = 'Неверный логин или пароль';
		$content = template('../templates/login.php', ['errors' => $errors]);
	}

	print(template(
		'../templates/layout.php',
		[
			'title' => $title,
			'user_avatar' => $user_avatar,
			'content' => $content,
			'categories' => $categories,
			'errors' => $errors
		]
	));
} else {
	// Если пришли через GET

	if (isset($_SESSION['name'])) {
		unset($_SESSION['name']);
	}

	$content = template('../templates/login.php', []);

	print(template(
		'../templates/layout.php',
		[
			'title' => $title,
			'content' => $content,
			'categories' => $categories ?? '',
		]
	));
}
