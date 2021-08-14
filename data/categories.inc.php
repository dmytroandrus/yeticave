<?php
$errors = [];
if (!$mysqli) {
	$errors['db_connect_error'] = 'Ошибка подключения к БД';
} else {
	$categories = mysqli_query($mysqli, 'SELECT * FROM `categories`');
	$categories = mysqli_fetch_all($categories, MYSQLI_ASSOC);
}