<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");
$route->namespace("Source\App");

/**
 * WEB ROUTES
 */
$route->group(null);
$route->get("/", "Web:home");
$route->get("/sobre", "Web:about");

//assinatura de email
$route->get("/email", "Web:creatorCard");

//reuniões
$route->group("/reunioes");
$route->get("/", "Web:meetings");

//agenda
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

//agenda iframes
$route->get("/contatos", "Iframe:contact");

//assinatura de email iframes
$route->get("/email", "Iframe:creatorCard");

/**
 * APP ROUTES
 */
$route->namespace("Source\App\Beta");
$route->group("/beta");

//login
$route->get("/", "Login:root");
$route->get("/login", "Login:login");
$route->post("/login", "Login:login");

//dash
$route->get("/", "Dash:dash");
$route->get("/home", "Dash:home");
$route->post("/home", "Dash:home");

$route->get("/perfil", "Profile:profile");
$route->post("/perfil", "Profile:profile");     
$route->get("/contatos", "Patrimony:contact");

//Igrejas
$route->get("/igrejas", "Churchs:churchs");
$route->get("/igrejas/desativadas", "Churchs:disabledChurches");
$route->get("/igrejas/cadastrar", "Churchs:church");
$route->post("/igrejas/cadastrar", "Churchs:church");
$route->get("/igrejas/editar/{churche_id}", "Churchs:church");
$route->post("/igrejas/editar/{churche_id}", "Churchs:church");
$route->get("/igrejas/ativar/{churche_id}/{action}", "Churchs:church");
$route->get("/igrejas/desativar/{churche_id}/{action}", "Churchs:church");
$route->get("/igrejas/excluir/{churche_id}/{action}", "Churchs:church");

$route->get("/logoff", "Dash:logoff");

/**
 * ADMIN ROUTES
 */
$route->namespace("Source\App\Admin");
$route->group("/painel");

//Login
$route->get("/", "Login:root");
$route->get("/login", "Login:login");
$route->post("/login", "Login:login");

//Dash
$route->get("/controle", "Dash:dash");
$route->get("/controle/inicial", "Dash:home");
$route->post("/controle/inicial", "Dash:home");
$route->get("/logoff", "Dash:logoff");

//perfil
$route->get("/perfil", "Users:profile");
$route->post("/perfil", "Users:profile");

/**
 * Company
 */

//Igrejas
$route->get("/igrejas", "Churchs:churchs");
$route->get("/igrejas/desativadas", "Churchs:disabledChurches");
$route->get("/igrejas/cadastrar", "Churchs:church");
$route->post("/igrejas/cadastrar", "Churchs:church");
$route->get("/igrejas/editar/{churche_id}", "Churchs:church");
$route->post("/igrejas/editar/{churche_id}", "Churchs:church");
$route->get("/igrejas/ativar/{churche_id}/{action}", "Churchs:church");
$route->get("/igrejas/desativar/{churche_id}/{action}", "Churchs:church");
$route->get("/igrejas/excluir/{churche_id}/{action}", "Churchs:church");

$route->get("/cargos", "UsersPositions:userspositions");
$route->get("/cargos/desativados", "UsersPositions:disabledUsersPositions");
$route->get("/cargos/cadastrar", "UsersPositions:userposition");
$route->post("/cargos/cadastrar", "UsersPositions:userposition");
$route->get("/cargos/editar/{userposition_id}", "UsersPositions:userposition");
$route->post("/cargos/editar/{userposition_id}", "UsersPositions:userposition");
$route->get("/cargos/ativar/{userposition_id}/{action}", "UsersPositions:userposition");
$route->get("/cargos/desativar/{userposition_id}/{action}", "UsersPositions:userposition");
$route->get("/cargos/excluir/{userposition_id}/{action}", "UsersPositions:userposition");

$route->get("/regimes", "UsersCategories:UsersCategories");
$route->get("/regimes/desativados", "UsersCategories:disabledUsersCategories");
$route->get("/regimes/cadastrar", "UsersCategories:usercategory");
$route->post("/regimes/cadastrar", "UsersCategories:usercategory");
$route->get("/regimes/editar/{usercategory_id}", "UsersCategories:usercategory");
$route->post("/regimes/editar/{usercategory_id}", "UsersCategories:usercategory");
$route->get("/regimes/ativar/{usercategory_id}/{action}", "UsersCategories:usercategory");
$route->get("/regimes/desativar/{usercategory_id}/{action}", "UsersCategories:usercategory");
$route->get("/regimes/excluir/{usercategory_id}/{action}", "UsersCategories:usercategory");

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

//END ADMIN
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