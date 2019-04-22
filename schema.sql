CREATE DATABASE yeticave 
DEFAULT CHARACTER SET utf8;

CREATE TABLE categories (
	id_categories INT AUTO_INCREMENT PRIMARY KEY,
	category_name TEXT,
	category_class CHAR(64)
);

CREATE TABLE lots (
  id_lots INT AUTO_INCREMENT PRIMARY KEY,
	created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	title CHAR(128),
	description CHAR(128),
	image CHAR,
	starting_price INT,
	end_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	bid INT,
	author CHAR(128),
	winner CHAR(128),
	category CHAR(64)
);

CREATE TABLE bids (
  id_bids INT AUTO_INCREMENT PRIMARY KEY,
	added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	offer INT,
	USER CHAR(128),
	lot CHAR(128)
);

CREATE TABLE users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
	registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	email CHAR(64) UNIQUE NOT NULL,
	name CHAR(64),
	PASSWORD CHAR(64) NOT NULL,
	avatar CHAR(64),
	contact CHAR(64),
	created_lots CHAR(128),
	past_bids CHAR(64)
);

INSERT into categories 
(category_name, category_class) VALUES
('Доски и лыжи', 'boards'), 
('Крепления', 'attachment'),
('Ботинки', 'boots'),
('Одежда', 'clothing'),
('Инструменты', 'tools'),
('Разное', 'other');

