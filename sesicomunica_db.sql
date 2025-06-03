-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Jun-2025 às 21:23
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
-- Estrutura da tabela `comunicados`
--

CREATE TABLE `comunicados` (
  `id` int(11) NOT NULL,
  `data_comunicado` date NOT NULL,
  `arquivo_comunicado` mediumblob NOT NULL,
  `nome` varchar(100) NOT NULL,
  `destinatario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 4, '2025-04-08', '2025-04-23');

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `categoria` varchar(50) NOT NULL,
  `data_inicio` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `descricao`, `categoria`, `data_inicio`) VALUES
(11, 'MundoSENAI', 'Evento para as famílias conhecerem os curso do SENAI', 'medio', '2025-06-02 00:00:00'),
(13, 'Festa Junina', 'Danças', 'fundamental1', '2025-06-14 00:00:00'),
(14, 'Teste', 'teste', 'fundamental2', '2025-06-11 00:00:00');

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
(4, 'Formulario das familias');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

CREATE TABLE `imagens` (
  `id` int(11) NOT NULL,
  `projeto_id` int(11) DEFAULT NULL,
  `caminho` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pdf`
--

CREATE TABLE `pdf` (
  `id` int(11) NOT NULL,
  `data_pdf` date NOT NULL,
  `arquivo_pdf` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `formulario_id` int(11) DEFAULT NULL,
  `pergunta` text NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `tipo_pergunta` varchar(50) NOT NULL,
  `min_classificacao` int(11) DEFAULT NULL,
  `max_classificacao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `perguntas`
--

INSERT INTO `perguntas` (`id`, `formulario_id`, `pergunta`, `tipo`, `tipo_pergunta`, `min_classificacao`, `max_classificacao`) VALUES
(10, 3, 'Qual seu nome completo?', 'text', '', NULL, NULL),
(11, 3, 'Está matriculado em alguma faculdade? Se sim qual a faculdade?', 'text', '', NULL, NULL),
(13, 3, 'Esta trabalhando? Se sim, qual a sua área de atuação?', 'text', '', NULL, NULL),
(14, 3, 'Pretende fazer alguma graduação?', 'text', '', NULL, NULL),
(15, 4, 'Qual a faixa salarial?', 'text', '', NULL, NULL),
(16, 4, 'Quantos filhos tem matriculado?', 'text', '', NULL, NULL),
(17, 4, 'Qual seu nome completo?', 'text', '', NULL, NULL),
(18, 4, 'Tem alfguma restrição alimentar?', 'text', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `imagem1` varchar(255) DEFAULT current_timestamp(),
  `imagem2` varchar(255) DEFAULT current_timestamp(),
  `imagem3` varchar(255) DEFAULT current_timestamp(),
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `curtidas` int(11) DEFAULT 0,
  `imagem4` varchar(255) NOT NULL,
  `imagem5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `projetos`
--

INSERT INTO `projetos` (`id`, `nome`, `descricao`, `imagem1`, `imagem2`, `imagem3`, `criado_em`, `curtidas`, `imagem4`, `imagem5`) VALUES
(6, 'Professora Fabiana', 'Atividade de Geografia', 'img_683da2fb96e398.12639086.webp', 'img_683da2fb973be7.18502550.jpg', 'img_683da2fb978fd2.11144201.jpg', '2025-06-02 13:11:23', 0, '', ''),
(9, 'Professor Wshington', 'Obras de arte modernistas', 'img_683f46e97c3d46.80024431.png', 'img_683f46e97ca7e0.05862294.png', 'img_683f46e97d1ec4.32072500.png', '2025-06-03 19:03:05', 0, '', '');

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
(5, 4, 'alunos');

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
  `ordem` int(11) NOT NULL,
  `formulario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`id`, `submissao_id`, `pergunta_id`, `resposta`, `texto_opcao`, `ordem`, `formulario_id`) VALUES
(1, 3, 10, 'Lucas', '', 0, NULL),
(2, 3, 11, 'Sim', '', 0, NULL),
(4, 3, 13, 'Não', '', 0, NULL),
(5, 3, 14, 'Sim', '', 0, NULL),
(6, 4, 10, 'Teste', '', 0, NULL),
(7, 4, 11, 'Não', '', 0, NULL),
(9, 4, 13, 'Sim', '', 0, NULL),
(10, 4, 14, 'Não', '', 0, NULL),
(11, 5, 15, '2000', '', 0, NULL),
(12, 5, 16, '3', '', 0, NULL),
(13, 5, 17, 'Luis', '', 0, NULL),
(14, 5, 18, 'Não', '', 0, NULL),
(15, 6, 15, '20000', '', 0, NULL),
(16, 6, 16, '1', '', 0, NULL),
(17, 6, 17, 'Luis Felipe', '', 0, NULL),
(18, 6, 18, 'Sim', '', 0, NULL),
(25, 9, 10, 'Jacquys Barbosa da SIlva', '', 0, 3),
(26, 9, 11, 'Nao', '', 0, 3),
(28, 9, 13, 'Nao', '', 0, 3),
(29, 9, 14, 'Nao', '', 0, 3);

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
(9, 3, '2025-06-03 11:33:37');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_users` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `email_usuario` varchar(100) NOT NULL,
  `tipo_usuario` enum('administrador','professor') NOT NULL DEFAULT 'professor',
  `senha_usuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_users`, `nome_usuario`, `email_usuario`, `tipo_usuario`, `senha_usuario`) VALUES
(5, 'adm', 'adm@gmail.com', 'administrador', '$2y$10$4QTpRrTsrXmSwwutFJS4sOKN8TwpjOPex5K5u/EEZhJH.FnTeXLki'),
(6, 'professor', 'professor@gmail.com', 'professor', '$2y$10$rbJBpHCep/SVAzdsdwrxOOtH5bV9ZY8BGdVQ.1cYxOkoEaa8QAQ1i');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `comunicados`
--
ALTER TABLE `comunicados`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `data_formularios`
--
ALTER TABLE `data_formularios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulario_id` (`formulario_id`),
  ADD KEY `formulario_id_2` (`formulario_id`),
  ADD KEY `formulario_id_3` (`formulario_id`),
  ADD KEY `formulario_id_4` (`formulario_id`),
  ADD KEY `formulario_id_5` (`formulario_id`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `formularios`
--
ALTER TABLE `formularios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projeto_id` (`projeto_id`);

--
-- Índices para tabela `pdf`
--
ALTER TABLE `pdf`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulario_id` (`formulario_id`),
  ADD KEY `formulario_id_2` (`formulario_id`),
  ADD KEY `formulario_id_3` (`formulario_id`),
  ADD KEY `formulario_id_4` (`formulario_id`),
  ADD KEY `formulario_id_5` (`formulario_id`),
  ADD KEY `formulario_id_6` (`formulario_id`);

--
-- Índices para tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `publico`
--
ALTER TABLE `publico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulario_id` (`formulario_id`),
  ADD KEY `formulario_id_2` (`formulario_id`),
  ADD KEY `formulario_id_3` (`formulario_id`),
  ADD KEY `formulario_id_4` (`formulario_id`),
  ADD KEY `formulario_id_5` (`formulario_id`),
  ADD KEY `formulario_id_6` (`formulario_id`);

--
-- Índices para tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submissao_id` (`submissao_id`),
  ADD KEY `pergunta_id` (`pergunta_id`),
  ADD KEY `formulario_id` (`formulario_id`),
  ADD KEY `formulario_id_2` (`formulario_id`),
  ADD KEY `formulario_id_3` (`formulario_id`);

--
-- Índices para tabela `submissoes`
--
ALTER TABLE `submissoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulario_id` (`formulario_id`),
  ADD KEY `formulario_id_2` (`formulario_id`),
  ADD KEY `formulario_id_3` (`formulario_id`),
  ADD KEY `formulario_id_4` (`formulario_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `email_usuario` (`email_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comunicados`
--
ALTER TABLE `comunicados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `data_formularios`
--
ALTER TABLE `data_formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `formularios`
--
ALTER TABLE `formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pdf`
--
ALTER TABLE `pdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `publico`
--
ALTER TABLE `publico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `submissoes`
--
ALTER TABLE `submissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `data_formularios`
--
ALTER TABLE `data_formularios`
  ADD CONSTRAINT `data_formularios_ibfk_1` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_data_formularios_formulario` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `imagens`
--
ALTER TABLE `imagens`
  ADD CONSTRAINT `imagens_ibfk_1` FOREIGN KEY (`projeto_id`) REFERENCES `projetos` (`id`);

--
-- Limitadores para a tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD CONSTRAINT `fk_perguntas_formulario` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `perguntas_ibfk_1` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `publico`
--
ALTER TABLE `publico`
  ADD CONSTRAINT `fk_publico_formulario` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `publico_ibfk_1` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `fk_respostas_formulario` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`submissao_id`) REFERENCES `submissoes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_ibfk_2` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `submissoes`
--
ALTER TABLE `submissoes`
  ADD CONSTRAINT `fk_submissoes_formulario` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissoes_ibfk_1` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
