
-- --------------------------------------------------------

--
-- Estrutura para tabela `user_categories`
--

CREATE TABLE `user_categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_name` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'actived',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login_created` varchar(7) NOT NULL DEFAULT 'sistema',
  `login_updated` varchar(7) NOT NULL DEFAULT 'sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user_categories`
--

INSERT INTO `user_categories` (`id`, `category_name`, `status`, `created_at`, `updated_at`, `login_created`, `login_updated`) VALUES
(1, 'VOLUNTARIO', 'actived', '2025-09-13 01:17:46', '2025-09-13 01:30:54', 'sistema', 'sistema');
