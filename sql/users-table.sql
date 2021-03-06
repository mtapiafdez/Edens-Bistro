-- 2
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(10) NOT NULL,
    password VARCHAR(255) NOT NULL,
   	username VARCHAR(255) NOT NULL UNIQUE,
    user_address INT NOT NULL,
    FOREIGN KEY (user_address) REFERENCES addresses(address_id)
);

ALTER TABLE users
ADD isAdmin BIT NOT NULL DEFAULT 0;