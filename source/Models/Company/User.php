<?php

namespace Source\Models\Company;

use Source\Core\Model;

/**
 * FSPHP | Class User Active Record Pattern
 *
 * @author SIGECINFO Team <contato@sigecinfo.com.br>
 * @package Source\Models
 */
class User extends Model
{

     public function __construct()
    {
        parent::__construct(
            "users",                                // tabela
            ["id"],                                 // campos protegidos (não podem ser alterados)
            ["user_name", "email", "password"]      // campos obrigatórios para insert
        );
    }

    /**
     * @param string $phone_mobile
     * @param string $columns
     * @return null|User
     */
    public function findByPhoneMobile(string $phone_mobile, string $columns = "*"): ?User
    {
        $find = $this->find("phone_mobile = :phone_mobile", "phone_mobile={$phone_mobile}", $columns);
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
     * @return null|Church
     */
    public function userChurch(): ?Church
    {
        if($this->church_id) {
            return(new Church())->findById($this->church_id);
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
     * @return null|Church
     */
    public function churchselect(): ?Church
    {
        $stm = (new Church())->find("status=:s","s=actived")->fetch(true);

        if(!empty($stm)):
            foreach ($stm as $row):
                echo '<option value="'.$row->id.'">'.$row->church_name.'</option>'; //Return the JSON Array
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

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}", "id")->fetch()) {
                $this->message->warning("Já existe um usuário cadastrado com este e-mail.");
                return false;
            }

            if ($this->find("phone_mobile = :p AND id != :i", "p={$this->phone_mobile}&i={$userId}", "id")->fetch()) {
                $this->message->warning("Já existe um celular cadastrado com este número.");
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
                $this->message->warning("Já existe um usuário cadastrado com este e-mail.");
                return false;
            }

            if ($this->findByPhoneMobile($this->phone_mobile, "id")) {
                $this->message->warning("Já existe um usuário cadastrado com este celular.");
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