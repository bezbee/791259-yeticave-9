CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8;

USE yeticave;

CREATE TABLE category (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        category VARCHAR(64),
                        class VARCHAR(64) UNIQUE
);

CREATE UNIQUE INDEX category_name ON category(category);

CREATE TABLE user (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    email VARCHAR(128) NOT NULL UNIQUE,
                    name VARCHAR(128) NOT NULL,
                    password VARCHAR(128) NOT NULL,
                    avatar VARCHAR(512),
                    contact VARCHAR(1000) NOT NULL
);

CREATE UNIQUE INDEX user_email ON user(email);

CREATE TABLE lot (
                   id INT AUTO_INCREMENT PRIMARY KEY,
                   user_id INT,
                   FOREIGN KEY (user_id) REFERENCES user(id),
                   winner INT,
                   FOREIGN KEY (winner) REFERENCES user(id),
                   winner_bid_id INT,
                   category INT,
                   FOREIGN KEY (category) REFERENCES category(id),
                   created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                   title VARCHAR(256) NOT NULL,
                   description VARCHAR(1000) NOT NUll,
                   image VARCHAR(512) NOT NULL,
                   starting_price INT UNSIGNED NOT NULL,
                   end_by TIMESTAMP DEFAULT '2019-01-01 00:00:00' NOT NUll,
                   bid_step INT UNSIGNED NOT NULL
);

CREATE INDEX open_lot_no_winner ON lot(winner, end_by);
CREATE INDEX lot_in_category ON lot(category, created_on DESC);
CREATE FULLTEXT INDEX lot_title_and_description ON lot(title, description);

CREATE TABLE bid (
                   id INT AUTO_INCREMENT PRIMARY KEY,
                   user_id INT,
                   FOREIGN KEY (user_id) REFERENCES user(id),
                   lot INT,
                   FOREIGN KEY (lot) REFERENCES lot(id),
                   added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                   offer INT UNSIGNED NOT NULL
);

CREATE INDEX added_bid ON bid(lot, added_on);
