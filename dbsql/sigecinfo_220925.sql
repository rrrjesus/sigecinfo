-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/09/2025 às 08:02
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
(7, 'BR', '99-9999', 'Jaaçanã', '(11) 99999-9999', 'images/2025/09/jaacana-1758520737.jpg', 'Rua teste', '235A', '99999-999', 'São Paulo', 'SP', 'Teste', 'actived', '2025-09-22 05:29:50', '2025-09-22 05:58:57', 3, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `churchs_example`
--

CREATE TABLE `churchs_example` (
  `id` int(11) UNSIGNED NOT NULL,
  `country_id` varchar(2) DEFAULT NULL,
  `code_id` int(12) UNSIGNED DEFAULT NULL,
  `church_name` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address_number` varchar(20) DEFAULT NULL,
  `zip_code` int(8) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `observations` int(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'actived',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 8, 8, 43, '2025-09-19 11:44:27', '2025-09-20 02:57:50'),
(5, 3, 3, 12, '2025-09-20 03:00:05', '2025-09-21 00:50:46'),
(6, 2, 3, 9, '2025-09-21 03:13:31', '2025-09-22 02:32:00'),
(7, 2, 2, 9, '2025-09-22 03:04:44', '2025-09-22 05:27:58');

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
(38, NULL, '192.168.15.18', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-22 05:27:58', '2025-09-22 05:27:58');

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
(3, 'Rodolfo Romaioli Ribeiro de Jesus', 'rrrjesus@smsub.prefeitura.sp.gov.br', 'images/2025/09/rodolfo-romaioli-ribeiro-de-jesus-1758520835.jpg', '1199999999', '', '$2y$10$9p8CR1JBdKTVVp.kxQeRXexNGAsoQqAqY9pv4PbMubeWzzgUpDcCi', 'registered', 5, 1, 7, '', '2025-09-22 05:10:01', '2025-09-22 06:00:35', NULL, 3);

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
(1, 'Anciao', 'Ministério', 'disabled', '2025-09-16 19:57:33', '2025-09-20 14:20:35', NULL, NULL),
(2, 'Diácono', 'Ministério', 'actived', '2025-09-18 18:43:53', '2025-09-18 19:20:00', NULL, NULL),
(3, 'Informática', 'Voluntário', 'actived', '2025-09-18 19:20:18', NULL, NULL, NULL);

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
-- Índices de tabela `churchs_example`
--
ALTER TABLE `churchs_example`
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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `churchs_example`
--
ALTER TABLE `churchs_example`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `report_online`
--
ALTER TABLE `report_online`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `user_positions`
--
ALTER TABLE `user_positions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `fk_users_church` FOREIGN KEY (`church_id`) REFERENCES `churchs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_level` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_position` FOREIGN KEY (`position_id`) REFERENCES `user_positions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
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
