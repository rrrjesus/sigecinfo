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
// $route->get("/email", function($data) use ($auth) { (new \Source\App\Web($auth))->creatorCard($data); });
$route->get("/reunioes", function($data) use ($auth) { (new \Source\App\Web($auth))->meetings($data); });
// $route->get("/contatos", function($data) use ($auth) { (new \Source\App\Web($auth))->contact($data); });

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
$route->get("/cadastrar", function($data) use ($auth) { (new \Source\App\Web($auth))->register($data); });
$route->post("/cadastrar", function($data) use ($auth) { (new \Source\App\Web($auth))->register($data); });
$route->get("/recuperar", function($data) use ($auth) { (new \Source\App\Web($auth))->forget($data); });
$route->post("/recuperar", function($data) use ($auth) { (new \Source\App\Web($auth))->forget($data); });
$route->get("/recuperar/{code}", function($data) use ($auth) { (new \Source\App\Web($auth))->reset($data); });
$route->post("/recuperar/resetar", function($data) use ($auth) { (new \Source\App\Web($auth))->reset($data); });

/**
 * VIEWS ROUTES
 */
// $route->namespace("Source\App");
// $route->group("/iframes");
// $route->get("/contatos", "Iframe:contact");
// $route->get("/email", "Iframe:creatorCard");

/**
 * APP ROUTES
 */
$route->namespace("Source\App\Beta");
$route->group("/beta");

$route->get("/login", function($data) use ($auth) {(new \Source\App\Beta\Login($auth))->login($data);});
$route->post("/login", function($data) use ($auth) {(new \Source\App\Beta\Login($auth))->login($data);});
$route->get("/", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Dash($auth))->dash($data);});
$route->get("/home", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Dash($auth))->home($data);});
$route->post("/home", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Dash($auth))->home($data);});
$route->get("/perfil", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Profile($auth))->profile($data);});
$route->post("/perfil", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Profile($auth))->profile($data);});
$route->get("/logoff", function($data) use ($auth) {(new \Source\App\Beta\Controllers\Dash($auth))->logoff($data);});

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

//Perfil do Usuário Logado
$route->get("/perfil", "Users:profile");
$route->post("/perfil", "Users:profile");

//Igrejas
$route->get("/igrejas", "Churchs:churchs");
$route->get("/igrejas/cadastrar", "Churchs:create");
$route->post("/igrejas/cadastrar", "Churchs:create");
$route->get("/igrejas/editar/{church_id}", "Churchs:edit");
$route->post("/igrejas/editar/{church_id}", "Churchs:edit");
$route->get("/igrejas/desativadas", "Churchs:disabledChurchs");
$route->get("/igrejas/status/{church_id}", "Churchs:toggleStatus");
$route->post("/igrejas/excluir", "Churchs:delete");

//N[iveis]
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

//Users (Rotas alinhadas com o controller Users.php refatorado)
$route->get("/usuarios", "Users:users");
$route->get("/usuarios/cadastrar", "Users:create");
$route->post("/usuarios/cadastrar", "Users:create");
$route->get("/usuarios/editar/{user_id}", "Users:edit");
$route->post("/usuarios/editar/{user_id}", "Users:edit");
$route->post("/usuarios/excluir", "Users:delete");
$route->get("/usuarios/desativados", "Users:disabledUsers");
$route->get("/usuarios/status/{user_id}", "Users:toggleStatus");
$route->get("/usuarios/json", "Users:listJson");
$route->get("/usuarios/termo/{patrimonys_id}", "Users:term");
$route->get("/usuarios/historico/termo/{patrimonys_id}", "Users:termHistory");

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
$route->dispatch();

if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();