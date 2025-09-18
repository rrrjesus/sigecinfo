<?php

namespace Source\Boot;

/**
 * Class Password
 * 
 * Classe responsável por definir as configurações de senha
 * 
 * @package Source\Boot
 */
class Password
{
    /**
     * Configurações de senha
     */
    public static function config(): void
    {
        // Tamanho mínimo da senha (8 caracteres)
        define("CONF_PASSWD_MIN_LEN", 8);
        
        // Tamanho máximo da senha (40 caracteres)
        define("CONF_PASSWD_MAX_LEN", 40);
        
        // Algoritmo de hash (PASSWORD_DEFAULT usa o algoritmo mais forte disponível)
        define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
        
        // Opções para o algoritmo de hash
        define("CONF_PASSWD_OPTION", ["cost" => 10]);
    }
    
    /**
     * Valida uma senha com regras mais robustas
     * 
     * @param string $password
     * @return bool
     */
    public static function isStrong(string $password): bool
    {
        // Verifica se a senha já está em formato de hash
        if (password_get_info($password)["algo"]) {
            return true;
        }
        
        // Verifica o comprimento da senha
        if (mb_strlen($password) < CONF_PASSWD_MIN_LEN || mb_strlen($password) > CONF_PASSWD_MAX_LEN) {
            return false;
        }
        
        // Verifica se contém pelo menos um número
        if (!preg_match("/[0-9]/", $password)) {
            return false;
        }
        
        // Verifica se contém pelo menos uma letra maiúscula
        if (!preg_match("/[A-Z]/", $password)) {
            return false;
        }
        
        // Verifica se contém pelo menos uma letra minúscula
        if (!preg_match("/[a-z]/", $password)) {
            return false;
        }
        
        // Verifica se contém pelo menos um caractere especial
        if (!preg_match("/[^a-zA-Z0-9]/", $password)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Retorna mensagem de erro para senha fraca
     * 
     * @return string
     */
    public static function passwordRequirementsMessage(): string
    {
        return "A senha deve conter pelo menos {$_ENV['CONF_PASSWD_MIN_LEN']} caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.";
    }
}