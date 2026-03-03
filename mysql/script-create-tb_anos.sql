CREATE TABLE tb_anos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    nivel_id INT NOT NULL,
    FOREIGN KEY (nivel_id) REFERENCES tb_niveis(id)
);

-- Fundamental (nivel_id = 1)
INSERT INTO tb_anos (nome, nivel_id) VALUES
('1º Ano',1),('2º Ano',1),('3º Ano',1),('4º Ano',1),('5º Ano',1),
('6º Ano',1),('7º Ano',1),('8º Ano',1),('9º Ano',1);

-- Ensino Médio (nivel_id = 2)
INSERT INTO tb_anos (nome, nivel_id) VALUES
('1º Ano',2),('2º Ano',2),('3º Ano',2);

-- ENEM (nivel_id = 3)
INSERT INTO tb_anos (nome, nivel_id) VALUES
('Matemática',3),('Linguagens',3),('Ciências Humanas',3),
('Ciências da Natureza',3),('Redação',3);
