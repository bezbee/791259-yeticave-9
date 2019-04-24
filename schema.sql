CREATE DATABASE yeticave 
DEFAULT CHARACTER SET utf8
COLLATE utf8_unicode_cli;

USE yeticave;

CREATE TABLE categories (
	id_categories INT AUTO_INCREMENT PRIMARY KEY,
	category_name CHAR(64),
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
	author INT REFERENCES users(id_user),
	winner INT REFERENCES bids(id_user),
	category INT REFERENCES categories(id_category)
);

CREATE TABLE bids (
  id_bids INT AUTO_INCREMENT PRIMARY KEY,
	added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	offer INT,
	user INT REFERENCES users(id_users),
	lot INT REFERENCES lots(id_lots)
);

CREATE TABLE users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
	registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	email CHAR(64) UNIQUE NOT NULL,
	name CHAR(64),
	password CHAR(64) NOT NULL,
	avatar CHAR(64),
	contact CHAR(64),
	created_lots INT references lots(id_lots),
	past_bids INT references bids(id_bids)
);
