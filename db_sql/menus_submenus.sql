--
-- Estrutura da tabela `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `menu_order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `menus`
--

INSERT INTO `menus` (`id`, `name`, `icon`, `url`, `slug`, `menu_order`, `status`) VALUES
(1, 'Monitoramento', 'bi-speedometer', '/painel/controle', 'dashboard', 10, 1),
(2, 'Ver Site', 'bi-link-45deg', '/', 'view_site', 20, 1),
(3, 'Ver Aplicativo', 'bi-link-45deg', '/app', 'view_app', 30, 1),
(4, 'Eventos', 'bi bi-calendar-event', '#', 'events', 110, 1),
(5, 'Usuários', 'bi bi-person', '#', 'users', 120, 1),
(6, 'Controle de Acesso', 'bi bi-shield-lock', '#', 'acl', 130, 1),
(7, 'Menus e Navegação', 'bi bi-columns-gap', '#', 'layouts', 210, 1),
(8, 'Sair', 'bi bi-box-arrow-right', '/painel/logoff', 'logout', 310, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `submenus`
--

CREATE TABLE `submenus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `permission_slug` varchar(255) DEFAULT NULL,
  `submenu_order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `submenus_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `submenus_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `submenus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `submenus`
--

INSERT INTO `submenus` (`id`, `menu_id`, `parent_id`, `name`, `icon`, `url`, `permission_slug`, `submenu_order`, `status`) VALUES
-- Menu: Eventos (ID: 4)
(1, 4, NULL, 'Eventos', 'bi bi-calendar-check', '#', 'events_view', 10, 1),
(2, 4, 1, 'Cadastrar', 'bi bi-plus-circle', '/painel/eventos/cadastrar', 'events_create', 1, 1),
(3, 4, 1, 'Listar Todos', 'bi bi-list', '/painel/eventos', 'events_view', 2, 1),
(4, 4, NULL, 'Tipo de Eventos', 'bi bi-tags', '#', 'event_types_view', 20, 1),
(5, 4, 4, 'Cadastrar', 'bi bi-plus-circle', '/painel/tipos-de-eventos/cadastrar', 'event_types_create', 1, 1),
(6, 4, 4, 'Listar', 'bi bi-list', '/painel/tipos-de-eventos', 'event_types_view', 2, 1),
(7, 4, NULL, 'Locais', 'bi bi-geo-alt', '#', 'places_view', 30, 1),
(8, 4, 7, 'Cadastrar', 'bi bi-plus-circle', '/painel/locais/cadastrar', 'places_create', 1, 1),
(9, 4, 7, 'Listar', 'bi bi-list', '/painel/locais', 'places_view', 2, 1),

-- Menu: Usuários (ID: 5)
(10, 5, NULL, 'Usuários', 'bi bi-person', '#', 'users_view', 10, 1),
(11, 5, 10, 'Cadastrar', 'bi bi-plus-circle', '/painel/usuarios/cadastrar', 'users_create', 1, 1),
(12, 5, 10, 'Listar', 'bi bi-list', '/painel/usuarios', 'users_view', 2, 1),
(13, 5, NULL, 'Níveis', 'bi bi-diagram-3', '/painel/niveis', 'levels_view', 20, 1),
(14, 5, NULL, 'Cargos', 'bi bi-briefcase', '#', 'positions_view', 30, 1),
(15, 5, 14, 'Listar', 'bi bi-list', '/painel/cargos', 'positions_view', 1, 1),
(16, 5, 14, 'Cadastrar', 'bi bi-plus-circle', '/painel/cargos/cadastrar', 'positions_create', 2, 1),

-- Menu: Controle de Acesso (ID: 6)
(17, 6, NULL, 'Matriz de Permissões', 'bi bi-shield-check', '/painel/acl', 'acl_view', 10, 1),
(18, 6, NULL, 'Permissões', 'bi bi-key', '#', 'permissions_view', 20, 1),
(19, 6, 18, 'Gerir ACL', 'bi bi-list', '/painel/permissoes', 'permissions_view', 1, 1),

-- Menu: Menus e Navegação (ID: 7)
(20, 7, NULL, 'Menus Principais', 'bi bi-list', '#', 'menus_view', 10, 1),
(21, 7, 20, 'Listar', 'bi bi-list', '/painel/menus', 'menus_view', 1, 1),
(22, 7, 20, 'Cadastrar', 'bi bi-plus-circle', '/painel/menus/cadastrar', 'menus_create', 2, 1),
(23, 7, NULL, 'Submenus', 'bi bi-list-nested', '#', 'submenus_view', 20, 1),
(24, 7, 23, 'Listar', 'bi bi-list', '/painel/submenus', 'submenus_view', 1, 1),
(25, 7, 23, 'Cadastrar', 'bi bi-plus-circle', '/painel/submenus/cadastrar', 'submenus_create', 2, 1);

ALTER TABLE `submenus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
  
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;