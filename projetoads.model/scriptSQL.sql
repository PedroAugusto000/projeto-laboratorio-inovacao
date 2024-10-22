CREATE TABLE Login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE Colaboradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nome_fantasia VARCHAR(100),
    funcao VARCHAR(50) NOT NULL,
    rg VARCHAR(15) NOT NULL,
    data_ingresso DATE NOT NULL,
    salario DECIMAL(10, 2) NOT NULL,
    referencias TEXT
);

INSERT INTO Login (usuario, senha) VALUES ('root', MD5('senac'));

INSERT INTO Login (usuario, senha) VALUES ('Pedro Augusto', MD5('12345'));
