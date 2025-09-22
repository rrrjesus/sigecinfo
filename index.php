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
use Source\Models\Auth;

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
$route->get("/", "Web:home");
$route->get("/sobre", "Web:about");
$route->get("/email", "Web:creatorCard");
$route->group("/reunioes");
$route->get("/", "Web:meetings");
$route->group("/contatos");
$route->get("/", "Web:contact");

//auth
$route->group(null);
$route->get("/entrar", "Web:login");
$route->post("/entrar", "Web:login");
$route->get("/cadastrar", "Web:register");
$route->post("/cadastrar", "Web:register");
$route->get("/recuperar", "Web:forget");
$route->post("/recuperar", "Web:forget");
$route->get("/recuperar/{code}", "Web:reset");
$route->post("/recuperar/resetar", "Web:reset");

//optin
$route->group(null);
$route->get("/confirma", "Web:confirm");
$route->get("/obrigado/{email}", "Web:success");

//services
$route->group(null);
$route->get("/termos", "Web:terms");

/**
 * VIEWS ROUTES
 */
$route->namespace("Source\App");
$route->group("/iframes");
$route->get("/contatos", "Iframe:contact");
$route->get("/email", "Iframe:creatorCard");

/**
 * APP ROUTES
 */
$route->namespace("Source\App\Beta");
$route->group("/beta");
$route->get("/", "Login:root");
$route->get("/login", "Login:login");
$route->post("/login", "Login:login");
$route->get("/", "Dash:dash");
$route->get("/home", "Dash:home");
$route->post("/home", "Dash:home");
$route->get("/perfil", "Profile:profile");
$route->post("/perfil", "Profile:profile");     
$route->get("/contatos", "Patrimony:contact");
$route->get("/logoff", "Dash:logoff");

/**
 * ADMIN ROUTES (Refactored for Dependency Injection)
 */
$route->namespace("Source\App\Admin");
$route->group("/painel");

//Login
$route->get("/", "Login:root");
$route->get("/login", function ($data) use ($auth) {
    (new \Source\App\Admin\Login($auth))->login($data);
});
$route->post("/login", function ($data) use ($auth) {
    (new \Source\App\Admin\Login($auth))->login($data);
});

//Dash
$route->get("/controle", "Dash:dash");
$route->get("/controle/inicial", "Dash:home");
$route->post("/controle/inicial", "Dash:home");
$route->get("/logoff", "Dash:logoff");

//perfil
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
$route->post("/igrejas/excluir", "Churchs:delete");

//Cargos
$route->get("/cargos", "UsersPositions:userspositions");
$route->get("/cargos/desativados", "UsersPositions:disabledUsersPositions");
$route->get("/cargos/cadastrar", "UsersPositions:userposition");
$route->post("/cargos/cadastrar", "UsersPositions:userposition");
$route->get("/cargos/editar/{userposition_id}", "UsersPositions:userposition");
$route->post("/cargos/editar/{userposition_id}", "UsersPositions:userposition");
$route->get("/cargos/ativar/{userposition_id}/{action}", "UsersPositions:userposition");
$route->get("/cargos/desativar/{userposition_id}/{action}", "UsersPositions:userposition");
$route->get("/cargos/excluir/{userposition_id}/{action}", "UsersPositions:userposition");

//Users
$route->get("/usuarios", "Users:users");
$route->get("/usuarios/desativados", "Users:disabledUsers");
$route->get("/usuarios/cadastrar", "Users:user");
$route->post("/usuarios/cadastrar", "Users:user");
$route->get("/usuarios/editar/{user_id}", "Users:user");
$route->post("/usuarios/editar/{user_id}", "Users:user");
$route->get("/usuarios/ativar/{user_id}/{action}", "Users:user");
$route->get("/usuarios/desativar/{user_id}/{action}", "Users:user");
$route->get("/usuarios/excluir/{user_id}/{action}", "Users:user");
$route->get("/usuarios/termo/{patrimonys_id}", "Users:term");
$route->get("/usuarios/historico/termo/{patrimonys_id}", "Users:termHistory");

//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");

$route->namespace("Source\App");

/**
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();