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
    public function findByCode(string $code_id, string $columns = "*"): ?User
    {
        $find = $this->find("code_id = :code_id", "code_id={$code_id}", $columns);
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

    /**
     * @return null|string
     */
    public function photoList(): ?string
    {
        if($this->photo && file_exists(CONF_UPLOAD_DIR.'/'.$this->photo)){
            return '<a href="../'.CONF_UPLOAD_DIR.'/'.$this->photo.'" target="_blank">
                    <img src="'.image($this->photo, 30,30).'" class="rounded-circle float-left"></a>';
        }else{
            return '<a href="../storage/images/avatar-ccb.jpg" target="_blank">
                    <img src="../storage/images/avatar-ccb.jpg" class="rounded-circle float-left"
                    height="30" width="30"></a>';
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
            return '<a href="../../storage/images/avatar-ccb.jpg" target="_blank">
                    <img src="../../storage/images/avatar-ccb.jpg" class="img-thumbnail rounded-circle float-left"
                    height="40" width="40"></a>';
        }
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


        /** User Update */
        if (!empty($this->id)) {
            $churchId = $this->id;

            if (!empty($this->code_id) && $this->find("code_id = :c AND id != :i", "c={$this->code_id}&i={$churchId}", "id")->fetch()) {
                $this->message->warning("A Igreja informada já está cadastrada");
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
            if ($this->findByCode($this->code_id, "id")) {
                $this->message->warning("Já existe uma igreja cadastrada com este código.");
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