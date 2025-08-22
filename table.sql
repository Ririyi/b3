-- Таблица для заявок
CREATE TABLE application (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    gender ENUM('male','female','other') NOT NULL,
    biography TEXT,
    agreed TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
);

-- Таблица для языков программирования
CREATE TABLE languages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

-- Таблица для связи "один ко многим" заявка-язык
CREATE TABLE application_languages (
    application_id INT UNSIGNED NOT NULL,
    language_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (application_id) REFERENCES application(id),
    FOREIGN KEY (language_id) REFERENCES languages(id)
);

INSERT INTO languages (name) VALUES
('Pascal'), ('C'), ('C++'), ('JavaScript'),
('PHP'), ('Python'), ('Java'), ('Haskel'),
('Clojure'), ('Prolog'), ('Scala'), ('Go');

ALTER TABLE application CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE languages CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE application_languages CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
