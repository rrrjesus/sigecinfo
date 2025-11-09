<?php

namespace Source\Domain\Place\Models;

use Source\Core\Model;
use Source\Domain\User\Models\User;

class Place extends Model
{
    public function __construct()
    {
        parent::__construct("places", ["id"], ["place_name", "country_id", "code_id", "address", "city", "state", "status"]);
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|User
     */
    public function findByCode(string $code_id, string $columns = "*"): ?Place
    {
        $find = $this->find("code_id = :code_id", "code_id={$code_id}", $columns);
        return $find->fetch();
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
     * @return null|Place
     */
    static function completePlace(): ?Place
    {
        $stm = (new Place())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->place_name;
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
            $placeId = $this->id;

            if (!empty($this->code_id) && $this->find("code_id = :c AND id != :i", "c={$this->code_id}&i={$placeId}", "id")->fetch()) {
                $this->message->warning("O Local informado já está cadastrado !!!");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$placeId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByCode($this->code_id, "id")) {
                $this->message->warning("Já existe um local cadastrado com este código.");
                return false;
            }

            $placeId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($placeId))->data();
        return true;
    }
}