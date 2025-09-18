<?php

namespace Source\Support;

/**
 * Classe para gerenciamento de logs do sistema
 * 
 * @package Source\Support
 */
class Log
{
    /** @var string */
    private $path;

    /**
     * Log constructor.
     * @param string|null $path
     */
    public function __construct(string $path = null)
    {
        $this->path = $path ?? dirname(__DIR__, 2) . "/storage/logs";
        
        // Cria o diretório de logs se não existir
        if (!file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    /**
     * Registra um erro no arquivo de log
     * 
     * @param string $message
     * @param string $level
     * @return bool
     */
    public function write(string $message, string $level = "error"): bool
    {
        $today = date("Y-m-d");
        $now = date("H:i:s");
        $log = "[{$level}] [{$now}] {$message}\n";
        
        return file_put_contents(
            "{$this->path}/{$today}.log",
            $log,
            FILE_APPEND
        ) !== false;
    }

    /**
     * Registra um erro
     * 
     * @param string $message
     * @return bool
     */
    public function error(string $message): bool
    {
        return $this->write($message, "error");
    }

    /**
     * Registra uma informação
     * 
     * @param string $message
     * @return bool
     */
    public function info(string $message): bool
    {
        return $this->write($message, "info");
    }

    /**
     * Registra um aviso
     * 
     * @param string $message
     * @return bool
     */
    public function warning(string $message): bool
    {
        return $this->write($message, "warning");
    }
}