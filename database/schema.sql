-- =====================================================================
-- RFID TOOLS · Sistema de Monitoramento de Ferramentas
-- Schema do banco de dados
-- =====================================================================
-- Como usar:
--   1. Crie o banco (se ainda não existir):  CREATE DATABASE rfid_tools;
--   2. Rode este arquivo inteiro no phpMyAdmin (aba "Importar")
--      ou via terminal:  mysql -u root -p rfid_tools < database/schema.sql
-- =====================================================================

CREATE DATABASE IF NOT EXISTS rfid_tools CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rfid_tools;

-- ---------------------------------------------------------------------
-- Funcionários (quem faz login e quem pega/devolve ferramentas)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS funcionarios (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    nome           VARCHAR(120)  NOT NULL,
    email          VARCHAR(150)  NOT NULL UNIQUE,
    matricula      VARCHAR(30)   NOT NULL UNIQUE,
    departamento   VARCHAR(80)   NOT NULL,
    tag_rfid       VARCHAR(60)   NOT NULL UNIQUE,
    cargo          VARCHAR(40)   NOT NULL DEFAULT 'operador',
    senha_hash     VARCHAR(255)  NOT NULL,
    ativo          TINYINT(1)    NOT NULL DEFAULT 1,
    criado_em      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Ferramentas (o inventário monitorado por RFID)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS ferramentas (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    nome           VARCHAR(120)  NOT NULL,
    codigo         VARCHAR(30)   NOT NULL UNIQUE,
    tag_rfid       VARCHAR(60)   NOT NULL UNIQUE,
    categoria      VARCHAR(60)   NOT NULL DEFAULT 'geral',
    localizacao    VARCHAR(80)   NOT NULL DEFAULT 'Almoxarifado',
    status         ENUM('disponivel', 'emprestada', 'manutencao') NOT NULL DEFAULT 'disponivel',
    criado_em      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Movimentações (cada leitura de tag gera um empréstimo ou devolução)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS movimentacoes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    ferramenta_id   INT NOT NULL,
    funcionario_id  INT NOT NULL,
    tipo            ENUM('emprestimo', 'devolucao') NOT NULL,
    data_hora       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    observacao      VARCHAR(255) NULL,
    CONSTRAINT fk_mov_ferramenta   FOREIGN KEY (ferramenta_id)  REFERENCES ferramentas(id)  ON DELETE CASCADE,
    CONSTRAINT fk_mov_funcionario  FOREIGN KEY (funcionario_id) REFERENCES funcionarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Índices auxiliares para as consultas do painel
-- ---------------------------------------------------------------------
CREATE INDEX idx_mov_data ON movimentacoes (data_hora);
CREATE INDEX idx_ferramenta_status ON ferramentas (status);

-- ---------------------------------------------------------------------
-- Dados de exemplo (opcional — apague este bloco se não quiser)
-- Não incluímos um funcionário de exemplo aqui de propósito: a senha
-- precisa ser gerada pelo PHP (password_hash), então cadastre o primeiro
-- funcionário direto pela tela "Cadastrar funcionário" do sistema.
-- ---------------------------------------------------------------------
INSERT INTO ferramentas (nome, codigo, tag_rfid, categoria, localizacao, status) VALUES
('Furadeira de Impacto Bosch', 'FRM-001', 'TAG-FRM-0001', 'Elétrica', 'Almoxarifado A', 'disponivel'),
('Chave de Torque 1/2"',       'FRM-002', 'TAG-FRM-0002', 'Manual',   'Almoxarifado A', 'disponivel'),
('Multímetro Digital',         'FRM-003', 'TAG-FRM-0003', 'Medição',  'Almoxarifado B', 'disponivel'),
('Esmerilhadeira Angular',     'FRM-004', 'TAG-FRM-0004', 'Elétrica', 'Almoxarifado A', 'manutencao');
