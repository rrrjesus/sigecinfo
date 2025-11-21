-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/11/2025 às 20:30
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
-- Estrutura para tabela `events`
--

CREATE TABLE `events` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `place_id` int(11) UNSIGNED DEFAULT NULL,
  `type_id` int(11) UNSIGNED DEFAULT NULL,
  `location_text` varchar(255) DEFAULT NULL,
  `meeting_url` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'agendado' COMMENT 'Valores possíveis: agendado, ao vivo, realizado, cancelado',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `google_calendar_event_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `event_participants`
--

CREATE TABLE `event_participants` (
  `id` int(11) UNSIGNED NOT NULL,
  `event_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'convocado' COMMENT 'convocado, confirmado, recusado, presente',
  `signature` varchar(255) DEFAULT NULL,
  `justification` text DEFAULT NULL,
  `checkin_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `event_types`
--

CREATE TABLE `event_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'actived',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `google_auth_tokens`
--

CREATE TABLE `google_auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `access_token` text NOT NULL,
  `refresh_token` text DEFAULT NULL,
  `expires_in` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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

-- --------------------------------------------------------

--
-- Estrutura para tabela `level_permissions`
--

CREATE TABLE `level_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `level_id` int(11) UNSIGNED NOT NULL,
  `permission_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `places`
--

CREATE TABLE `places` (
  `id` int(11) UNSIGNED NOT NULL,
  `country_id` varchar(2) DEFAULT NULL,
  `code_id` varchar(20) DEFAULT NULL,
  `place_name` varchar(150) NOT NULL,
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

-- --------------------------------------------------------

--
-- Estrutura para tabela `report_pages`
--

CREATE TABLE `report_pages` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `accesses` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `password` varchar(255) NOT NULL DEFAULT '$2y$10$nRtJo2JSTuiSNVHENwObzuqHmR4ZTd6ojDzHM.Ex874o8WfcI225i',
  `forget` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'registered' COMMENT 'registered, confirmed, trash',
  `level_id` int(11) UNSIGNED DEFAULT NULL,
  `position_id` int(11) UNSIGNED DEFAULT NULL,
  `place_id` int(11) UNSIGNED DEFAULT NULL,
  `observations` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `login_created` int(11) UNSIGNED DEFAULT NULL,
  `login_updated` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `module` varchar(255) NOT NULL,
  `actions` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_place_id` (`place_id`),
  ADD KEY `fk_events_type_id` (`type_id`),
  ADD KEY `fk_events_created_by` (`created_by`),
  ADD KEY `fk_events_updated_by` (`updated_by`);

--
-- Índices de tabela `event_participants`
--
ALTER TABLE `event_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_participants_event` (`event_id`),
  ADD KEY `fk_event_participants_user` (`user_id`),
  ADD KEY `fk_event_participants_created_by` (`login_created`),
  ADD KEY `fk_event_participants_updated_by` (`login_updated`);

--
-- Índices de tabela `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_types_created_by` (`created_by`),
  ADD KEY `fk_event_types_updated_by` (`updated_by`);

--
-- Índices de tabela `google_auth_tokens`
--
ALTER TABLE `google_auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_id` (`user_id`);

--
-- Índices de tabela `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_levels_created_by` (`login_created`),
  ADD KEY `fk_levels_updated_by` (`login_updated`);

--
-- Índices de tabela `level_permissions`
--
ALTER TABLE `level_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_level_permission` (`level_id`,`permission_id`),
  ADD KEY `level_id` (`level_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Índices de tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices de tabela `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_places_created_by` (`login_created`),
  ADD KEY `fk_places_updated_by` (`login_updated`);

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
-- Índices de tabela `report_pages`
--
ALTER TABLE `report_pages`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_level` (`level_id`),
  ADD KEY `fk_users_position` (`position_id`),
  ADD KEY `fk_users_place` (`place_id`),
  ADD KEY `fk_users_created_by` (`login_created`),
  ADD KEY `fk_users_updated_by` (`login_updated`);

--
-- Índices de tabela `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_module_unique` (`user_id`,`module`);

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
-- AUTO_INCREMENT de tabela `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `event_participants`
--
ALTER TABLE `event_participants`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `google_auth_tokens`
--
ALTER TABLE `google_auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `level_permissions`
--
ALTER TABLE `level_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `report_access`
--
ALTER TABLE `report_access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `report_online`
--
ALTER TABLE `report_online`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `report_pages`
--
ALTER TABLE `report_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user_positions`
--
ALTER TABLE `user_positions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_events_place_id` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_events_type_id` FOREIGN KEY (`type_id`) REFERENCES `event_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_events_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `event_participants`
--
ALTER TABLE `event_participants`
  ADD CONSTRAINT `fk_event_participants_created_by` FOREIGN KEY (`login_created`) REFERENCES `event_participants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_participants_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_participants_login_created` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_participants_login_updated` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_participants_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `event_participants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_participants_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `event_types`
--
ALTER TABLE `event_types`
  ADD CONSTRAINT `fk_event_types_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_event_types_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `google_auth_tokens`
--
ALTER TABLE `google_auth_tokens`
  ADD CONSTRAINT `fk_google_auth_tokens_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `levels`
--
ALTER TABLE `levels`
  ADD CONSTRAINT `fk_levels_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_levels_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `level_permissions`
--
ALTER TABLE `level_permissions`
  ADD CONSTRAINT `level_permissions_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `level_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `fk_places_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_places_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Restrições para tabelas `report_online`
--
ALTER TABLE `report_online`
  ADD CONSTRAINT `fk_report_online_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_level` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_place` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_position` FOREIGN KEY (`position_id`) REFERENCES `user_positions` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `fk_user_permissions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `user_positions`
--
ALTER TABLE `user_positions`
  ADD CONSTRAINT `fk_positions_created_by` FOREIGN KEY (`login_created`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_positions_updated_by` FOREIGN KEY (`login_updated`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
