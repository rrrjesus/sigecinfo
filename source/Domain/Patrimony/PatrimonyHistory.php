<?php

namespace Source\Models\Patrimony;

use Source\Core\Model;
use Source\Models\Company\Unit;
use Source\Models\Company\User;
use Source\Models\Patrimony\Product;
use Source\Models\Patrimony\Movement;


/**
 * SMSUB | Class  PatrimonyHistory
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */
class  PatrimonyHistory extends Model
{
    /**
     *  PatrimonyHistory constructor.
     */
    public function __construct()
    {
        parent::__construct("patrimonys_historys", ["id"], ["patrimony_id", "user_id","patrimonys_name", "product_id", "description", "unit_id", "file_terms", "part_number", "status", "photo", "observations", "created_history", "login_created"]);
    }

    /**
     * @param string $patrimony_id
     * @param string $columns
     * @return null|PatrimonyHistory
     */
    public function findByPatrimonyId(string $patrimony_id, string $columns = "*"): ?PatrimonyHistory
    {
        $find = $this->find("patrimony_id = :patrimony_id", "patrimony_id={$patrimony_id}", $columns);
        return $find->fetch();
    }

    /**
     * @return null|User
     */
    public function user(): ?User
    {
        if($this->user_id) {
            return(new User())->findById($this->user_id);
        }
        return null;
    }

    /**
     * @return null|Product
     */
    public function product(): ?Product
    {
        if($this->product_id) {
            return(new Product())->findById($this->product_id);
        }
        return null;
    }

    /**
     * @return null|Unit
     */
    public function unit(): ?Unit
    {
        if($this->unit_id) {
            return(new Unit())->findById($this->unit_id);
        }
        return null;
    }

    /**
     * @return null|Movement
     */
    public function movement(): ?Movement
    {
        if($this->movement_id) {
            return(new Movement())->findById($this->movement_id);
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
     * @return null|Unit
     */
    static function completeUnit(): ?Unit
    {
        $stm = (new Unit())->find("status = :s","s=actived");
        $array = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                $array[] = $row->id.' - '.$row->unit_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|Product
     */
    static function completeProduct(): ?Product
    {
        $stm = (new Product())->find("status = :s","s=actived");
        $array = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                $array[] = $row->id.' - '.$row->product_name.' - '.$row->contract()->contract_name.' - (Nº de Registro '.$row->type_part_number.')';
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|Movement
     */
    static function completeMovement(): ?Movement
    {
        $stm = (new Movement())->find("","");
        $array = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                $array[] = $row->id.' - '.$row->movement_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|string
     */
    public function fileTerm(): ?string
    {
        if(!empty($this->file_terms) && file_exists(CONF_UPLOAD_DIR.'/'.$this->file_terms)){
            return buttonLink("storage/{$this->file_terms}", "top", "Clique para visualizar termo assinado", "danger", "file-earmark-pdf", "Term Ass", "7", "t", "_blank");
        }else{
            return '';
        }
        return null;
    } 

    /**
     * @return null|string
     */
    public function fileList(): ?string
    {
        if(!empty($this->file_terms) && file_exists(CONF_UPLOAD_DIR.'/'.$this->file_terms)){
            return buttonLinkCircle("storage/{$this->file_terms}", "top", "Clique para visualizar termo assinado", "danger", "file-earmark-pdf", "", "", "b", "_blank");
        }else{
            return '';
        }
        return null;
    } 

    /**
     * @return null|string
     */
    public function termList(): ?string
    {
        if($this->user_id){
            return buttonLinkCircle("/beta/patrimonio/historico/termo/{$this->id}", "top", "Clique para visualizar termo para assinar", "primary", "file-earmark-word", "", "", "a", "_blank");
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function termlistUser(): ?string
    {
        if($this->user_id){
            return buttonLinkCircle("/painel/usuarios/historico/termo/{$this->id}", "top", "Clique para visualizar termo para assinar", "primary", "file-earmark-word", "", "", "a", "_blank");
        }
        return null;
    }

    /**
     * @return string
     */
    public function statusBadge(): string
    {
        if($this->status == 'actived'):
            return '<span class="badge text-bg-success ms-2">Ativo</span>';
        else:
            return '<span class="badge text-bg-danger ms-2">Inativo</span>';
        endif;  
    }

    /**
     * @return null|string
     */
    public function statusBadgeUser($status): string
    {
        if($status == 'disabled'){
            return '<span class="badge text-bg-danger ms-2">Inativo</span>';
        }else{
            return '<span class="badge text-bg-success ms-2">Ativo</span>';
        }
        return null;  
    }

    /**
     * @return bool
     */
    public function save(): bool
    {

        /** Patrimony Update */
        if (!empty($this->id)) {
            $patrimonyId = $this->id;
            
            $this->update($this->safe(), "id = :id", "id={$patrimonyId}");
            
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

         /** Patrimony Create */
         if (empty($this->id)) {
            // if ($this->find("movement_id = :m AND unit_id = :d AND part_number = :p AND user_id = :u", "m={$this->movement_id}&d={$this->unit_id}&p={$this->part_number}&u={$this->user_id}", "patrimony_id")->fetch()) {
            //     return false;
            // }

            $patrimonyId = $this->create($this->safe());

            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($patrimonyId))->data();
        return true;
    }
}