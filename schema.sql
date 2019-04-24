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
                    author INT,
                    winner INT,
                    category INT,
                    FOREIGN KEY (author) REFERENCES users(id_user),
                    FOREIGN KEY (winner) REFERENCES users(id_user),
                    FOREIGN KEY (category) REFERENCES categories(id_category)
);

CREATE TABLE bids (
                    id_bids INT AUTO_INCREMENT PRIMARY KEY,
                    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    offer INT,
                    user INT,
                    lot INT,
                    FOREIGN KEY (user) REFERENCES users(id_user),
                    FOREIGN KEY (lot) REFERENCES lots(id_lots)
);

CREATE TABLE users (
                     id_user INT AUTO_INCREMENT PRIMARY KEY,
                     registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     email CHAR(64) UNIQUE NOT NULL,
                     name CHAR(64),
                     password CHAR(64) NOT NULL,
                     avatar CHAR(64),
                     contact CHAR(64),
                     created_lots INT,
                     past_bids INT,
                     FOREIGN KEY (created_lots) REFERENCES lots(id_lots),
                     FOREIGN KEY (past_bids) REFERENCES bids(id_bids)
);
