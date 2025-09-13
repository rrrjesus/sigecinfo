
-- --------------------------------------------------------

--
-- Estrutura para tabela `levels`
--

CREATE TABLE `levels` (
  `id` int(11) UNSIGNED NOT NULL,
  `level_nome` text NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `levels`
--

INSERT INTO `levels` (`id`, `level_nome`, `descricao`) VALUES
(1, 'Usuario', 'Acesso ao sistema apenas para visualização'),
(2, 'Usuario Editor', 'Acesso ao sistema com visualização e edição de alguns itens '),
(3, 'Editor', 'Acesso ao sistema com edição de itens'),
(4, 'Editor Administrador', 'Acesso ao sistema e painel de configuração com edição de algumas configurações'),
(5, 'Administrador do Sistema', 'Acesso total ao sistema e configurações');
