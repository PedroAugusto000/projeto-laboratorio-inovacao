CREATE DATABASE AcervoReceitas;
USE AcervoReceitas;

CREATE TABLE IF NOT EXISTS Login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,  
    nivel_permissao ENUM('root', 'admin', 'usuario') DEFAULT 'usuario'
);

INSERT INTO Login (usuario, senha, nivel_permissao) 
VALUES 
    ('root', MD5('senac'), 'root');

CREATE TABLE IF NOT EXISTS Colaboradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nome_fantasia VARCHAR(100),
    funcao VARCHAR(50) NOT NULL,
    rg VARCHAR(15) NOT NULL UNIQUE,
    data_ingresso DATE NOT NULL,
    salario DECIMAL(10, 2) NOT NULL,
    referencias TEXT
);

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_categoria VARCHAR(50) NOT NULL
);

INSERT INTO categorias (nome_categoria) 
VALUES 
    ('Massa'), 
    ('Frios'), 
    ('Almoço'), 
    ('Lanches'), 
    ('Sobremesas'), 
    ('Bebidas'), 
    ('Saladas');
    
INSERT INTO categorias (nome_categoria)
VALUE ('Bolos');

CREATE TABLE IF NOT EXISTS Livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_unico VARCHAR(200),
    isbn VARCHAR(13) UNIQUE NOT NULL, 
    titulo VARCHAR(200),
    descricao TEXT,
    imagem BLOB
);

CREATE TABLE IF NOT EXISTS receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    codigo_unico VARCHAR(255),
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

CREATE TABLE IF NOT EXISTS livros_receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    receita_id INT NOT NULL,
    FOREIGN KEY (livro_id) REFERENCES Livros(id) ON DELETE CASCADE,
    FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE
);

ALTER TABLE receitas 
    DROP COLUMN codigo_unico,
    ADD COLUMN codigo_unico VARCHAR(255);

ALTER TABLE Livros 
    MODIFY isbn VARCHAR(13);

ALTER TABLE Colaboradores ADD UNIQUE (rg);
ALTER TABLE Livros ADD UNIQUE (isbn);

UPDATE Login SET nivel_permissao = 'root' WHERE usuario = 'root';
