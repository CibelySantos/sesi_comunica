-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Jun-2025 às 15:18
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
  `data_envio` date NOT NULL DEFAULT current_timestamp(),
  `data_limite` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `formularios`
--

CREATE TABLE `formularios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estrutura da tabela `opcoes`
--

CREATE TABLE `opcoes` (
  `id` int(11) NOT NULL,
  `pergunta_id` int(11) NOT NULL,
  `texto` varchar(255) NOT NULL
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
  `curtidas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `publico`
--

CREATE TABLE `publico` (
  `id` int(11) NOT NULL,
  `formulario_id` int(11) NOT NULL,
  `publico_alvo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `submissoes`
--

CREATE TABLE `submissoes` (
  `id` int(11) NOT NULL,
  `formulario_id` int(11) NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Índices para tabela `opcoes`
--
ALTER TABLE `opcoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pergunta_id` (`pergunta_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `data_formularios`
--
ALTER TABLE `data_formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `formularios`
--
ALTER TABLE `formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de tabela `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `opcoes`
--
ALTER TABLE `opcoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `pdf`
--
ALTER TABLE `pdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `publico`
--
ALTER TABLE `publico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `submissoes`
--
ALTER TABLE `submissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Limitadores para a tabela `opcoes`
--
ALTER TABLE `opcoes`
  ADD CONSTRAINT `opcoes_ibfk_1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`);

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
