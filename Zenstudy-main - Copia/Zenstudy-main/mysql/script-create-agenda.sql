CREATE TABLE tb_agenda (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    horario TIME NOT NULL,
    dt_data DATE NOT NULL
);