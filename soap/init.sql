CREATE DATABASE IF NOT EXISTS soap;
USE soap;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mail VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);