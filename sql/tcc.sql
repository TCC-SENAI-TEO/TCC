-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 04-Ago-2023 às 10:30
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

DROP TABLE IF EXISTS `agendamentos`;
CREATE TABLE IF NOT EXISTS `agendamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_funcionarios` int NOT NULL,
  `id_horario` int NOT NULL,
  `id_sala` int NOT NULL,
  `data_agendamento` date NOT NULL,
  `inicio` date NOT NULL,
  `fim` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idf_pk_id` (`id_funcionarios`),
  KEY `fk_idh_pk_id` (`id_horario`),
  KEY `fk_ids_pk_id` (`id_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `id_funcionarios`, `id_horario`, `id_sala`, `data_agendamento`, `inicio`, `fim`) VALUES
(1, 2, 1, 1, '2023-06-30', '2023-06-30', '2023-06-30'),
(2, 1, 2, 2, '2023-06-30', '2023-06-30', '2023-06-30'),
(3, 1, 3, 2, '2023-06-30', '2023-06-30', '2023-06-30'),
(4, 1, 1, 2, '2023-06-30', '2023-07-04', '2023-07-04'),
(5, 1, 2, 2, '2023-06-30', '2023-07-04', '2023-07-04'),
(6, 1, 3, 2, '2023-06-30', '2023-07-04', '2023-07-04'),
(7, 1, 4, 2, '2023-06-30', '2023-07-04', '2023-07-04'),
(8, 1, 5, 2, '2023-06-30', '2023-07-04', '2023-07-04'),
(9, 1, 6, 2, '2023-06-30', '2023-07-04', '2023-07-04'),
(10, 2, 1, 6, '2023-07-04', '2023-07-05', '2023-07-05'),
(11, 2, 2, 6, '2023-07-04', '2023-07-05', '2023-07-05'),
(12, 2, 3, 6, '2023-07-04', '2023-07-05', '2023-07-05'),
(13, 2, 1, 6, '2023-07-04', '2023-07-04', '2023-07-04'),
(14, 2, 2, 6, '2023-07-04', '2023-07-04', '2023-07-04'),
(15, 2, 3, 6, '2023-07-04', '2023-07-04', '2023-07-04'),
(16, 2, 4, 6, '2023-07-04', '2023-07-04', '2023-07-04'),
(17, 2, 4, 1, '2023-07-07', '2023-07-07', '2023-07-07'),
(18, 2, 1, 2, '2023-07-11', '2023-07-11', '2023-07-11'),
(19, 2, 2, 2, '2023-07-11', '2023-07-11', '2023-07-11'),
(20, 2, 3, 2, '2023-07-11', '2023-07-11', '2023-07-11'),
(21, 2, 1, 4, '2023-08-01', '2023-08-01', '2023-08-01'),
(22, 2, 2, 4, '2023-08-01', '2023-08-01', '2023-08-01'),
(23, 2, 3, 4, '2023-08-01', '2023-08-01', '2023-08-01'),
(24, 1, 5, 8, '2023-08-01', '2023-08-02', '2023-08-02'),
(25, 1, 6, 8, '2023-08-01', '2023-08-02', '2023-08-02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf16 NOT NULL,
  `email` varchar(120) CHARACTER SET utf16 NOT NULL,
  `nivel` int NOT NULL,
  `senha` varchar(50) CHARACTER SET utf16 NOT NULL,
  `img` blob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `email`, `nivel`, `senha`, `img`) VALUES
(1, 'Francisco Teófilo de Resende Netto', '00008512@fiemg.com.br', 1, '1234', NULL),
(2, 'Gabriel Henrique', '0000909622@alunosesimg.com.br', 2, '1234', ''),
(3, 'Joao Marcos Pinto', '0000903387@alunosesimg.com.br', 2, '123', NULL),
(4, 'Renan Lima', '0000908675@alunosesimg.com.br', 2, '12345', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario`
--

DROP TABLE IF EXISTS `horario`;
CREATE TABLE IF NOT EXISTS `horario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inicio` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `fim` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `entidades` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `horario`
--

INSERT INTO `horario` (`id`, `inicio`, `fim`, `entidades`) VALUES
(1, '7:00', '7:50', NULL),
(2, '7:50', '8:40', NULL),
(3, '8:40', '9:30', NULL),
(4, '9:50', '10:40', NULL),
(5, '10:40', '11:30', NULL),
(6, '11:30', '12:20', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `salas`
--

DROP TABLE IF EXISTS `salas`;
CREATE TABLE IF NOT EXISTS `salas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `capacidade` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `salas`
--

INSERT INTO `salas` (`id`, `codigo`, `descricao`, `capacidade`) VALUES
(1, '102E', 'informatica', 40),
(2, '102D', 'informatica', 40),
(3, '301A', 'Comum', 30),
(4, '202B', 'Comum', 25),
(5, '203B', 'Comum', 30),
(6, '301B', 'Comum', 25),
(7, '203C', 'Laboratorio', 20),
(8, '402A', 'Comum', 20);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `fk_idf_pk_id` FOREIGN KEY (`id_funcionarios`) REFERENCES `funcionarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idh_pk_id` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ids_pk_id` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
