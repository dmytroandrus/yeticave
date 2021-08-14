-- Добавление категорий
INSERT INTO categories (name) VALUES ('Доски и лыжи');
INSERT INTO categories (name) VALUES ('Крепления');
INSERT INTO categories (name) VALUES ('Ботинки');
INSERT INTO categories (name) VALUES ('Одежда');
INSERT INTO categories (name) VALUES ('Инструменты');
INSERT INTO categories (name) VALUES ('Разное');

-- Добавление пользователей
INSERT INTO users (name, email, password) VALUES ('Игнат', 'ignat.v@gmail.com', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka');
INSERT INTO users (name, email, password) VALUES ('Леночка', 'kitty_93@li.ru', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa');
INSERT INTO users (name, email, password) VALUES ('Руслан', 'warrior07@mail.ru', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW');

-- Добавление лотов
INSERT INTO lots SET title='2020 Rossignol District Snowboard', description='Описание', price = '12999', img = 'img/lot-1.jpg', created_at = '2021-01-05', deleted_at = '2021-08-20', user_id = '1', category_id = '1';
INSERT INTO lots SET title='DC Ply MMens 2020/2021 Snowboard', description='Описание', price = '16999', img = 'img/lot-2.jpg', created_at = '2021-04-19', deleted_at = '2021-09-20', user_id = '3', category_id = '1';
INSERT INTO lots SET title='Крепления Union Contact Pro 2021 года размер X/XL', description='Описание', price = '6999', img = 'img/lot-3.jpg', created_at = '2021-09-09', deleted_at = '2021-11-17', user_id = '2', category_id = '2';
INSERT INTO lots SET title='Ботинки для сноуборда DC Mutiny Charocal', description='Описание', price = '11999', img = 'img/lot-4.jpg', created_at = '2021-02-16', deleted_at = '2021-12-29', user_id = '2', category_id = '3';
INSERT INTO lots SET title='Куртка для сноуборда DC Mutiny Charocal', description='Описание', price = '7999', img = 'img/lot-5.jpg', created_at = '2021-06-20', deleted_at = '2021-08-02', user_id = '3', category_id = '4';
INSERT INTO lots SET title='Маска Oakley Canopy', description='Описание', price = '3499', img = 'img/lot-6.jpg', created_at = '2021-05-01', deleted_at = '2021-10-20', user_id = '1', category_id = '6';

-- Добавление ставок
INSERT INTO stakes SET value='13500', user_id='2', lot_id = '1', created_at = '2021-06-01';
INSERT INTO stakes SET value='14000', user_id='3', lot_id = '1', created_at = '2021-06-02';
INSERT INTO stakes SET value='14000', user_id='3', lot_id = '2', created_at = '2021-06-03';
INSERT INTO stakes SET value='14000', user_id='3', lot_id = '2', created_at = '2021-06-04';
INSERT INTO stakes SET value='14000', user_id='3', lot_id = '2', created_at = '2021-06-05';
INSERT INTO stakes SET value='14000', user_id='3', lot_id = '1', created_at = '2021-06-06';
INSERT INTO stakes SET value='14000', user_id='3', lot_id = '3', created_at = '2021-06-07';
INSERT INTO stakes SET value='14000', user_id='3', lot_id = '3', created_at = '2021-06-08';
INSERT INTO stakes SET value='14000', user_id='3', lot_id = '3', created_at = '2021-06-09';

-- Получить все категории
SELECT * FROM categories;

-- Получить самые новые открытые лоты...
SELECT title, price, img, c.name AS category, s.value, s.lot_id AS stake FROM lots l JOIN categories c ON l.category_id = c.id LEFT JOIN stakes s ON s.lot_id = l.id WHERE is_open != 0 ORDER BY l.created_at DESC;

-- Показать лот с категорией по его id
SELECT title, c.name FROM lots l JOIN categories c ON l.category_id = c.id WHERE l.id = 3;

-- Обновить название лота по id
UPDATE lots SET title = 'Маска Oakley Canopy 12' WHERE id = '6';

-- Список самых свежих ставок по его id
SELECT s.value, s.user_id, s.created_at FROM stakes s JOIN lots l ON l.id = s.lot_id WHERE l.id = 1 ORDER BY created_at DESC;

