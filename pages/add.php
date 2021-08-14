<?php
session_start();
if (!isset($_SESSION['name'])) {
	header('HTTP/1.0 403 Forbidden');
	exit();
}
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
require_once '../data/avatar.inc.php';
include_once '../data/categories.inc.php';

// require_once '../data/db.php';
if (!$mysqli) {
	$errors['db_connect_error'] = 'Ошибка подключения к БД';
} else {
	$title = 'Добавить лот';
	// user
	$query = mysqli_query($mysqli, "SELECT id FROM users WHERE name = '$_SESSION[name]'");
	$user = mysqli_fetch_assoc($query);
}

// Если пришли через POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Валидация
	$required = ['lot_name', 'category', 'message', 'lot_rate', 'lot_step', 'expire_date'];
	$desc = ['lot_name' => 'Наименование', 'category' => 'Категория', 'message' => 'Описание', 'lot_rate' => 'Начальная цена', 'lot_step' => 'Шаг ставки', 'expire_date' => 'Дата окончания торгов'];

	foreach ($required as $key) {
		if (empty($_POST[$key])) {
			$errors[$key] = "Поле $desc[$key] не заполнено";
		} elseif (!empty($_POST['lot_rate'])) {
			if (!is_numeric($_POST['lot_rate'])) {
				$errors['lot_rate'] = "Поле $desc[lot_rate] должно содержать только цифры";
			}
		} elseif (!empty($_POST['lot_step'])) {
			if (!is_numeric($_POST['lot_step'])) {
				$errors['lot_step'] = "Поле $desc[lot_step] должно содержать только цифры";
			}
		}
	}
	if ($_POST['category'] == 'Выберите категорию') {
		$errors['category'] = "Поле $desc[category] не заполнено";
	}


	// Валидация изображения
	if (isset($_FILES['lot_img'])) {
		$file_type = $_FILES['lot_img']['type'];
		if ($file_type != 'image/jpeg') {
			$errors['lot_img'] = 'Загрузите изображение в формате .jpg';
		}
	}

	// Генерация шаблона
	if (count($errors)) {
		$content = template(
			'../templates/add-lot.php',
			[
				'categories' => $categories,
				'lot' => $lot,
				'errors' => $errors,
			]
		);
	} else {
		// Собираем данные о товаре
		// Изображение
		$filename = $_FILES['lot_img']['name'];
		$img = __DIR__ . '/img/' . $filename;

		$lot_name = htmlspecialchars($_POST['lot_name']);
		$description = htmlspecialchars($_POST['message']);
		$price = (int)htmlspecialchars($_POST['lot_rate']);
		$step = (int)htmlspecialchars($_POST['lot_step']);
		$created_at = date('Y-m-d');
		$deleted_at = $_POST['expire_date'];
		$user_id = (int)$user['id'];
		$category = mysqli_query($mysqli, "SELECT id FROM categories WHERE name = '$_POST[category]'");
		$category = mysqli_fetch_assoc($category);
		$category_id = (int)$category['id'];
		$is_open = 1;
	
		$sql = "INSERT INTO lots (title, description, price, step, img, created_at, deleted_at, user_id, category_id, is_open) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, 'ssiisssiii', $lot_name, $description, $price, $step, $img, $created_at, $deleted_at, $user_id, $category_id, $is_open);
		$res = mysqli_stmt_execute($stmt);

		if (!$res) {
			echo mysqli_error($mysqli);
			die;
			$errors['add_data_error'] = 'Ошибка сохранения данных в БД';
			$content = template(
				'../templates/add-lot.php',
				[
					'categories' => $categories,
					'lot' => $lot,
					'errors' => $errors,
				]);
		} else {
			header('Location: /');
		}
	}

	print(template(
		'../templates/layout.php',
		[
			'title' => $title,
			'user_avatar' => $user_avatar,
			'content' => $content,
			'categories' => $categories,
			'errors' => $errors ?? '',
		]
	));
} else {
	// Если пришли через GET
	if (count($errors)) {
		$content = template(
			'../templates/errors.php',
			[
				'errors' => $errors
			]
		);
	} else {
		$content = template(
			'../templates/add-lot.php',
			['categories' => $categories,]
		);
	}

	print(template(
		'../templates/layout.php',
		[
			'title' => $title,
			'user_avatar' => $user_avatar,
			'content' => $content,
			'categories' => $categories,
		]
	));
}
