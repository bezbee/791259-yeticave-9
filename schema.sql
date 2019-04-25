CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8;

USE yeticave;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(64),
    category_class VARCHAR(64) UNIQUE
);

CREATE UNIQUE INDEX category_name ON category(category_name);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL UNIQUE,
    name VARCHAR(128) NOT NULL,
    password VARCHAR(128) NOT NULL,
    avatar VARCHAR(512),
    contact VARCHAR(1000)
);

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    winner INT,
    FOREIGN KEY (winner) REFERENCES user(id),
    category INT,
    FOREIGN KEY (category) REFERENCES category(id),
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(256) NOT NULL,
    description VARCHAR(1000),
    image VARCHAR(512) NOT NULL,
    starting_price INT UNSIGNED NOT NULL,
    end_by TIMESTAMP DEFAULT '2019-01-01 00:00:00',
    bid_step INT UNSIGNED NOT NULL
);

CREATE TABLE bid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    lot INT,
    FOREIGN KEY (lot) REFERENCES lot(id),
    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    offer INT UNSIGNED
);
