<?php

/**
 * DATABASE
 */
 define("CONF_DB_HOST", "192.168.15.54");
 define("CONF_DB_USER", "sigecinfost11");
 define("CONF_DB_PASS", "VYtf_y]4Ftn9E[nQ");
 define("CONF_DB_NAME", "sigecinfost11");
   
 /**
  * PROJECT URLs
  */
 define("CONF_URL_BASE", "http://192.168.15.54/sigecinfo");
 define("CONF_URL_TESTE", "http://127.0.0.1/sigecinfo");
 define("CONF_URL_ADMIN", "/dashboard");

/**
 * SITE
 */
define("CONF_SITE_NAME", "Sigecinfost11");
define("CONF_SITE_TITLE", "Sistema de Gerenciamento e Controle de Informações");
define("CONF_SITE_DESC", "O Sigecinfo é um gerenciador e controlador de informações simples, poderoso e ágil. A facilidade de ter o controle total de pessoas e eventos.");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "sigecinfo");
define("CONF_SITE_EMAIL", "informatica.setor11@mail.com");
define("CONF_SITE_ADDR_STREET", "R. José Buono");
define("CONF_SITE_ADDR_NUMBER", "65");
define("CONF_SITE_ADDR_COMPLEMENT", "Setor 11");
define("CONF_SITE_ADDR_NEIGHBORHOOD", "Jaçanã");
define("CONF_SITE_ADDR_CITY", "São Paulo");
define("CONF_SITE_ADDR_STATE", "SP");
define("CONF_SITE_ADDR_ZIPCODE", "02273-120");

/**
 * COLORS
 */
define("CONF_WEB_COLOR","ccb");
define("CONF_VIEW_COLOR","ccb");
define("CONF_APP_COLOR","success");
define("CONF_ADMIN_COLOR","dark");

/**
 * SOCIAL
 */
define("CONF_SOCIAL_TWITTER_CREATOR", "");
define("CONF_SOCIAL_TWITTER_PUBLISHER", "");
define("CONF_SOCIAL_FACEBOOK_APP", "");
define("CONF_SOCIAL_FACEBOOK_PAGE", "");
define("CONF_SOCIAL_FACEBOOK_AUTHOR", "");
define("CONF_SOCIAL_GOOGLE_PAGE", ""); //107305124528362639842
define("CONF_SOCIAL_GOOGLE_AUTHOR", ""); //103958419096641225872
define("CONF_SOCIAL_INSTAGRAM_PAGE", "");
define("CONF_SOCIAL_YOUTUBE_PAGE", "");

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

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
define("CONF_VIEW_PATH", __DIR__ . "/../../shared/views");
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_THEME", "web");
define("CONF_VIEW_IFRAME", "iframe");
define("CONF_VIEW_APP", "app");
define("CONF_VIEW_ADMIN", "admin");

/**
 * UPLOAD   
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * MAIL
 */
define("CONF_MAIL_HOST", "smtp.hostinger.com.br");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_USER", "sigecinfo@informaticast11.online"); //apikey ou conta de e-mail
define("CONF_MAIL_PASS", ""); //senha apikey ou senha conta de e-mail
define("CONF_MAIL_SENDER", ["name" => "SIGECINFO - INFO SETOR 11", "address" => "sigecinfo@informaticast11.online"]);
define("CONF_MAIL_SUPPORT", "sigecinfosuporte@informaticast11.online");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");