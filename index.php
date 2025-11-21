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
$route->get("/eventos/checkin-qr-scan/{participant_id}/{event_id}/{secure_token}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->checkinQrScan($data);});
$route->get("/eventos/qrcode-checkin/{participant_id}", function($data) use ($auth) {(new \Source\App\App\Controllers\Events($auth))->qrCodeCheckIn($data);});
$route->post("/eventos/alterar-resposta", function($data) use ($auth) {
    (new \Source\App\App\Controllers\Events($auth))->changeResponse($data);});


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

// Eventos
$route->get("/eventos", "Events:list");
$route->get("/eventos/cadastrar", "Events:create");
$route->post("/eventos/cadastrar", "Events:create");
$route->get("/eventos/editar/{event_id}", "Events:edit");
$route->post("/eventos/editar/{event_id}", "Events:edit");
$route->get("/eventos/portaria/{event_id}", "Events:report");
$route->post("/eventos/portaria/{event_id}", "Events:report");
$route->post("/eventos/excluir", "Events:delete");
$route->get("/eventos/desativados", "Events:disabledEvents");
$route->get("/eventos/status/{event_id}", "Events:toggleStatus");
$route->get("/eventos/iniciar/{event_id}", "Events:start");
$route->get("/eventos/finalizar/{event_id}", "Events:finish");
$route->post("/eventos/remover-participante", "Events:removeParticipant");
$route->post("/eventos/check-in", "Events:checkIn");
$route->get("/eventos/check-in/{participant_id}", "Events:getParticipantDetails");
$route->get("/eventos/checkin/{participant_id}", "Events:showCheckInPage");
$route->post("/eventos/checkin-page", "Events:processCheckInFromPage");
// $route->post("/eventos/checkin", "Events:processCheckIn");
$route->post("/eventos/alterar-resposta", function($data) use ($auth) {
    (new \Source\App\Admin\Controllers\Events($auth))->changeResponse($data);
});

//Tipos de Eventos
$route->get("/tipos-de-eventos", "EventTypes:list");
$route->get("/tipos-de-eventos/desativados", "EventTypes:disabledList");
$route->get("/tipos-de-eventos/cadastrar", "EventTypes:create");
$route->post("/tipos-de-eventos/cadastrar", "EventTypes:create");
$route->get("/tipos-de-eventos/editar/{type_id}", "EventTypes:edit");
$route->post("/tipos-de-eventos/editar/{type_id}", "EventTypes:edit");
$route->get("/tipos-de-eventos/status/{type_id}", "EventTypes:toggleStatus");
$route->post("/tipos-de-eventos/excluir", "EventTypes:delete");

//Locais
$route->get("/locais", "Places:places");
$route->get("/locais/cadastrar", "Places:create");
$route->post("/locais/cadastrar", "Places:create");
$route->get("/locais/editar/{place_id}", "Places:edit");
$route->post("/locais/editar/{place_id}", "Places:edit");
$route->get("/locais/desativados", "Places:disabledPlaces");
$route->get("/locais/status/{place_id}", "Places:toggleStatus");
$route->post("/locais/excluir", "Places:delete");

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

//Permissões
$route->get("/permissoes", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Permissions($auth))->list($data); });
$route->get("/permissoes/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Permissions($auth))->create($data); });
$route->post("/permissoes/cadastrar", function($data) use ($auth) { (new \Source\App\Admin\Controllers\Permissions($auth))->create($data); });

//ACL
$route->get("/acl", "Acl:index");
$route->post("/acl/salvar", "Acl:save");

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


//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");



    /**
     * LOGOUT
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