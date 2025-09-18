<?php

namespace Source\Models\Company;

use Source\Core\Model;

class Church extends Model
{
    public function __construct()
    {
        parent::__construct("churchs", ["id"], ["church_name", "country_id", "code_id", "address", "city", "state", "status"]);
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|User
     */
    public function findByEmail(string $email, string $columns = "*"): ?Church
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }

    /**
     * @return string|null
     */
    public function photo(): ?string
    {
        if ($this->photo && file_exists(__DIR__ . "/../../" . CONF_UPLOAD_DIR . "/{$this->photo}")) {
            return $this->photo;
        }

        return null;
    }

    /**
     * @return string
     */
    public function statusBadge(): string
    {
        if($this->status == 'actived'):
            return '<span class="badge text-bg-success text-light ms-2">ATIVO</span>';
        else:
            return '<span class="badge text-bg-danger ms-2">INATIVO</span>';
        endif;  
    }

    public function photoList(): ?string
    {
        if($this->photo && file_exists('themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$this->photo)){
            return '<a href="../themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$this->photo.'" target="_blank">
                    <img src="../themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$this->photo.'" height="40" width="40" class="img-thumbnail rounded-circle float-left"></a>';
        }else{
            return '<a href="../storage/images/avatar.jpg" target="_blank">
                    <img src="../storage/images/avatar.jpg" class="img-thumbnail rounded-circle float-left"
                    height="40" width="40"></a>';
        }
        return null;
    } 
    
    /**
     * @return null|string
     */
    public function photoListDisabled(): ?string
    {
        if($this->photo && file_exists('themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$this->photo)){
            return '<a href="../../themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$this->photo.'" target="_blank">
                    <img src="../../themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$this->photo.'" height="40" width="40" class="img-thumbnail rounded-circle float-left"></a>';
        }else{
            return '<a href="../../storage/images/avatar.jpg" target="_blank">
                    <img src="../../storage/images/avatar.jpg" class="img-thumbnail rounded-circle float-left"
                    height="40" width="40"></a>';
        }
        return null;
    } 

    /**
     * @return null|Church
     */
    static function completeName($columns): ?Church
    {
        $stm = (new Church())->find("","",$columns);
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->church_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|Church
     */
    static function completeChurch(): ?Church
    {
        $stm = (new Church())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->church_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
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

        /** User Update */
        if (!empty($this->id)) {
            $churchId = $this->id;

            if (!empty($this->email) && $this->find("email = :e AND id != :i", "e={$this->email}&i={$churchId}", "id")->fetch()) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$churchId}");
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

            $churchId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($churchId))->data();
        return true;
    }
}