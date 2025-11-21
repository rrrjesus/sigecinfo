<?php

namespace Source\Domain\User\Models;

use Source\Core\Model;
use Source\Domain\Place\Models\Place;
use Source\Domain\User\Models\Level;

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
        parent::__construct("users", ["id"], ["user_name", "email", "password", "place_id", "position_id", "level_id"]);
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
     * @return null|User
     */
    static function completeUser(): ?User
    {
        $stm = (new User())->find("status != :s","s=disabled");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->user_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /** @var array|null */
    private ?array $permissions = null;

    /**
     * Verifica se o usuário possui uma determinada permissão.
     *
     * @param string $permissionName O nome da permissão a ser verificada (ex: 'users_create').
     * @return bool Retorna true se o usuário tiver a permissão, false caso contrário.
     */
    public function hasPermission(string $permissionName): bool
    {
        // Se as permissões ainda não foram carregadas, busca no banco.
        if ($this->permissions === null) {
            $this->loadPermissions();
        }

        // O Super Admin (level 1) sempre tem todas as permissões.
        if ($this->level_id == 1) {
            return true;
        }

        // Verifica se a permissão existe no array de permissões do usuário.
        return in_array($permissionName, $this->permissions ?? []);
    }

    /**
     * Carrega as permissões do nível do usuário a partir do banco de dados.
     */
    private function loadPermissions(): void
    {
        $this->permissions = [];
        if (empty($this->level_id)) {
            return;
        }

        // Busca os nomes das permissões associadas ao nível do usuário
        $query = "
            SELECT p.name 
            FROM permissions as p
            JOIN level_permissions as lp ON p.id = lp.permission_id
            WHERE lp.level_id = :level_id
        ";
        
        $stmt = \Source\Core\Connect::getInstance()->prepare($query);
        $stmt->bindValue(":level_id", $this->level_id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $permissions = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        if ($permissions) {
            $this->permissions = $permissions;
        }
    }


    /**
     * @return null|Place
     */
    public function place(): ?Place
    {
        if ($this->place_id) {
            return (new Place())->findById($this->place_id);
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