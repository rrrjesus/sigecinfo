
-- --------------------------------------------------------

--
-- Estrutura para tabela `units`
--

CREATE TABLE `units` (
  `id` int(11) UNSIGNED NOT NULL,
  `unit_name` varchar(40) DEFAULT NULL,
  `description` varchar(75) DEFAULT NULL,
  `adress` varchar(74) DEFAULT NULL,
  `zip` varchar(9) DEFAULT NULL,
  `photo` varchar(34) DEFAULT NULL,
  `url` varchar(84) DEFAULT NULL,
  `it_professional` varchar(36) DEFAULT NULL,
  `fixed_phone` varchar(8) DEFAULT NULL,
  `cell_phone` varchar(9) DEFAULT NULL,
  `email` varchar(41) DEFAULT NULL,
  `status` varchar(8) DEFAULT 'actived',
  `login_created` varchar(7) NOT NULL DEFAULT 'sistema',
  `created_at` varchar(16) DEFAULT NULL,
  `login_updated` varchar(7) NOT NULL DEFAULT 'sistema',
  `updated_at` varchar(16) DEFAULT NULL,
  `observations` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `units`
--

INSERT INTO `units` (`id`, `unit_name`, `description`, `adress`, `zip`, `photo`, `url`, `it_professional`, `fixed_phone`, `cell_phone`, `email`, `status`, `login_created`, `created_at`, `login_updated`, `updated_at`, `observations`) VALUES
(1, 'JAÇANÃ', 'CENTRAL SETOR 11', 'R. José Buono, 65 - Jaçanã, São Paulo - SP', '02273-120', 'logo_ass_smsub.png', 'https://congregacaocristanobrasil.org.br/', 'José Luis Sanchez', '(11)2241', '', 'informatica.setor11@gmail.com', 'actived', 'sistema', '2025-09-12 22:42', '54', '', 'teste');
