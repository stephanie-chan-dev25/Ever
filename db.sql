CREATE DATABASE ever;

USE ever;

CREATE TABLE aliment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    qtt DOUBLE,
    prix DOUBLE
);

CREATE TABLE nutriment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE contenir (
    aliment_id INT NOT NULL,
    nutriment_id INT NOT NULL,
    qtt DOUBLE NOT NULL,
    
    PRIMARY KEY (aliment_id, nutriment_id),
    
    FOREIGN KEY (aliment_id) REFERENCES aliment(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (nutriment_id) REFERENCES nutriment(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

