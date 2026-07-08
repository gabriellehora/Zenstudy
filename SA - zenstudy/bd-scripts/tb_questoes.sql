CREATE TABLE tb_questoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    materia VARCHAR(100) NOT NULL,
    nivel VARCHAR(100) NOT NULL,
    assunto VARCHAR(100) NOT NULL,
    pergunta TEXT NOT NULL,
    alternativa_a TEXT NOT NULL,
    alternativa_b TEXT NOT NULL,
    alternativa_c TEXT NOT NULL,
    alternativa_d TEXT NOT NULL,
    resposta_correta CHAR(1) NOT NULL
);