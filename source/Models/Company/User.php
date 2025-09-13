<?php

namespace Source\Models\Company;

use Source\Core\Model;

/**
 * FSPHP | Class User Active Record Pattern
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Models
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["id"], ["login", "rf", "status", "photo", "user_name", "cell_phone", "fixed_phone", "email", "password"]);
    }

    /**
     * @param string $login
     * @param string $columns
     * @return null|User
     */
    public function findByLogin(string $login, string $columns = "*"): ?User
    {
        $find = $this->find("login = :login", "login={$login}", $columns);
        return $find->fetch();
    }

    /**
     * @param string $rf
     * @param string $columns
     * @return null|User
     */
    public function findByRf(string $rf, string $columns = "*"): ?User
    {
        $find = $this->find("rf = :rf", "rf={$rf}", $columns);
        return $find->fetch();
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
     * @return null|string
     */
    public function statusSelected(): ?string
    {
        if ($this->status == "registered") {
            return '<option value="registered" selected>Registrado</option><option value="confirmed">Confirmado</option><option value="disabled">Desabilitado</option>';
        } elseif ($this->status == "confirmed") {
            return '<option value="confirmed" selected>Confirmado</option><option value="registered">Registrado</option><option value="disabled">Desabilitado</option>';
        } else {
            return '<option value="disabled" selected>Desabilitado</option><option value="registered">Registrado</option><option value="confirmed">Confirmado</option>';
        }
        return null; 
    }

    /**
     * @return null|string
     */
    public function statusInput(): ?string
    {
        if ($this->status == "registered") {
            return '1 - REGISTRADO';
        } elseif ($this->status == "confirmed") {
            return '2 - CONFIRMADO';
        } else {
            return '3 - INATIVO';
        }
        return null; 
    }

    /**
     * @return null|string
     */
    public function statusSpan(): ?string
    {

    if ($this->status == "registered") {
        return '<span class="badge fw-semibold text-bg-warning pt-2 pb-2 mt-2" data-bs-togglee="tooltip" 
                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="Falta acesso ao e-mail de confirmação">
                    Registrado</span>';
    } elseif ($this->status == "confirmed") {
        return '<span class="badge fw-semibold text-bg-success text-light pt-2 pb-2 mt-2" data-bs-togglee="tooltip" 
                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="Usuário confirmou">CONFIRMADO</span>';
    } else {
        return '<span class="badge fw-semibold text-bg-danger pt-2 pb-2 mt-2">INATIVO</span>';
    }
    return null; 
    }

    /**
     * @return null|string
     */
    public function photoList(): ?string
    {
        if($this->photo && file_exists(CONF_UPLOAD_DIR.'/'.$this->photo)){
            return '<a href="../'.CONF_UPLOAD_DIR.'/'.$this->photo.'" target="_blank">
                    <img src="'.image($this->photo, 30,30).'" class="rounded-circle float-left"></a>';
        }else{
            return '<a href="../storage/images/avatar.jpg" target="_blank">
                    <img src="../storage/images/avatar.jpg" class="rounded-circle float-left"
                    height="30" width="30"></a>';
        }
        return null;
    } 
    
    /**
     * @return null|string
     */
    public function photoListDisabled(): ?string
    {
        if($this->photo && file_exists(CONF_UPLOAD_DIR.'/'.$this->photo)){
            return '<a href="../../'.CONF_UPLOAD_DIR.'/'.$this->photo.'" target="_blank">
                    <img src="'.image($this->photo, 30,30).'" class="img-thumbnail rounded-circle float-left"></a>';
        }else{
            return '<a href="../../storage/images/avatar.jpg" target="_blank">
                    <img src="../../storage/images/avatar.jpg" class="img-thumbnail rounded-circle float-left"
                    height="40" width="40"></a>';
        }
        return null;
    } 

    /**
     * @return null|string
     */
    public function statusInputDecode($status): ?string
    {
        if ($status == "1 - REGISTRADO") {
            return 'registered';
        } elseif ($status == "2 - CONFIRMADO") {
            return 'confirmed';
        } else {
            return 'disabled';
        }
        return null; 
    }

    /**
     * @return null|Unit
     */
    public function userUnit(): ?Unit
    {
        if($this->unit_id) {
            return(new Unit())->findById($this->unit_id);
        }
        return null;
    }

    /**
     * @return null|UserPosition
     */
    public function userPosition(): ?UserPosition
    {
        if($this->position_id) {
            return(new UserPosition())->findById($this->position_id);
        }
        return null;
    }

    /**
     * @return null|UserCategory
     */
    public function userCategory(): ?UserCategory
    {
        if($this->category_id) {
            return(new UserCategory())->findById($this->category_id);
        }
        return null;
    }

    /**
     * @return null|Level
     */
    public function level(): ?Level    {
        if($this->level_id) {
            return(new Level())->findById($this->level_id);
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
     * @return string
     */
    public function levelBadge(): string
    {
        if($this->level_id == 1):
            return '<span class="badge text-bg-primary ms-2">User</span>';
        elseif($this->level_id == 2):
            return '<span class="badge text-bg-light ms-2">Edit*</span>';
        elseif($this->level_id == 3):
            return '<span class="badge text-bg-info ms-2">Edit</span>';
        elseif($this->level_id == 4):
            return '<span class="badge text-bg-success ms-2">Adm*</span>';
        else:
            return '<span class="badge text-bg-warning ms-2">Adm</span>';
        endif;  
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

    /**
     * @return null|Unit
     */
    public function unitSelect(): ?Unit
    {
        $stm = (new Unit())->find("status=:s","s=actived")->fetch(true);

        if(!empty($stm)):
            foreach ($stm as $row):
                echo '<option value="'.$row->id.'">'.$row->unit_name.'</option>'; //Return the JSON Array
            endforeach;
        endif;
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

        if (!is_passwd($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
            return false;
        } else {
            $this->password = passwd($this->password);
        }

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("login = :l AND id != :i", "l={$this->login}&i={$userId}", "id")->fetch()) {
                $this->message->warning("O login informado já está cadastrado");
                return false;
            }

            if ($this->find("rf = :r AND id != :i", "r={$this->rf}&i={$userId}", "id")->fetch()) {
                $this->message->warning("O RF informado já está cadastrado");
                return false;
            }

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}", "id")->fetch()) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email, "id")) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            if ($this->findByLogin($this->login, "id")) {
                $this->message->warning("O login informado já está cadastrado");
                return false;
            }

            if ($this->findByRf($this->rf, "id")) {
                $this->message->warning("O rf informado já está cadastrado");
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