<?php

namespace Source\Models\Company;

use Source\Core\Model;

/**
 *
 */
class Level extends Model
{
    public function __construct()
    {
        parent::__construct("levels", ["id"], ["level_nome"]);
    }

    /** @param string $uri
     * @param string $columns
     * @return Level|null
     */
    public function findyByLevel(string $level, string $columns = "*"): ?Level
    {
        $find = $this->find("level_nome = :s", "s={$level}", $columns);
        return $find->fetch();
    }

        /**
     * @param string $level
     * @param string $columns
     * @return null|Level
     */
    public function findByLevelId(string $level, string $columns = "*"): ?Level
    {
        $find = $this->find("id = :i", "i={$level}", $columns);
        return $find->fetch();
    }

    /**
     * @return null|Level
     */
    static function completeLevel($columns): ?Level
    {
        $stm = (new Level())->find("status=:s","s=actived",$columns);
        $array = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                $array[] = $row->level_nome;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|Level
     */
    static function selectLevelName(): ?Level
    {
        $stm = (new Level())->find("status=:s","s=actived")->fetch(true);

        if(!empty($stm)):
            foreach ($stm as $row):
                echo '<option value="'.$row->level_nome.'">'.$row->level_nome.'</option>'; //Return the JSON Array
            endforeach;
        endif;
        return null;
    }  

    /**
     * @return null|Level
     */
    static function selectLevelId(): ?Level
    {
        $stm = (new Level())->find()->fetch(true);

        if(!empty($stm)):
            foreach ($stm as $row):
                echo '<option value="'.$row->id.'">'.$row->level_nome.'</option>'; //Return the JSON Array
            endforeach;
        endif;
        return null;
    }  
    
    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Nivel e status são obrigatórios")->icon("building");
            return false;
        }

        /** igreja Update */
        if (!empty($this->id)) {
            $levelId = $this->id;

            if ($this->find("level_nome = :d AND id != :i", "d={$this->level_nome}&i={$levelId}", "id")->fetch()) {
                $this->message->warning("O nível informado já está cadastrado")->icon("building");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$levelId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Level Create */
        if (empty($this->id)) {
            if ($this->findyByLevel($this->level_nome, "id")) {
                $this->message->warning("O nível informado já está cadastrado")->icon("building");
                return false;
            }

            $levelId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($levelId))->data();
        return true;
    }
}