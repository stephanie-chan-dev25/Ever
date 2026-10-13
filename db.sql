CREATE DATABASE ever;

USE ever;

CREATE TABLE food (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    quantity DOUBLE,
    price DOUBLE
);

CREATE TABLE nutrient (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE contains (
    food_id INT NOT NULL,
    nutrient_id INT NOT NULL,
    quantity DOUBLE NOT NULL,
    
    PRIMARY KEY (food_id, nutrient_id),
    
    FOREIGN KEY (food_id) REFERENCES food(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (nutrient_id) REFERENCES nutrient(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

