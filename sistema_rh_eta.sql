CREATE DATABASE IF NOT EXISTS engeta06_sistema_rh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE engeta06_sistema_rh;

CREATE TABLE IF NOT EXISTS colaboradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(20),
    nome VARCHAR(100) NOT NULL,
    funcao VARCHAR(100),
    cidade VARCHAR(50),
    polo VARCHAR(50),
    status ENUM('Ativo', 'Desligado') DEFAULT 'Ativo',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS documentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    colaborador_id INT NOT NULL,
    nome_arquivo VARCHAR(255) NOT NULL,
    caminho VARCHAR(255) NOT NULL,
    data_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (colaborador_id) REFERENCES colaboradores(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel ENUM('admin', 'usuario') DEFAULT 'usuario',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Usuário administrador padrão ()
INSERT IGNORE INTO usuarios (matricula, senha, nivel)
VALUES ('DEV', SHA2('1999', 256), 'admin');
