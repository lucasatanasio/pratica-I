create database empresa;

use empresa;

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(15) NOT NULL
);

CREATE TABLE colaboradores (
    id_colaborador INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE chamados (
    id_chamado INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    descricao TEXT NOT NULL,
    criticidade ENUM('baixa', 'média', 'alta') DEFAULT 'baixa',
    status ENUM('aberto', 'em andamento', 'resolvido') DEFAULT 'aberto',
    data_abertura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_colaborador INT,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_colaborador) REFERENCES colaboradores(id_colaborador)
);