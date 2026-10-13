CREATE TABLE IF NOT EXISTS comments (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(254) NOT NULL,
    text TEXT NOT NULL,
    date VARCHAR(10) NOT NULL,
    PRIMARY KEY (id),
    KEY comments_date_index (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
