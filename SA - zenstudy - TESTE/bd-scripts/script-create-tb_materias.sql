CREATE TABLE tb_materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    nivel_id INT NOT NULL,
    FOREIGN KEY (nivel_id) REFERENCES tb_niveis(id)
);

-- FUNDAMENTAL (nivel_id = 1)
INSERT INTO tb_materias (nome, nivel_id) VALUES
('Português',1),('Matemática',1),('Geografia',1),('Ciências',1),
('História',1),('Artes',1),('Educação Física',1),('Ensino Religioso',1),
('Inglês',1),('Espanhol',1),('Francês',1);

-- ENSINO MÉDIO (nivel_id = 2)
INSERT INTO tb_materias (nome, nivel_id) VALUES
('Português',2),('Matemática',2),('Física',2),('Química',2),
('Biologia',2),('Geografia',2),('História',2),('Sociologia',2),
('Filosofia',2),('Literatura',2),('Artes',2),('Educação Física',2),
('Inglês',2),('Espanhol',2),('Francês',2);

-- ENEM (nivel_id = 3)
INSERT INTO tb_materias (nome, nivel_id) VALUES
('Matemática',3),('Linguagens',3),('Ciências Humanas',3),
('Ciências da Natureza',3),('Redação',3);
