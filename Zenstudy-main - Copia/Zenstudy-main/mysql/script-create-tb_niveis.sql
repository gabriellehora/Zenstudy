CREATE TABLE tb_niveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL
);

INSERT INTO tb_niveis (nome) VALUES
('fundamental'),
('medio'),
('enem');
