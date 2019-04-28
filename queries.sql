USE yeticave;

/*Добавляем существующий список категорий; */
INSERT into category
(category, class) VALUES
('Доски и лыжи', 'boards'),
('Крепления', 'attachment'),
('Ботинки', 'boots'),
('Одежда', 'clothing'),
('Инструменты', 'tools'),
('Разное', 'other');

/*Придумываем пару пользователей;*/
INSERT into user
(email, name, password, contact) VALUES
('abc@gmail.com', 'Ivan Petrov', 'hello', 'cell phone');
INSERT into user
(email, name, password, contact) VALUES
('got@gmail.com', 'Jaime Lannister', 'blood', 'do not contact');
INSERT into user
(email, name, password, contact) VALUES
('meow@cox.net', 'Maria Rodriguez', 'fine', 'contact by email');

/*Добавляем существующий список объявлений; */
INSERT into lot
(user_id, category, title, description, image, starting_price, end_by, bid_step) VALUES
('2', '1', '2014 Rossignol District Snowboard', 'Good condition', 'img/lot-1.jpg', '10999','2019-05-05 05:05:05', '1000');
INSERT into lot
(user_id, category, title, description, image, starting_price, end_by, bid_step) VALUES
('3', '1', 'DC Ply Mens 2016/2017 Snowboard', 'Never used. Was given as a gift. Need extra cash.', 'img/lot-2.jpg', '159999', '2019-06-10 10:10:10', '2500'),
('3', '2', 'Крепления Union Contact Pro 2015 года размер L/XL', 'They have been lightly used.', 'img/lot-3.jpg', '8000', '2019-04-05 21:21:21', '200');
INSERT into lot
(user_id, category, title, description, image, starting_price, end_by, bid_step) VALUES
('1', '3','Ботинки для сноуборда DC Mutiny Charocal','Run small', 'img/lot-4.jpg', '10999', '2019-10-10 12:12:12', '350'),
('1', '4', 'Куртка для сноуборда DC Mutiny Charocal', 'Needs to be sprayed with waterproof solution', 'img/lot-5.jpg', '7500', '2019-02-06 12:04:06', '400'),
('3', '6','Маска Oakley Canopy', 'img/lot-6.jpg', 'Good for beginners', '5400', '2019-05-06 14:00:04', '60');

/*Добавляем пару ставок для любого объявления;*/
INSERT into bid
(user_id, lot, offer) VALUES
('2', '3', '12000'),
('1', '4', '14500');

INSERT into bid
(user_id, lot, offer) VALUES
('1', '3', '2000');

/*Добавляем несколько ставок для одного лота от разных пользователей;*/
INSERT into bid
(user_id, lot, offer) VALUES
('2', '4', '12000'),
('3', '4', '14500');

/*Получаем все категории;*/
SELECT category, class FROM category;

/*Получаем самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;*/
SELECT title, starting_price, image, MAX(bid.offer) as price, category.category FROM lot
JOIN bid ON lot.id = bid.lot
JOIN category  ON lot.category = category.id
WHERE end_by > NOW()
group by lot.id, title, starting_price, image, category
;

/*Показываем лот по его id. Получаем также название категории, к которой принадлежит лот;*/
SELECT lot.*, category.category from lot
JOIN category  ON lot.category = category.id
WHERE lot.id = "3";

/*Обновляем название лота по его идентификатору;*/
UPDATE lot
SET title = 'UPDATED:'
WHERE id = '5';

/*Получаем список самых свежих ставок для лота по его идентификатору;*/
SELECT user_id, lot, added_on, offer from bid
WHERE bid.lot = '3'
order by added_on DESC;