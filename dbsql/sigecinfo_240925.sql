-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/09/2025 às 09:15
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sigecinfo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `churchs`
--

CREATE TABLE `churchs` (
  `id` int(11) UNSIGNED NOT NULL,
  `country_id` varchar(2) DEFAULT NULL,
  `code_id` varchar(20) DEFAULT NULL,
  `church_name` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address_number` varchar(20) DEFAULT NULL,
  `zip_code` varchar(9) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'actived',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `churchs`
--

INSERT INTO `churchs` (`id`, `country_id`, `code_id`, `church_name`, `phone`, `photo`, `address`, `address_number`, `zip_code`, `city`, `state`, `observations`, `status`, `created_at`, `updated_at`, `login_created`, `login_updated`) VALUES
(1, 'BR', '21-0912', 'Barrocada', '(11) 99181-4245', 'images/2025/09/barrocada-1758630014.jpg', 'Rodovia Fernão Dias - Km 77,5 - Chácara Roma - Casa 2', 'SN', '02286-000', 'São Paulo', 'SP', 'Dias de Culto : DN 5N SN (RJM-DM)\r\nCulto Oficial : Domingo - 18:30, Quinta-feira - 20:00, Sábado - 19:30.\r\nReunião de Jovens e Menores, Domingo - 10:00.\r\nMinistério: Cooperador Ofício Ministerial: Alexandre da Silva, Cooperador de Jovens e Menores: Alexandre Antunes Lucas.', 'actived', '2025-09-23 15:11:18', '2025-09-23 22:05:17', 1, 1),
(2, 'BR', '21-0050', 'Jaçanã', '(11) 98867-3468', 'images/2025/09/jacana-1758629934.jpg', 'Rua José Buono', '65', '02273-120', 'São Paulo', 'SP', 'Dias de Culto: DN 4N 5T SN (RJM-DM). Telefone fixo: (11) 2241-5079.\r\nCulto Oficial: Domingo - 18:30 - TSS, Quarta-feira - 19:30 - TSS, Quinta-feira - 14:30 - TSS, Sábado - 19:30 - TSS.\r\nReunião de Jovens e Menores: Domingo - 10:00.\r\nMinistério: Ancião: EDUARDO COSTA DE ARAÚJO, ERIBELTO ACCARINI - Cooperador Ofício Ministerial: Anderson Patricio Soares Mendes - Diáconos: Benedicto David Coutinho, Dorival da Rocha Passos e Davi Haltmann Fernandes.\r\nCooperador de Jovens e Menores: José Claudino de Lima.', 'actived', '2025-09-23 15:17:00', '2025-09-23 22:05:21', 1, 1),
(3, 'BR', '21-0613', 'Jardim Ataliba Leonel', '(11) 99181-5285', NULL, 'Rua Manuel Vieira da Luz', '305', '02318-020', 'São Paulo', 'SP', 'Dias de Culto: DN 5N (RJM-DM)\r\nCulto Oficial: Domingo - 18:30, Quinta-feira - 19:30\r\nReunião de Jovens e Menores: Domingo - 10:00\r\nMinistério: Cooperador Ofício Ministerial: Silvio Leme da Silva, Cooperador de Jovens e Menores: Fabiano Batista dos Santos', 'actived', '2025-09-24 08:14:54', NULL, 1, NULL),
(4, 'BR', '21-0868', 'Jardim Cabuçu', '(11) 99331-7849', NULL, 'Rua Padre Estanislau Ticner', '224', '02238-120', 'São Paulo', 'SP', 'Dias de Culto58: DN 3N 5N (RJM-DM)\r\nCulto Oficial: Domingo - 18:30, Terça-feira - 19:30, Quinta-feira - 19:30.\r\nReunião de Jovens e Menores: Domingo - 10:00.\r\nMinistério: Cooperador Ofício Ministerial: Nelson Pires de Souza, Cooperador de Jovens e Menores: Everton Lopes da Silva.', 'actived', '2025-09-24 08:21:20', NULL, 1, NULL),
(5, 'BR', '21-0719', 'Jardim Fontalis', '(11) 97677-9487', NULL, 'Rua Presidente Bartolomé Mitre', '16', '02361-040', 'São Paulo', 'SP', 'Dias de Culto: DN 3N 5N (RJM-DM).\r\nCulto Oficial: Domingo - 18:30, Terça-feira - 19:30, Quinta-feira - 20:00.\r\nReunião de Jovens e Menores: Domingo - 10:00.\r\nMinistério: Cooperador Ofício Ministerial: Jeová Gomes Nepomuceno, Cooperador de Jovens e Menores: Ailton Germano do Nascimento.', 'actived', '2025-09-24 08:28:06', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `invitations`
--

CREATE TABLE `invitations` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `meeting_id` int(11) UNSIGNED NOT NULL,
  `sent` tinyint(1) DEFAULT 0,
  `sent_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `levels`
--

CREATE TABLE `levels` (
  `id` int(11) UNSIGNED NOT NULL,
  `level_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `levels`
--

INSERT INTO `levels` (`id`, `level_name`, `description`, `created_at`, `updated_at`, `login_created`, `login_updated`) VALUES
(1, 'Usuario', 'Acesso ao sistema apenas para visualização', '2025-09-16 19:56:18', NULL, NULL, NULL),
(2, 'Usuario Editor', 'Acesso ao sistema com visualização e edição de alguns itens ', '2025-09-16 19:56:18', NULL, NULL, NULL),
(3, 'Editor', 'Acesso ao sistema com edição de itens', '2025-09-16 19:56:46', NULL, NULL, NULL),
(4, 'Editor Administrador', 'Acesso ao sistema e painel de configuração com edição de algumas configurações', '2025-09-16 19:56:46', NULL, NULL, NULL),
(5, 'Administrador do Sistema', 'Acesso total ao sistema e configurações', '2025-09-16 19:56:58', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `meeting_date` datetime NOT NULL,
  `meeting_type` enum('online','presential') NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `church_id` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `report_access`
--

CREATE TABLE `report_access` (
  `id` int(11) UNSIGNED NOT NULL,
  `users` int(11) NOT NULL DEFAULT 1,
  `views` int(11) NOT NULL DEFAULT 1,
  `pages` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `report_access`
--

INSERT INTO `report_access` (`id`, `users`, `views`, `pages`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 9, '2025-09-16 23:46:18', '2025-09-17 02:06:24'),
(2, 3, 3, 56, '2025-09-17 12:02:29', '2025-09-17 19:33:59'),
(3, 2, 2, 41, '2025-09-18 12:36:47', '2025-09-18 19:40:13'),
(4, 7, 7, 21, '2025-09-19 11:44:27', '2025-09-19 21:10:04'),
(5, 3, 3, 48, '2025-09-22 12:21:34', '2025-09-22 18:58:28'),
(6, 2, 2, 11, '2025-09-23 12:53:49', '2025-09-23 18:41:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `report_online`
--

CREATE TABLE `report_online` (
  `id` int(11) UNSIGNED NOT NULL,
  `user` int(11) UNSIGNED DEFAULT NULL,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `agent` varchar(255) NOT NULL DEFAULT '',
  `pages` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `report_online`
--

INSERT INTO `report_online` (`id`, `user`, `ip`, `url`, `agent`, `pages`, `created_at`, `updated_at`) VALUES
(36, NULL, '10.23.237.242', '/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-23 18:41:11', '2025-09-23 18:41:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone_landline` varchar(20) DEFAULT NULL,
  `phone_mobile` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'registered' COMMENT 'registered, confirmed, trash',
  `level_id` int(11) UNSIGNED DEFAULT NULL,
  `position_id` int(11) UNSIGNED DEFAULT NULL,
  `church_id` int(11) UNSIGNED DEFAULT NULL,
  `observations` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `user_name`, `email`, `photo`, `phone_landline`, `phone_mobile`, `password`, `status`, `level_id`, `position_id`, `church_id`, `observations`, `created_at`, `updated_at`, `login_created`, `login_updated`) VALUES
(1, 'Rodolfo Romaioli Ribeiro de Jesus', 'rrrjesus@smsub.prefeitura.sp.gov.br', 'images/2025/09/rodolfos-romaioli-ribeiro-de-jesus-1758641834.png', '1149343235', '11991091365', '$2y$10$9p8CR1JBdKTVVp.kxQeRXexNGAsoQqAqY9pv4PbMubeWzzgUpDcCi', 'actived', 5, NULL, 1, '', '2025-09-16 20:02:09', '2025-09-24 06:13:26', NULL, 1),
(2, 'Isaias Grima Romaioli Ribeiro de Jesus', 'rodolfo.romaioli@gmail.com', 'images/2025/09/isaias-grima-romaioli-ribeiro-de-jesus-1758545973.png', '1199999999', '11999999999', '$2y$10$nRtJo2JSTuiSNVHENwObzuqHmR4ZTd6ojDzHM.Ex874o8WfcI225i', 'actived', 5, NULL, NULL, 'Teste de Obs', '2025-09-18 19:38:47', '2025-09-23 19:45:04', 1, 1),
(3, 'Teste', 'cotisuporte@smsub.prefeitura.sp.gov.br', NULL, '', '', '$2y$10$.TtXf6OcyYj3nYBu2g9JmOTaSR0Qd7Fci88wdZRfKs1hyuyUDZEXm', 'actived', 1, NULL, NULL, '', '2025-09-22 13:15:29', '2025-09-23 19:59:26', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_positions`
--

CREATE TABLE `user_positions` (
  `id` int(11) UNSIGNED NOT NULL,
  `position_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'actived' COMMENT 'registered, confirmed, trash',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user_positions`
--

INSERT INTO `user_positions` (`id`, `position_name`, `description`, `status`, `created_at`, `updated_at`, `login_created`, `login_updated`) VALUES
(1, 'Administração - brigada', 'Brigada', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(2, 'Administrador casa de oração', 'Administração', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(3, 'Ancião', 'Ministério', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(4, 'Apoio', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(5, 'Assessor', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(6, 'Auxiliar de enfermagem', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(7, 'Brigadista', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(8, 'Colaborador manutenção', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(9, 'Conselho fiscal', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(10, 'Cooperador jovens e menores', 'Ministério', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(11, 'Cooperador ofício ministerial', 'Ministério', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(12, 'Coordenador da brigada', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(13, 'Coordenador manutenção', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(14, 'Coordenador(a) cozinha', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(15, 'Coordenador(a) limpeza', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(16, 'Coordenadora(or) enfermagem', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(17, 'Coordenadora(or) médica(o) brigada', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(18, 'Diácono', 'Ministério', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(19, 'Encarregado regional', 'Ministério', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(20, 'Enfermeira(o)', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(21, 'Estacionamento', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(22, 'Fundo bíblico', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(23, 'Gestão livro azul', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(24, 'Instrutor brigada', 'Brigada', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(25, 'Instrutor brigada - bombeiro', 'Brigada', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(26, 'Instrutor brigada - saúde', 'Brigada', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(27, 'Intérprete', 'Ministério', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(28, 'Piedade', 'Ministério', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(29, 'Portaria', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(30, 'Porteiro', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(31, 'Som', 'Cargo', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(32, 'Técnica(o) de enfermagem', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(33, 'Vice coordenador manutenção', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(34, 'Vice-coordenador da brigada', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(35, 'Voluntário administração setor', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(36, 'Voluntário cozinha', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1),
(37, 'Voluntário limpeza', 'Voluntário', 'actived', '2025-09-25 02:38:22', '2025-09-24 06:40:31', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `churchs`
--
ALTER TABLE `churchs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_churches_created_by` (`login_created`),
  ADD KEY `fk_churches_updated_by` (`login_updated`);

--
-- Índices de tabela `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invitations_user` (`user_id`),
  ADD KEY `fk_invitations_meeting` (`meeting_id`),
  ADD KEY `fk_invitations_created_by` (`login_created`),
  ADD KEY `fk_invitations_updated_by` (`login_updated`);

--
-- Índices de tabela `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_levels_created_by` (`login_created`),
  ADD KEY `fk_levels_updated_by` (`login_updated`);

--
-- Índices de tabela `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_meetings_church` (`church_id`),
  ADD KEY `fk_meetings_created_by` (`login_created`),
  ADD KEY `fk_meetings_updated_by` (`login_updated`);

--
-- Índices de tabela `report_access`
--
ALTER TABLE `report_access`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `report_online`
--
ALTER TABLE `report_online`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_report_online_user` (`user`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_level` (`level_id`),
  ADD KEY `fk_users_position` (`position_id`),
  ADD KEY `fk_users_church` (`church_id`),
  ADD KEY `fk_users_created_by` (`login_created`),
  ADD KEY `fk_users_updated_by` (`login_updated`);

--
-- Índices de tabela `user_positions`
--
ALTER TABLE `user_positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_positions_created_by` (`login_created`),
  ADD KEY `fk_positions_updated_by` (`login_updated`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `churchs`
--
ALTER TABLE `churchs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `report_access`
--
ALTER TABLE `report_access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `report_online`
--
ALTER TABLE `report_online`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `user_positions`
--
ALTER TABLE `user_positions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `churchs`
--
ALTER TABLE `churchs`
  ADD CONSTRAINT `fk_churches_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_churches_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `invitations`
--
ALTER TABLE `invitations`
  ADD CONSTRAINT `fk_invitations_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invitations_meeting` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invitations_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invitations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `levels`
--
ALTER TABLE `levels`
  ADD CONSTRAINT `fk_levels_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_levels_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `fk_meetings_church` FOREIGN KEY (`church_id`) REFERENCES `churchs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_meetings_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_meetings_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `report_online`
--
ALTER TABLE `report_online`
  ADD CONSTRAINT `fk_report_online_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_church` FOREIGN KEY (`church_id`) REFERENCES `churchs` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_level` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_position` FOREIGN KEY (`position_id`) REFERENCES `user_positions` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `user_positions`
--
ALTER TABLE `user_positions`
  ADD CONSTRAINT `fk_positions_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_positions_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
