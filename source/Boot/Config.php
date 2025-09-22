<?php

/**
 * SITE CONFIG
 */
define("CONF_SITE_NAME", "SIGECINFO");
define("CONF_SITE_TITLE", "Sistema de Gestão de Informações");
define("CONF_SITE_DESC", "Sistema de Gestão de Informações");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "sigecinfo.com.br");
define("CONF_SITE_EMAIL", "informatica.setor11@informaticast11.online");
define("CONF_SITE_ADDR_STREET", "Rua São Bento, 405 / Rua Líbero Badaró");
define("CONF_SITE_ADDR_NUMBER", "504");
define("CONF_SITE_ADDR_COMPLEMENT", "Edifício Martinelli - 23º e 24º andar");
define("CONF_SITE_ADDR_NEIGHBORHOOD", "Centro");
define("CONF_SITE_ADDR_CITY", "São Paulo");
define("CONF_SITE_ADDR_STATE", "São Paulo");
define("CONF_SITE_ADDR_ZIPCODE", "01011-100");

/**
 * COLORS
 */
define("CONF_WEB_COLOR","sigecinfo");
define("CONF_VIEW_COLOR","sigecinfo");
define("CONF_APP_COLOR","success");
define("CONF_ADMIN_COLOR","dark");

/**
 * MAIL
 */ 
define("CONF_MAIL_HOST", "smtp.hostinger.com.br");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

/**
 * DATABASE
 */
if (file_exists(__DIR__ . "/../../.env")) {
    $env = parse_ini_file(__DIR__ . "/../../.env");
    
    define("CONF_DB_HOST", $env["DB_HOST"] ?? "");
    define("CONF_DB_USER", $env["DB_USER"] ?? "");
    define("CONF_DB_PASS", $env["DB_PASS"] ?? "");
    define("CONF_DB_NAME", $env["DB_NAME"] ?? "");
    define("CONF_MAIL_USER", $env["MAIL_USER"] ?? "");
    define("CONF_MAIL_PASS", $env["MAIL_PASS"] ?? "");
    define("CONF_MAIL_SUPPORT", $env["MAIL_SUPPORT"] ?? "");
} else {
    define("CONF_DB_HOST", "");
    define("CONF_DB_USER", "");
    define("CONF_DB_PASS", "");
    define("CONF_DB_NAME", "");
    define("CONF_MAIL_USER", "");
    define("CONF_MAIL_PASS", "");
    define("CONF_MAIL_SUPPORT", "");
}

/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_VIEW_WEB", "web");
define("CONF_VIEW_APP", "app");
define("CONF_VIEW_ADMIN", "admin");
define("CONF_VIEW_IFRAME", "iframe");
define("CONF_VIEW_THEME", "web");
define("CONF_VIEW_PATH", __DIR__ . "/../../themes");
define("CONF_VIEW_EXT", "php");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * LOGS
 */
define("CONF_LOG_DIR", "storage/logs");

/**
 * SOCIAL
 */
define("CONF_SOCIAL_TWITTER_CREATOR", "@sigecinfo");
define("CONF_SOCIAL_TWITTER_PUBLISHER", "@sigecinfo");
define("CONF_SOCIAL_FACEBOOK_APP", "sigecinfo");
define("CONF_SOCIAL_FACEBOOK_PAGE", "sigecinfo");
define("CONF_SOCIAL_FACEBOOK_AUTHOR", "sigecinfo");
define("CONF_SOCIAL_GOOGLE_PAGE", "sigecinfo");
define("CONF_SOCIAL_GOOGLE_AUTHOR", "sigecinfo");
define("CONF_SOCIAL_INSTAGRAM_PAGE", "sigecinfo");
define("CONF_SOCIAL_YOUTUBE_PAGE", "sigecinfo");

/**
 * URL
 */
if (file_exists(__DIR__ . "/../../.env")) {
    $env = parse_ini_file(__DIR__ . "/../../.env");
    
    define("CONF_URL_BASE", $env["URL_BASE"] ?? "http://localhost/sigecinfo");
    define("CONF_URL_TEST", $env["URL_TESTE"] ?? "http://localhost/sigecinfo");
    define("CONF_URL_ADMIN", $env["URL_ADMIN"] ?? "/dashboard");
} else {
    define("CONF_URL_BASE", "http://localhost/sigecinfo");
    define("CONF_URL_TEST", "http://localhost/sigecinfo");
    define("CONF_URL_ADMIN", "/dashboard");
}