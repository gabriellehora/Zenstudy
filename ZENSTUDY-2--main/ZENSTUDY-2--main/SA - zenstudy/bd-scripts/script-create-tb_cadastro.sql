CREATE TABLE tb_cadastro(
  id INT AUTO_INCREMENT,
  nm_usuario VARCHAR(100),
  ds_senha VARCHAR(30),
  ds_email VARCHAR(80) NOT NULL,
  CONSTRAINT pk_usuario PRIMARY KEY(id)
);