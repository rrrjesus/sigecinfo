<?php

/**
 * SITE CONFIG
 */
define("CONF_SITE_NAME", "SIGECINFO");
define("CONF_SITE_TITLE", "Sistema de Gestão de Informações");
define("CONF_SITE_DESC", "Sistema de Gestão de Informações");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "sigecinfo.com.br");

/**
 * DATABASE
 */
if (file_exists(__DIR__ . "/../../.env")) {
    $env = parse_ini_file(__DIR__ . "/../../.env");
    
    define("CONF_DB_HOST", $env["DB_HOST"] ?? "");
    define("CONF_DB_USER", $env["DB_USER"] ?? "");
    define("CONF_DB_PASS", $env["DB_PASS"] ?? "");
    define("CONF_DB_NAME", $env["DB_NAME"] ?? "");
} else {
    define("CONF_DB_HOST", "");
    define("CONF_DB_USER", "");
    define("CONF_DB_PASS", "");
    define("CONF_DB_NAME", "");
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
define("CONF_VIEW_EXT", ".php");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");

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