
CREATE DATABASE tarefas;

USE tarefas;

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(50) NOT NULL,
    criado_em DATE 
);

CREATE TABLE listas (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER NOT NULL,
    descricao TEXT NOT NULL,
    tema VARCHAR(50) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_conclusao TIMESTAMP NULL,
    CONSTRAINT fk_usuario
        FOREIGN KEY(usuario_id) 
        REFERENCES usuarios(id)
);

DELIMITER //

CREATE OR REPLACE PROCEDURE listagem(IN user_id INT)
BEGIN
    SELECT * FROM listas WHERE usuario_id = user_id;
END //

DELIMITER ;

CREATE VIEW vw_listagem_tarefas AS
SELECT id, descricao, tema, data_conclusao
FROM listas;

