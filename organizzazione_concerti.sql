DROP DATABASE IF EXISTS organizzazione_concerti; 
CREATE DATABASE organizzazione_concerti;
a
USE organizzazione_concerti;

CREATE TABLE sale(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome TEXT,
    codice INT, 
    capienza INT
)
CREATE TABLE concerti (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    codice TEXT, 
    titolo TEXT, 
    descrizione TEXT, 
    data DATETIME,
    sala_id INT,
    FOREIGN KEY(sala_id) REFERENCES sale(id)
);