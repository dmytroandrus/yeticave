-- Проект yeticave

-- Сущности:
-- Лоты
-- Категории
-- Пользователи
-- Ставки

-- Связи:
-- Лот-Пользоваатель
-- Лот-Категория
-- Ставка-Лот
-- Ставка-Пользователь


CREATE DATABASE yeticave;

USE yeticave;
CREATE TABLE users (
id INT PRIMARY KEY,
email CHAR(50),
name CHAR(50),
img CHAR(100),
password CHAR(50),
message LONGTEXT
);

CREATE TABLE lots
(
id INT PRIMARY KEY,
title CHAR(100),
description LONGTEXT,
price INT(10),
step INT(10),
img CHAR(100),
created_at datetime,
deleted_at datetime,
user_id INT,
category_id INT,
is_open TINYINT,
FULLTEXT ttl(title),
FULLTEXT desc(description),
);

CREATE TABLE categories
(
id INT PRIMARY KEY,
name CHAR(50)
);

CREATE TABLE stakes
(
id INT PRIMARY KEY,
value INT,
user_id INT,
lot_id INT,
created_at datetime,
deleted_at datetime
);