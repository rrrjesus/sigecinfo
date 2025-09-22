<?php

namespace Source\Models\Company;

use Source\Core\Model;

/**
 * Class User
 * @package Source\Models
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        $requiredFields = ["user_name", "email", "password", "church_id", "position_id", "level_id"];
        parent::__construct("users", ["id"], $requiredFields);
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|User
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }
    
    /**
     * @return null|Church
     */
    public function church(): ?Church
    {
        if ($this->church_id) {
            return (new Church())->findById($this->church_id);
        }
        return null;
    }

    /**
     * @return null|UserPosition
     */
    public function position(): ?UserPosition
    {
        if ($this->position_id) {
            return (new UserPosition())->findById($this->position_id);
        }
        return null;
    }

    /**
     * @return null|Level
     */
    public function level(): ?Level
    {
        if ($this->level_id) {
            return (new Level())->findById($this->level_id);
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function photo(): ?string
    {
        if ($this->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$this->photo}")) {
            return $this->photo;
        }
        return null;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        // CREATE: Validação de campos obrigatórios apenas na criação
        if (empty($this->id)) {
            foreach ($this->required as $field) {
                if (empty($this->data->$field)) {
                    $this->message->warning("Por favor, preencha os campos obrigatórios.");
                    return false;
                }
            }
        }
        
        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido.");
            return false;
        }

        // Validação de senha apenas se ela for alterada/criada
        if (!empty($this->password) && !passwd_verify(" ", $this->password)) {
             if (!is_passwd($this->password)) {
                $min = CONF_PASSWD_MIN_LEN;
                $max = CONF_PASSWD_MAX_LEN;
                $this->message->warning("A senha deve ter maiúscula, número, caracter especial e entre {$min} e {$max} caracteres.");
                return false;
            }
            $this->password = passwd($this->password);
        }

        // Validação de duplicidade
        if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$this->id}")->fetch()) {
            $this->message->warning("Já existe um usuário cadastrado com este e-mail.");
            return false;
        }

        if ($this->find("phone_mobile = :p AND id != :i", "p={$this->phone_mobile}&i={$this->id}")->fetch()) {
            $this->message->warning("Já existe um celular cadastrado com este número.");
            return false;
        }
        
        return parent::save();
    }
}