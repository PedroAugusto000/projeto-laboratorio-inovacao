CREATE DATABASE AcervoReceitas;

use acervoreceitas;

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

CREATE TABLE receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    codigo_unico VARCHAR(20),
    categoria VARCHAR(100),
    opiniao_degustador TEXT,
    ingredientes TEXT,
    modo_preparo TEXT,
    descricao TEXT,
    numero_porcoes INT,
    nome_cozinheiro VARCHAR(255),
    nome_degustador VARCHAR(255),
    imagem_receita BLOB
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_categoria VARCHAR(50) NOT NULL
);

CREATE TABLE Livros (
	id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_unico VARCHAR(200),
    isbn INT UNIQUE NOT NULL,
    titulo VARCHAR(200),
    imagem BLOB
);

INSERT INTO categorias (nome_categoria) VALUES
('Massa'),
('Frios'),
('Almoço'),
('Lanches');

CREATE TABLE livros_receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    receita_id INT NOT NULL,
    FOREIGN KEY (livro_id) REFERENCES livros(id) ON DELETE CASCADE,
    FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE
);

INSERT INTO Login (usuario, senha) VALUES ('root', MD5('senac'));

INSERT INTO Login (usuario, senha) VALUES ('Pedro', MD5('123'));

ALTER TABLE receitas DROP COLUMN codigo_unico;
ALTER TABLE receitas DROP INDEX codigo_unico;
ALTER TABLE receitas ADD COLUMN codigo_unico VARCHAR(255);
ALTER TABLE livros MODIFY isbn VARCHAR(13);
INSERT INTO categorias (nome_categoria) VALUES ('Sobremesas'), ('Bebidas'), ('Saladas');
ALTER TABLE livros ADD COLUMN descricao TEXT;

ALTER TABLE Colaboradores ADD UNIQUE (rg);
ALTER TABLE livros ADD UNIQUE (isbn);

ALTER TABLE Login ADD COLUMN nivel_permissao ENUM('root', 'admin', 'usuario') DEFAULT 'usuario';

UPDATE Login SET nivel_permissao = 'root' WHERE usuario = 'root';








