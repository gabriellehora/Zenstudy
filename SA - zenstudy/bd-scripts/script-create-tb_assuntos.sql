CREATE TABLE tb_assuntos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    materia_id INT NOT NULL,
    ano_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    FOREIGN KEY (materia_id) REFERENCES tb_materias(id),
    FOREIGN KEY (ano_id) REFERENCES tb_anos(id)
);
