-- ============================================================
-- PowerFit Academia - Script de criação do banco de dados
-- Disciplina: Programação Web II
-- SGBD: MySQL (InnoDB)
-- ============================================================

CREATE DATABASE IF NOT EXISTS powerfit_academia
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE powerfit_academia;

-- ------------------------------------------------------------
-- Tabela: planos
-- Guarda os planos de assinatura que a academia oferece
-- (ex: Mensal, Semestral, Anual). Cada aluno estará vinculado
-- a um único plano.
-- ------------------------------------------------------------
CREATE TABLE planos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    descricao TEXT
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabela: modalidades
-- Guarda as modalidades/atividades oferecidas pela academia
-- (ex: Musculação, Funcional, Ritmos, Lutas). Cada aluno
-- estará vinculado a uma modalidade principal.
-- ------------------------------------------------------------
CREATE TABLE modalidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabela: alunos
-- Guarda os dados cadastrais de cada aluno matriculado.
-- Relaciona-se com "planos" (qual plano o aluno contratou) e
-- com "modalidades" (qual atividade o aluno pratica).
-- ------------------------------------------------------------
CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(20),
    data_nascimento DATE NOT NULL,
    data_matricula DATE NOT NULL DEFAULT (CURRENT_DATE),
    plano_id INT NOT NULL,
    modalidade_id INT NOT NULL,

    UNIQUE KEY uk_alunos_cpf (cpf),
    UNIQUE KEY uk_alunos_email (email),

    CONSTRAINT fk_alunos_plano
        FOREIGN KEY (plano_id) REFERENCES planos(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_alunos_modalidade
        FOREIGN KEY (modalidade_id) REFERENCES modalidades(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- INSERTs de exemplo, para testar os CRUDs
-- ============================================================

-- Planos
INSERT INTO planos (nome, preco, descricao) VALUES
('Mensal', 129.90, 'Plano com renovação mensal, sem fidelidade'),
('Semestral', 109.90, 'Plano com pagamento a cada 6 meses, valor mensal reduzido'),
('Anual', 89.90, 'Plano anual, menor valor mensal, maior economia');

-- Modalidades
INSERT INTO modalidades (nome, descricao) VALUES
('Musculação', 'Treino de força com pesos livres e máquinas'),
('Funcional', 'Treino de alta intensidade com movimentos variados'),
('Lutas', 'Aulas de artes marciais e lutas em geral');

-- Alunos (plano_id e modalidade_id apontam para os IDs inseridos acima: 1, 2, 3)
INSERT INTO alunos (nome, cpf, email, telefone, data_nascimento, data_matricula, plano_id, modalidade_id) VALUES
('João Silva', '111.111.111-11', 'joao.silva@email.com', '(11) 91111-1111', '2000-05-14', '2026-01-10', 1, 1),
('Maria Oliveira', '222.222.222-22', 'maria.oliveira@email.com', '(11) 92222-2222', '1998-11-02', '2026-02-20', 2, 2),
('Carlos Souza', '333.333.333-33', 'carlos.souza@email.com', '(11) 93333-3333', '2003-07-30', '2026-03-05', 3, 3);
