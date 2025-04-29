-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Abr-2025 às 21:19
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sesicomunica_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `data_formularios`
--

CREATE TABLE `data_formularios` (
  `id` int(11) NOT NULL,
  `formulario_id` int(11) NOT NULL,
  `data_envio` date NOT NULL,
  `data_limite` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `data_formularios`
--

INSERT INTO `data_formularios` (`id`, `formulario_id`, `data_envio`, `data_limite`) VALUES
(1, 3, '2025-04-08', '2025-04-23'),
(2, 4, '2025-04-08', '2025-04-23'),
(3, 8, '2025-04-08', '2025-04-23'),
(15, 34, '2025-04-17', '2025-04-18'),
(16, 35, '2025-04-17', '2025-04-30'),
(17, 36, '2025-04-17', '2025-04-30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `formularios`
--

CREATE TABLE `formularios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `formularios`
--

INSERT INTO `formularios` (`id`, `nome`) VALUES
(3, 'Formulário de Egressos'),
(4, 'Formulario das familias'),
(8, 'Formulário de Satisfação'),
(34, 'teste'),
(35, 'teste4'),
(36, 'teste5');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `formulario_id` int(11) DEFAULT NULL,
  `pergunta` text NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `tipo_pergunta` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `perguntas`
--

INSERT INTO `perguntas` (`id`, `formulario_id`, `pergunta`, `tipo`, `tipo_pergunta`) VALUES
(10, 3, 'Qual seu nome completo?', 'text', ''),
(11, 3, 'Está matriculado em alguma faculdade?', 'text', ''),
(12, 3, 'Se sim qual a faculdade?', 'text', ''),
(13, 3, 'Esta trabalhando?', 'text', ''),
(14, 3, 'Pretende fazer alguma graduação?', 'text', ''),
(15, 4, 'Qual a faixa salarial?', 'text', ''),
(16, 4, 'Quantos filhos tem matriculado?', 'text', ''),
(17, 4, 'Qual seu nome completo?', 'text', ''),
(18, 4, 'Tem alfguma restrição alimentar?', 'text', ''),
(31, 8, 'Qual seu nome completo?', 'text', 'dissertativa'),
(32, 8, 'Qual no escolar seu filho está?', 'text', 'dissertativa'),
(33, 8, 'Qual sua avaliação sobre a escola?', 'text', 'dissertativa'),
(45, 34, '1', '', 'dissertativa'),
(46, 35, 'oi', '', 'dissertativa'),
(47, 36, 'slamaleco', '', 'dissertativa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `publico`
--

CREATE TABLE `publico` (
  `id` int(11) NOT NULL,
  `formulario_id` int(11) NOT NULL,
  `publico_alvo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `publico`
--

INSERT INTO `publico` (`id`, `formulario_id`, `publico_alvo`) VALUES
(4, 3, 'alunos'),
(5, 4, 'alunos'),
(6, 8, 'alunos'),
(18, 34, 'professores'),
(19, 35, 'professores'),
(20, 36, 'alunos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `submissao_id` int(11) DEFAULT NULL,
  `pergunta_id` int(11) DEFAULT NULL,
  `resposta` text DEFAULT NULL,
  `texto_opcao` varchar(255) NOT NULL,
  `ordem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`id`, `submissao_id`, `pergunta_id`, `resposta`, `texto_opcao`, `ordem`) VALUES
(1, 3, 10, 'Lucas', '', 0),
(2, 3, 11, 'Sim', '', 0),
(3, 3, 12, 'Odontologia', '', 0),
(4, 3, 13, 'Não', '', 0),
(5, 3, 14, 'Sim', '', 0),
(6, 4, 10, 'Teste', '', 0),
(7, 4, 11, 'Não', '', 0),
(8, 4, 12, 'Nenhuma', '', 0),
(9, 4, 13, 'Sim', '', 0),
(10, 4, 14, 'Não', '', 0),
(11, 5, 15, '2000', '', 0),
(12, 5, 16, '3', '', 0),
(13, 5, 17, 'Luis', '', 0),
(14, 5, 18, 'Não', '', 0),
(15, 6, 15, '20000', '', 0),
(16, 6, 16, '1', '', 0),
(17, 6, 17, 'Luis Felipe', '', 0),
(18, 6, 18, 'Sim', '', 0),
(19, 7, 31, 'Luis', '', 0),
(20, 7, 32, '3º ano', '', 0),
(21, 7, 33, 'òtima', '', 0),
(22, 8, 31, 'ZDzinho', '', 0),
(23, 8, 32, '6º ano', '', 0),
(24, 8, 33, 'Horrivel', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `submissoes`
--

CREATE TABLE `submissoes` (
  `id` int(11) NOT NULL,
  `formulario_id` int(11) NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `submissoes`
--

INSERT INTO `submissoes` (`id`, `formulario_id`, `data_envio`) VALUES
(3, 3, '2025-02-25 10:09:52'),
(4, 3, '2025-02-25 10:10:36'),
(5, 4, '2025-02-25 10:14:27'),
(6, 4, '2025-02-25 10:14:39'),
(7, 8, '2025-02-25 11:00:50'),
(8, 8, '2025-02-25 11:01:01');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `data_formularios`
--
ALTER TABLE `data_formularios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_formularios_ibfk_1` (`formulario_id`);

--
-- Índices para tabela `formularios`
--
ALTER TABLE `formularios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulario_id` (`formulario_id`);

--
-- Índices para tabela `publico`
--
ALTER TABLE `publico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulario_id` (`formulario_id`);

--
-- Índices para tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submissao_id` (`submissao_id`),
  ADD KEY `pergunta_id` (`pergunta_id`);

--
-- Índices para tabela `submissoes`
--
ALTER TABLE `submissoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulario_id` (`formulario_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `data_formularios`
--
ALTER TABLE `data_formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `formularios`
--
ALTER TABLE `formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `publico`
--
ALTER TABLE `publico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `submissoes`
--
ALTER TABLE `submissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `data_formularios`
--
ALTER TABLE `data_formularios`
  ADD CONSTRAINT `data_formularios_ibfk_1` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD CONSTRAINT `perguntas_ibfk_1` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `publico`
--
ALTER TABLE `publico`
  ADD CONSTRAINT `publico_ibfk_1` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`submissao_id`) REFERENCES `submissoes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_ibfk_2` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `submissoes`
--
ALTER TABLE `submissoes`
  ADD CONSTRAINT `submissoes_ibfk_1` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
