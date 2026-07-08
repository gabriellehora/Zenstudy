CREATE TABLE tb_agenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cadastro INT NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    horario TIME NOT NULL,
    dt_data DATE NOT NULL,
    cor VARCHAR(7) NOT NULL DEFAULT '#3788d8',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_agenda_usuario
        FOREIGN KEY (id_cadastro)
        REFERENCES tb_cadastro(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;