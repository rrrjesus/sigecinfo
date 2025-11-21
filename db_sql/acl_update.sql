-- =================================================================
-- SCRIPT DE ATUALIZAÇÃO DA ARQUITETURA DE ACL (ACCESS CONTROL LIST)
-- =================================================================

-- Desativa a verificação de chaves estrangeiras para evitar erros ao apagar as tabelas
SET FOREIGN_KEY_CHECKS=0;

-- Apaga as tabelas antigas na ordem inversa de dependência para evitar erros
DROP TABLE IF EXISTS `level_permissions`;
DROP TABLE IF EXISTS `user_modules`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `modules`;

-- =================================================================
-- CRIAÇÃO DAS TABELAS
-- =================================================================

-- Tabela para cadastrar os módulos do sistema
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela para as permissões específicas, vinculadas a um módulo
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Ex: users_create, users_edit',
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela pivot para associar usuários a módulos que eles podem acessar
CREATE TABLE `user_modules` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`module_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `user_modules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_modules_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela pivot para associar níveis (cargos) a permissões específicas
CREATE TABLE `level_permissions` (
  `level_id` int(11) UNSIGNED NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`level_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `level_permissions_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `level_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Reativa a verificação de chaves estrangeiras
SET FOREIGN_key_checks = 1;

-- =================================================================
-- INSERÇÃO DOS DADOS INICIAIS
-- =================================================================

-- Insere os módulos principais do sistema
INSERT INTO `modules` (`name`, `description`) VALUES
('users', 'Módulo de Usuários'),
('events', 'Módulo de Eventos'),
('places', 'Módulo de Locais'),
('reports', 'Módulo de Relatórios'),
('acl', 'Módulo de Controle de Acesso');

-- Insere as permissões para cada módulo
-- Permissões de Usuários
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'users_view', 'Visualizar Usuários' FROM `modules` WHERE `name` = 'users';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'users_create', 'Criar Usuários' FROM `modules` WHERE `name` = 'users';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'users_edit', 'Editar Usuários' FROM `modules` WHERE `name` = 'users';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'users_delete', 'Excluir Usuários' FROM `modules` WHERE `name` = 'users';

-- Permissões de Eventos
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'events_view', 'Visualizar Eventos' FROM `modules` WHERE `name` = 'events';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'events_create', 'Criar Eventos' FROM `modules` WHERE `name` = 'events';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'events_edit', 'Editar Eventos' FROM `modules` WHERE `name` = 'events';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'events_delete', 'Excluir Eventos' FROM `modules` WHERE `name` = 'events';

-- Permissões de Locais
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'places_view', 'Visualizar Locais' FROM `modules` WHERE `name` = 'places';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'places_create', 'Criar Locais' FROM `modules` WHERE `name` = 'places';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'places_edit', 'Editar Locais' FROM `modules` WHERE `name` = 'places';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'places_delete', 'Excluir Locais' FROM `modules` WHERE `name` = 'places';

-- Permissões de Relatórios
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'reports_view', 'Visualizar Relatórios' FROM `modules` WHERE `name` = 'reports';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'reports_create', 'Criar Relatórios' FROM `modules` WHERE `name` = 'reports';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'reports_edit', 'Editar Relatórios' FROM `modules` WHERE `name` = 'reports';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'reports_delete', 'Excluir Relatórios' FROM `modules` WHERE `name` = 'reports';

-- Permissões de Tipos de Evento (Adicionado)
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'eventtypes_view', 'Visualizar Tipos de Evento' FROM `modules` WHERE `name` = 'events';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'eventtypes_create', 'Criar Tipos de Evento' FROM `modules` WHERE `name` = 'events';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'eventtypes_edit', 'Editar Tipos de Evento' FROM `modules` WHERE `name` = 'events';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'eventtypes_delete', 'Excluir Tipos de Evento' FROM `modules` WHERE `name` = 'events';

-- Permissões do ACL
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'acl_view', 'Visualizar ACL' FROM `modules` WHERE `name` = 'acl';
INSERT INTO `permissions` (`module_id`, `name`, `description`) SELECT id, 'acl_edit', 'Editar ACL' FROM `modules` WHERE `name` = 'acl';

-- =================================================================
-- ATRIBUIÇÃO DE PERMISSÕES E MÓDULOS
-- =================================================================

-- Atribui TODAS as permissões ao Nível de Super Admin (assumindo level_id = 1)
-- CUIDADO: Altere o '1' se o ID do seu Super Admin for diferente.
-- Atribui TODAS as permissões ao Nível de Administrador do Sistema (level_id = 5)
-- CUIDADO: Altere o '5' se o ID do seu Super Admin for diferente.
INSERT INTO `level_permissions` (`level_id`, `permission_id`) SELECT 1, `id` FROM `permissions`;
INSERT INTO `level_permissions` (`level_id`, `permission_id`) SELECT 5, `id` FROM `permissions`;

-- Atribui acesso a TODOS os módulos para o Super Admin (assumindo user_id = 1)
-- CUIDADO: Altere o '1' se o ID do seu usuário Super Admin for diferente.
-- Atribui acesso a TODOS os módulos para o usuário Super Admin (ex: user_id = 1)
-- CUIDADO: Altere o '1' para o ID do seu usuário Super Admin principal.
INSERT INTO `user_modules` (`user_id`, `module_id`)
SELECT 1, `id` FROM `modules`;

-- Exemplo: Atribui algumas permissões ao Nível "Admin" (assumindo level_id = 2)
-- Exemplo: Atribui algumas permissões ao Nível "Editor Administrador" (level_id = 4)
-- INSERT INTO `level_permissions` (`level_id`, `permission_id`)
-- SELECT 2, p.id FROM `permissions` p JOIN `modules` m ON p.module_id = m.id
-- WHERE m.name IN ('events', 'places') OR p.name = 'users_view';

-- Exemplo: Atribui acesso aos módulos de Eventos e Locais para o usuário com ID 2
-- INSERT INTO `user_modules` (`user_id`, `module_id`)
-- SELECT 2, m.id FROM `modules` m WHERE m.name IN ('events', 'places');

-- =================================================================
-- FIM DO SCRIPT
-- =================================================================