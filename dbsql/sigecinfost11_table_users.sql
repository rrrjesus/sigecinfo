
-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `login` varchar(7) NOT NULL,
  `rf` int(7) NOT NULL,
  `user_name` text NOT NULL,
  `position_id` int(11) UNSIGNED DEFAULT NULL,
  `category_id` int(11) UNSIGNED DEFAULT 5,
  `unit_id` int(11) UNSIGNED DEFAULT 34,
  `status` varchar(50) DEFAULT 'registered' COMMENT 'registered, confirmed, trash',
  `cell_phone` varchar(11) DEFAULT NULL,
  `fixed_phone` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `level_id` int(11) UNSIGNED DEFAULT 1,
  `password` varchar(255) NOT NULL DEFAULT '$2y$10$7aQNdKPaeaX0wwxShqfDN.Jwc4SzPPQGOk7fZdLgV/WmGvVx6oFwm',
  `forget` varchar(255) DEFAULT NULL,
  `login_created` varchar(7) NOT NULL DEFAULT 'd788796',
  `created_at` timestamp NOT NULL DEFAULT '2024-09-12 16:10:00',
  `login_updated` varchar(7) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login_blocked` varchar(7) DEFAULT NULL,
  `blocked_at` timestamp NULL DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `login`, `rf`, `user_name`, `position_id`, `category_id`, `unit_id`, `status`, `cell_phone`, `fixed_phone`, `email`, `level_id`, `password`, `forget`, `login_created`, `created_at`, `login_updated`, `updated_at`, `login_blocked`, `blocked_at`, `observations`, `photo`) VALUES
(1, '54', 2147483647, 'Rodolfo Romaioli Ribeiro de Jesus', 1, 1, 1, 'confirmed', '11991091365', '', 'rrrjesus@smsub.prefeitura.sp.gov.br', 5, '$2y$10$9p8CR1JBdKTVVp.kxQeRXexNGAsoQqAqY9pv4PbMubeWzzgUpDcCi', '135ea39c0aedb7157c77ed56c2e3b5e9', 'd788796', '0000-00-00 00:00:00', '54', '2025-09-13 03:03:26', NULL, NULL, 'INFORMATICA', 'images/2025/09/rodolfo-romaioli-ribeiro-de-jesus-1722268826.jpg');
