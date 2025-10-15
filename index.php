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
$auth = new Auth($view, $email);

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

//auth
$route->group(null);
$route->get("/entrar", function($data) use ($auth) { (new \Source\App\Web($auth))->login($data); });
$route->post("/entrar", function($data) use ($auth) { (new \Source\App\Web($auth))->login($data); });
$route->get("/recuperar", function($data) use ($auth) { (new \Source\App\Web($auth))->forget($data); });
$route->post("/recuperar", function($data) use ($auth) { (new \Source\App\Web($auth))->forget($data); });
$route->get("/recuperar/{code}", function($data) use ($auth) { (new \Source\App\Web($auth))->reset($data); });
$route->post("/recuperar/resetar", function($data) use ($auth) { (new \Source\App\Web($auth))->reset($data); });

/**
 * APP ROUTES
 */
$route->namespace("Source\App\Beta");
$route->group("/beta");

$route->get("/", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Dash($auth))->dash($data);});
$route->get("/home", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Dash($auth))->home($data);});
$route->post("/home", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Dash($auth))->home($data);});
$route->get("/perfil", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Profile($auth))->profile($data);});
$route->post("/perfil", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Profile($auth))->profile($data);});
$route->get("/logoff", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Dash($auth))->logoff($data);});

//events
$route->get("/eventos/meus-eventos", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Events($auth))->list($data);});
$route->get("/eventos/eventos", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Events($auth))->listEvents($data);});
$route->get("/eventos/eventos-finalizados", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Events($auth))->listEventsDisableds($data);});
$route->post("/eventos/confirmar", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Events($auth))->confirm($data);});
$route->post("/eventos/justificar", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Events($auth))->justify($data);});
$route->post("/eventos/alterar-resposta", function($data) use ($auth) {
    (new \Source\App\Beta\Controllers\Events($auth))->changeResponse($data);
});

/**
 * ADMIN ROUTES
 */
$route->namespace("Source\App\Admin\Controllers");
$route->group("/painel");

$route->get("/", function ($data) use ($auth) { (new \Source\App\Admin\Controllers\Login($auth))->root($data); });
$route->get("/login", function ($data) use ($auth) { (new \Source\App\Admin\Controllers\Login($auth))->login($data); });
$route->post("/login", function ($data) use ($auth) { (new \Source\App\Admin\Controllers\Login($auth))->login($data); });

//Dash
$route->get("/controle", "Dash:dash");
$route->get("/controle/inicial", "Dash:home");
$route->post("/controle/inicial", "Dash:home");
$route->get("/logoff", "Dash:logoff");
$route->get("/perfil", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->profile($data); });
$route->post("/perfil", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->profile($data); });

//Igrejas
$route->get("/igrejas", "Churchs:churchs");
$route->get("/igrejas/cadastrar", "Churchs:create");
$route->post("/igrejas/cadastrar", "Churchs:create");
$route->get("/igrejas/editar/{church_id}", "Churchs:edit");
$route->post("/igrejas/editar/{church_id}", "Churchs:edit");
$route->get("/igrejas/desativadas", "Churchs:disabledChurchs");
$route->get("/igrejas/status/{church_id}", "Churchs:toggleStatus");
$route->post("/igrejas/excluir", "Churchs:delete");

//Niveis
$route->get("/niveis", "Levels:levels");

//Cargos (Mantido como original, pois não refatoramos o controller)
$route->get("/cargos", "UsersPositions:userspositions");
$route->get("/cargos/cadastrar", "UsersPositions:create");
$route->post("/cargos/cadastrar", "UsersPositions:create");
$route->get("/cargos/editar/{userposition_id}", "UsersPositions:edit");
$route->post("/cargos/editar/{userposition_id}", "UsersPositions:edit");
$route->get("/cargos/desativados", "UsersPositions:disabledUsersPositions");
$route->get("/cargos/status/{userposition_id}", "UsersPositions:toggleStatus");
$route->post("/cargos/excluir", "UsersPositions:delete");

//Users

// No seu index.php

//Users (closures para injetar o $auth)
$route->get("/usuarios", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->users($data); });
$route->get("/usuarios/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->create($data); });
$route->post("/usuarios/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->create($data); });
$route->get("/usuarios/editar/{user_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->edit($data); });
$route->post("/usuarios/editar/{user_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->edit($data); });
$route->post("/usuarios/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->delete($data); });
$route->post("/usuarios/desativados/excluir", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->delete($data); });
$route->get("/usuarios/desativados", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->disabledUsers($data); });
$route->get("/usuarios/status/{user_id}", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Users($auth))->toggleStatus($data); });
$route->get("/usuarios/search", function($data) use ($auth) {
    (new \Source\App\Admin\Controllers\Users($auth))->searchJson($data);
});
// Dentro do grupo "/painel/usuarios"
$route->get("/search-typeahead", "Users:searchJsonForTypeahead");

//Tipos de Eventos
$route->get("/tipos-de-eventos", "EventTypes:list");
$route->get("/tipos-de-eventos/desativados", "EventTypes:disabledList");
$route->get("/tipos-de-eventos/cadastrar", "EventTypes:create");
$route->post("/tipos-de-eventos/cadastrar", "EventTypes:create");
$route->get("/tipos-de-eventos/editar/{type_id}", "EventTypes:edit");
$route->post("/tipos-de-eventos/editar/{type_id}", "EventTypes:edit");
$route->get("/tipos-de-eventos/status/{type_id}", "EventTypes:toggleStatus");
$route->post("/tipos-de-eventos/excluir", "EventTypes:delete");

// Eventos
$route->get("/eventos", "Events:list");
$route->get("/eventos/cadastrar", "Events:create");
$route->post("/eventos/cadastrar", "Events:create");
$route->get("/eventos/editar/{event_id}", "Events:edit");
$route->post("/eventos/editar/{event_id}", "Events:edit");
$route->post("/eventos/excluir", "Events:delete");
$route->get("/eventos/desativados", "Events:disabledEvents");
$route->get("/eventos/status/{event_id}", "Events:toggleStatus");
$route->get("/eventos/iniciar/{event_id}", "Events:start");
$route->get("/eventos/finalizar/{event_id}", "Events:finish");
$route->post("/eventos/remover-participante", "Events:removeParticipant");
$route->post("/eventos/checkin", "Events:checkIn");

//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");

/**
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errcode}", function ($data) use ($auth) {
    (new \Source\App\Web($auth))->error($data);
});

/**
 * ROUTE DISPATCH
 */
if (!$route->dispatch()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();