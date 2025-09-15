
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
(102, NULL, '192.168.15.54', '/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:00:29', '2025-09-13 03:00:29'),
(103, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:00:43', '2025-09-13 03:00:43'),
(104, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:01:39', '2025-09-13 03:01:39'),
(105, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:01:54', '2025-09-13 03:01:54'),
(106, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:03:28', '2025-09-13 03:03:28'),
(107, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:03:32', '2025-09-13 03:03:32'),
(108, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:03:41', '2025-09-13 03:03:41'),
(109, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:03:46', '2025-09-13 03:03:46'),
(110, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:04:05', '2025-09-13 03:04:05'),
(111, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:05:04', '2025-09-13 03:05:04'),
(112, NULL, '192.168.15.54', '/sobre', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:05:08', '2025-09-13 03:05:08'),
(113, NULL, '192.168.15.54', '/email', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:05:12', '2025-09-13 03:05:12'),
(114, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:06:58', '2025-09-13 03:06:58'),
(115, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:07:04', '2025-09-13 03:07:04'),
(116, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:08:13', '2025-09-13 03:08:13'),
(117, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:08:20', '2025-09-13 03:08:20'),
(118, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:08:45', '2025-09-13 03:08:45'),
(119, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:08:50', '2025-09-13 03:08:50'),
(120, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:09:14', '2025-09-13 03:09:14'),
(121, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:12:38', '2025-09-13 03:12:38'),
(122, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:12:40', '2025-09-13 03:12:40'),
(123, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:12:47', '2025-09-13 03:12:47'),
(124, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:12:52', '2025-09-13 03:12:52'),
(125, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:12:58', '2025-09-13 03:12:58'),
(126, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:13:10', '2025-09-13 03:13:10'),
(127, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:18:20', '2025-09-13 03:18:20'),
(128, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:18:25', '2025-09-13 03:18:25'),
(129, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:18:27', '2025-09-13 03:18:27'),
(130, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:18:29', '2025-09-13 03:18:29'),
(131, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:18:30', '2025-09-13 03:18:30'),
(132, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:18:31', '2025-09-13 03:18:31'),
(133, NULL, '192.168.15.54', '/entrar', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:18:35', '2025-09-13 03:18:35'),
(134, NULL, '192.168.15.54', '/email', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:19:56', '2025-09-13 03:19:56'),
(135, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:19:56', '2025-09-13 03:19:56'),
(136, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:19:56', '2025-09-13 03:19:56'),
(137, NULL, '192.168.15.54', '/ops/404', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:20:03', '2025-09-13 03:20:03'),
(138, NULL, '192.168.15.54', '/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 1, '2025-09-13 03:20:13', '2025-09-13 03:20:13');
