USE appdb;

-- two roles: customer = 0 and seller = 1
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(300) UNIQUE NOT NULL,
    password_hash VARCHAR(300) NOT NULL,
    first_name VARCHAR(300) NOT NULL,
    last_name VARCHAR(300) NOT NULL,
    address VARCHAR(300) NOT NULL,
    role TINYINT UNSIGNED DEFAULT 0,
    question VARCHAR(300) NOT NULL,
    answer VARCHAR(300) NOT NULL
);

-- a seller can publish more books but a book
-- belongs to only one seller
CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(300) NOT NULL UNIQUE,
    pages SMALLINT UNSIGNED NOT NULL,
    price SMALLINT UNSIGNED NOT NULL,
    genres VARCHAR(300),
    authors VARCHAR(300) NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    description TEXT NOT NULL,
    seller_id INT NOT NULL,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

-- a user can write more reviews but a review
-- belongs to only one user
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    body TEXT NOT NULL,
    mark TINYINT UNSIGNED NOT NULL,
    writing_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

CREATE TABLE cards (
    id INT PRIMARY KEY AUTO_INCREMENT,
    card_number CHAR(16) NOT NULL,
    cvv CHAR(3) NOT NULL,
    expiring_date TIMESTAMP,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- carts of users, where to each user is associated
-- a list of books with their quantities
CREATE TABLE carts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    quantity INT NOT NULL,
    book_id INT NOT NULL UNIQUE,
    user_id INT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    quantity INT NOT NULL,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);