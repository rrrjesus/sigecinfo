<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;
use Source\Core\View;
use Source\Support\Email;
use Source\Domain\Shared\Models\Auth;

$session = new Session();
$route = new Router(url(), ":");

/**
 * SERVICE CONTAINER / DEPENDENCY INJECTION SETUP
 */
$view = new View();
$email = new Email();
$auth = new Auth();

/**
 * WEB ROUTES
 */
$route->namespace("Source\App");
$route->group(null);

// Rotas que não precisam de autenticação
$route->get("/", function($data) use ($auth) { (new \Source\App\Web($auth))->home($data); });
$route->get("/sobre", function($data) use ($auth) { (new \Source\App\Web($auth))->about($data); });
$route->get("/reunioes", function($data) use ($auth) { (new \Source\App\Web($auth))->meetings($data); });

//optin
$route->group(null);
$route->get("/confirma", function($data) use ($auth) { (new \Source\App\Web($auth))->confirm($data); });
$route->get("/obrigado/{email}", function($data) use ($auth) { (new \Source\App\Web($auth))->success($data); });

//services
$route->group(null);
$route->get("/termos", function($data) use ($auth) { (new \Source\App\Web($auth))->terms($data); });
$route->get("/privacidade", function($data) use ($auth) { (new \Source\App\Web($auth))->privacy($data); });

//auth
$route->group(null);
$route->get("/auth/google", function($data) use ($auth) { (new \Source\App\Web($auth))->google($data); });
$route->get("/auth/google/callback", function($data) use ($auth) { (new \Source\App\Web($auth))->googleCallback($data); });
$route->get("/entrar", function($data) use ($auth) { (new \Source\App\Web($auth))->login($data); });
$route->post("/entrar", function($data) use ($auth) { (new \Source\App\Web($auth))->login($data); });
$route->get("/recuperar", function($data) use ($auth) { (new \Source\App\Web($auth))->forget($data); });
$route->post("/recuperar", function($data) use ($auth) { (new \Source\App\Web($auth))->forget($data); });
$route->get("/recuperar/{code}", function($data) use ($auth) { (new \Source\App\Web($auth))->reset($data); });
$route->post("/recuperar/resetar", function($data) use ($auth) { (new \Source\App\Web($auth))->reset($data); });

/**
 * APP ROUTES
 */
$route->namespace("Source\App\App");
$route->group("/app");

$route->get("/", function($data) use ($auth) {(new \Source\App\App\Controllers\Dash($auth))->home($data);});
$route->get("/home", function($data) use ($auth) {(new \Source\App\App\Controllers\Dash($auth))->home($data);});
$route->post("/home", function($data) use ($auth) {(new \Source\App\App\Controllers\Dash($auth))->home($data);});
$route->get("/perfil", function($data) use ($auth) {(new \Source\App\App\Controllers\Profile($auth))->profile($data);});
$route->post("/perfil", function($data) use ($auth) {(new \Source\App\App\Controllers\Profile($auth))->profile($data);});
$route->get("/logoff", function($data) use ($auth) {(new \Source\App\App\Controllers\Dash($auth))->logoff($data);});

//eventos
$route->get("/eventos", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->list($data);});
$route->get("/eventos/cadastrar", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->create($data);});
$route->post("/eventos/cadastrar", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->create($data);});
$route->post("/eventos/{event_id}/cadastrar", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->registerParticipant($data);});
$route->get("/eventos/editar/{event_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->edit($data);});
$route->post("/eventos/editar/{event_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->edit($data);});
$route->get("/eventos/portaria/{event_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->report($data);});
$route->post("/eventos/portaria/{event_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->report($data);});
$route->post("/eventos/excluir", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->delete($data);});
$route->get("/eventos/desativados", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->disabledEvents($data);});
$route->get("/eventos/status/{event_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->toggleStatus($data);});
$route->get("/eventos/iniciar/{event_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->start($data);});
$route->get("/eventos/finalizar/{event_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->finish($data);});
$route->post("/eventos/remover-participante", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->removeParticipant($data);});
$route->post("/eventos/check-in", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->checkIn($data);});
$route->get("/eventos/check-in/{participant_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->getParticipantDetails($data);});
$route->get("/eventos/checkin/{participant_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->showCheckInPage($data);});
$route->post("/eventos/checkin-page", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->processCheckInFromPage($data);});
$route->get("/eventos/meus-eventos-agendados", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->listMyEvents($data);});
$route->get("/eventos/eventos", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->listEvents($data);});
$route->get("/eventos/meus-eventos-finalizados", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->listEventsDisableds($data);});
$route->get("/eventos/eventos-finalizados", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->completedEvents($data);});
$route->post("/eventos/confirmar", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->confirm($data);});
$route->post("/eventos/justificar", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->justify($data);});
$route->post("/eventos/marcar-falta", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->markAsAbsent($data);});
$route->get("/eventos/checkin-qr-scan/{participant_id}/{event_id}/{secure_token}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->checkinQrScan($data);});
$route->get("/eventos/qrcode-checkin/{participant_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->qrCodeCheckIn($data);});
$route->post("/eventos/alterar-resposta", function($data) use ($auth) { (new \Source\App\App\Controllers\Events($auth))->changeResponse($data); });

//Contatos
$route->get("/contatos", "Contacts:contacts");
$route->get("/contatos/desativados", "Contacts:disabledContacts");
$route->get("/contatos/cadastrar", "Contacts:contact");
$route->post("/contatos/cadastrar", "Contacts:contact");
$route->get("/contatos/editar/{contact_id}", "Contacts:contact");
$route->post("/contatos/editar/{contact_id}", "Contacts:contact");
$route->get("/contatos/ativar/{contact_id}/{action}", "Contacts:contact");
$route->get("/contatos/desativar/{contact_id}/{action}", "Contacts:contact");
$route->get("/contatos/excluir/{contact_id}/{action}", "Contacts:contact");

//Patrimonios
$route->get("/patrimonios", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->list($data);});
$route->get("/patrimonios/desativados", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->disabled($data);});
$route->get("/patrimonio/cadastrar", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->create($data);});
$route->post("/patrimonio/cadastrar", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->create($data);});
$route->get("/patrimonios/detalhar/{patrimony_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->view($data);});
$route->get("/patrimonio/detalhe/{patrimony_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->edit($data);});
$route->post("/patrimonio/detalhe/{patrimony_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->edit($data);});
$route->get("/patrimonios/status/{patrimony_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->toggleStatus($data);});
$route->get("/patrimonio/termo/{patrimony_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->term($data);});
$route->post("/patrimonios/excluir", function($data) use ($auth) {(new \Source\App\App\Controllers\Patrimonys($auth))->delete($data);});

//Historico Patrimonios
$route->get("/patrimonios/historico", function($data) use ($auth) {(new \Source\App\App\Controllers\PatrimonysHistory($auth))->list($data);});
$route->post("/patrimonios/historico/excluir", function($data) use ($auth) {(new \Source\App\App\Controllers\PatrimonysHistory($auth))->delete($data);});
$route->get("/patrimonio/historico/editar/{patrimony_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\PatrimonysHistory($auth))->edit($data);});
$route->post("/patrimonio/historico/editar/{patrimony_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\PatrimonysHistory($auth))->edit($data);});
$route->get("/patrimonio/historico/termo/{patrimony_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\PatrimonysHistory($auth))->term($data);});

/**
 * ADMIN ROUTES
 */
$route->namespace("Source\App\Admin\Controllers");
$route->group("/painel");

$route->get("/", function ($data) use ($auth) { (new \Source\App\Admin\Controllers\Login($auth))->root($data); });
$route->get("/login", function ($data) use ($auth) { (new \Source\App\Admin\Controllers\Login($auth))->login($data); });
$route->post("/login", function ($data) use ($auth) { (new \Source\App\Admin\Controllers\Login($auth))->login($data); });

//Dash
$route->get("/controle", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Dash($auth))->dash($data); });
$route->get("/controle/inicial", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Dash($auth))->home($data); });
$route->post("/controle/inicial", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Dash($auth))->home($data); });
$route->get("/logoff", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Dash($auth))->logoff($data); });
$route->get("/perfil", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->profile($data); });
$route->post("/perfil", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->profile($data); });

// Eventos
$route->get("/eventos", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->list($data);});
$route->get("/eventos/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->create($data);});
$route->post("/eventos/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->create($data);});
$route->get("/eventos/editar/{event_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->edit($data);});
$route->post("/eventos/editar/{event_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->edit($data);});
$route->get("/eventos/portaria/{event_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->report($data);});
$route->post("/eventos/portaria/{event_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->report($data);});
$route->post("/eventos/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->delete($data);});
$route->get("/eventos/desativados", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->disabledEvents($data);});
$route->get("/eventos/status/{event_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->toggleStatus($data);});
$route->get("/eventos/iniciar/{event_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->start($data);});
$route->get("/eventos/finalizar/{event_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->finish($data);});
$route->post("/eventos/remover-participante", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->removeParticipant($data);});
$route->post("/eventos/check-in", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->checkIn($data);});
$route->get("/eventos/check-in/{participant_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->getParticipantDetails($data);});
$route->get("/eventos/checkin/{participant_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->showCheckInPage($data);});
$route->post("/eventos/checkin-page", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->processCheckInFromPage($data);});
// $route->post("/eventos/checkin", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Events($auth))->processCheckIn($data);});
$route->post("/eventos/alterar-resposta", function($data) use ($auth) {
    (new \Source\App\Admin\Controllers\Events($auth))->changeResponse($data);
});

//Tipos de Eventos
$route->get("/tipos-de-eventos", function($data) use ($auth) { (new \Source\App\Admin\Controllers\EventTypes($auth))->list($data);});
$route->get("/tipos-de-eventos/desativados", function($data) use ($auth) { (new \Source\App\Admin\Controllers\EventTypes($auth))->disabledList($data);});
$route->get("/tipos-de-eventos/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\EventTypes($auth))->create($data);});
$route->post("/tipos-de-eventos/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\EventTypes($auth))->create($data);});
$route->get("/tipos-de-eventos/editar/{type_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\EventTypes($auth))->edit($data);});
$route->post("/tipos-de-eventos/editar/{type_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\EventTypes($auth))->edit($data);});
$route->get("/tipos-de-eventos/status/{type_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\EventTypes($auth))->toggleStatus($data);});
$route->post("/tipos-de-eventos/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\EventTypes($auth))->delete($data);});

//Locais
$route->get("/locais", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Places($auth))->places($data); });
$route->get("/locais/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Places($auth))->create($data); });
$route->post("/locais/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Places($auth))->create($data); });
$route->get("/locais/editar/{place_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Places($auth))->edit($data); });
$route->post("/locais/editar/{place_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Places($auth))->edit($data); });
$route->get("/locais/desativados", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Places($auth))->disabledPlaces($data); });
$route->get("/locais/status/{place_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Places($auth))->toggleStatus($data); });
$route->post("/locais/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Places($auth))->delete($data); });

//Niveis
$route->get("/niveis", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Levels($auth))->levels($data); });

//Cargos
$route->get("/cargos", function($data) use ($auth) { (new \Source\App\Admin\Controllers\UsersPositions($auth))->userspositions($data); });
$route->get("/cargos/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\UsersPositions($auth))->create($data); });
$route->post("/cargos/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\UsersPositions($auth))->create($data); });
$route->get("/cargos/editar/{userposition_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\UsersPositions($auth))->edit($data); });
$route->post("/cargos/editar/{userposition_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\UsersPositions($auth))->edit($data); });
$route->get("/cargos/desativados", function($data) use ($auth) { (new \Source\App\Admin\Controllers\UsersPositions($auth))->disabledUsersPositions($data); });
$route->get("/cargos/status/{userposition_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\UsersPositions($auth))->toggleStatus($data); });
$route->post("/cargos/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\UsersPositions($auth))->delete($data); });

//Permissões
$route->get("/permissoes", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Permissions($auth))->list($data); });
$route->get("/permissoes/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Permissions($auth))->create($data); });
$route->post("/permissoes/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Permissions($auth))->create($data); });

//ACL
$route->get("/acl", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Acl($auth))->index($data); });
$route->post("/acl/salvar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Acl($auth))->save($data); });

// Menus
$route->get("/menus", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Menus($auth))->list($data); });
$route->get("/menus/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Menus($auth))->create($data); });
$route->post("/menus/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Menus($auth))->create($data); });
$route->get("/menus/editar/{menu_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Menus($auth))->edit($data); });
$route->post("/menus/editar/{menu_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Menus($auth))->edit($data); });
$route->post("/menus/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Menus($auth))->delete($data); });

// Submenus
$route->get("/submenus", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Submenus($auth))->list($data); });
$route->get("/submenus/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Submenus($auth))->create($data); });
$route->post("/submenus/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Submenus($auth))->create($data); });
$route->get("/submenus/editar/{submenu_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Submenus($auth))->edit($data); });
$route->post("/submenus/editar/{submenu_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Submenus($auth))->edit($data); });
$route->post("/submenus/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Submenus($auth))->delete($data); });

//Users
$route->get("/usuarios", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->users($data); });
$route->get("/usuarios/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->create($data); });
$route->post("/usuarios/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->create($data); });
$route->get("/usuarios/editar/{user_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->edit($data); });
$route->post("/usuarios/editar/{user_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->edit($data); });
$route->post("/usuarios/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->delete($data); });
$route->post("/usuarios/desativados/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->delete($data); });
$route->get("/usuarios/desativados", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->disabledUsers($data); });
$route->get("/usuarios/status/{user_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->toggleStatus($data); });
$route->get("/usuarios/search", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->searchJson($data); });

// Dentro do grupo "/painel/usuarios"
$route->get("/search-typeahead", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->searchJsonForTypeahead($data); });


//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");

/**
 * LOGOUT
 */
$route->group("/ops");
$route->get("/{errcode}", function ($data) use ($auth) { (new \Source\App\Web($auth))->error($data); });

/**
 * ROUTE DISPATCH
 */
if (!$route->dispatch()) { $route->redirect("/ops/{$route->error()}"); }

ob_end_flush();