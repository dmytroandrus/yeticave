<?php

function priceToUah($price)
{
	$price = ceil($price);
	if ($price > 1000) {
		$price = number_format($price, 0, '.', ' ');
	}
	return $price . ' UAH';
}

function template($path, $params = [])
{
	ob_start();
	extract($params);
	require_once $path;

	return ob_get_clean();
}

function lastSellDate(string $date)
{
	date_default_timezone_set('Europe/Warsaw');
	return strtotime($date);
}
