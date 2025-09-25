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
        parent::__construct("users", ["id"], ["user_name", "email", "password", "church_id", "position_id", "level_id"]);
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
        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido")->icon();
            return false;
        }

        // --- ESTE É O ÚNICO BLOCO ALTERADO ---
        // Valida e criptografa a senha apenas se uma NOVA senha (não criptografada) for informada.
        // Para operações como toggleStatus, este bloco é ignorado.
        if (!empty($this->password) && empty(password_get_info($this->password)['algo'])) {
            if (!is_passwd($this->password)) {
                $min = CONF_PASSWD_MIN_LEN;
                $max = CONF_PASSWD_MAX_LEN;
                $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres.");
                return false;
            }
            $this->password = passwd($this->password);
        }
        // --- FIM DO BLOCO ALTERADO ---

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}")->fetch()) {
                $this->message->warning("Já existe um usuário cadastrado com este e-mail.");
                return false;
            }

            if (!empty($this->phone_mobile) && $this->find("phone_mobile = :p AND id != :i", "p={$this->phone_mobile}&i={$userId}")->fetch()) {
                $this->message->warning("Já existe um celular cadastrado com este número.")->icon();
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados")->icon();
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {

            if ($this->findByEmail($this->email, "id")) {
                $this->message->warning("Já existe um usuário cadastrado com este e-mail.")->icon();
                return false;
            }
            
            if (!empty($this->phone_mobile) && $this->find("phone_mobile = :p", "p={$this->phone_mobile}")->fetch()) {
                $this->message->warning("Já existe um usuário cadastrado com este celular.")->icon();
                return false;
            }

            $userId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return true;
    }
}