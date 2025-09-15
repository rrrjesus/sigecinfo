
-- --------------------------------------------------------

--
-- Estrutura para tabela `user_positions`
--

CREATE TABLE `user_positions` (
  `id` int(11) UNSIGNED NOT NULL,
  `position_name` text NOT NULL,
  `login_created` varchar(7) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `login_updated` varchar(7) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'actived'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user_positions`
--

INSERT INTO `user_positions` (`id`, `position_name`, `login_created`, `created_at`, `login_updated`, `updated_at`, `status`) VALUES
(1, 'INFORMATICA', '54', '2025-09-13 01:19:10', '54', '2025-09-13 01:21:16', 'actived');
