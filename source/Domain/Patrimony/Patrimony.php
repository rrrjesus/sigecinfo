<?php

namespace Source\Models\Patrimony;

use Source\Core\Model;
use Source\Models\Patrimony\Product;
use Source\Models\Patrimony\Movement;
use Source\Models\Company\Unit;
use Source\Models\Company\User;


/**
 * SMSUB | Class Patrimony
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */
class Patrimony extends Model
{
    /**
     * Patrimony constructor.
     */
    public function __construct()
    {
        parent::__construct("patrimonys", ["id"], ["user_id","patrimonys_name", "brand_id", "product_id", "unit_id", "movement_id", "description", "file_terms", "part_number", "status", "photo", "observations"]);
    }

    /**
     * @param string $product_id
     * @param string $part_number
     * @param string $columns
     * @return null|Patrimony
     */
    public function findByPartNumber(string $product_id,string $part_number, string $columns = "*"): ?Patrimony
    {
        $find = $this->find("product_id = :product_id AND part_number = :part_number", "product_id={$product_id}&part_number={$part_number}", $columns);
        return $find->fetch();
    }

    /**
     * @param string $ns
     * @param string $columns
     * @return null|Patrimony
     */
    public function findByNs(string $ns, string $columns = "*"): ?Patrimony
    {
        $find = $this->find("ns = :ns", "ns={$ns}", $columns);
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
    public function fileListUser(): ?string
    {
        if($this->file_terms && file_exists(CONF_UPLOAD_DIR.'/'.$this->file_terms)){
            return buttonLink("storage/{$this->file_terms}", "top", "Clique para visualizar termo assinado", "danger rounded-circle", "file-earmark-pdf", "", "", "t", "_blank"); 
        }else{
            return '<p class="fw-semibold" >Sem Termo</p>';
        }
        return null;
    } 
    
    /**
     * @return null|string
     */
    public function termlistUser(): ?string
    {
        if($this->user_id){
            return buttonLink("/painel/usuarios/termo/{$this->id}", "top", "Clique para visualizar termo para assinar", "primary rounded-circle", "file-earmark-word", "", "", "t", "_blank"); 
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function file(): ?string
    {
        if ($this->file_terms && file_exists(__DIR__ . "/../../" . CONF_UPLOAD_DIR . "/{$this->file_terms}")) {
            return $this->file_terms;
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
     * @return null|Product
     */
    static function completeProduct(): ?Product
    {
        $stm = (new Product())->find("status = :s","s=actived");
        $array = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                $array[] = $row->id.' - '.$row->product_name.' - '.$row->Contract()->contract_name.' - (Nº de Registro '.$row->type_part_number.')';
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
     * @return string
     */
    public function statusBadge(): string
    {
        if($this->status == 'actived'){
            return '<span class="badge text-bg-success ms-2">Ativo</span>';
        } elseif($this->status == 'disabled'){
            return '<span class="badge text-bg-warning ms-2">Inativo</span>';
        } else {
            return '<span class="badge text-bg-danger ms-2">Baixa</span>';
        } 
    }

    /**
     * @return string
     */
    public function statusSelect(): ?string
    {
        if ($this->status == "actived") {
            return '<option value="actived" selected>Ativo</option><option value="disabled">Inativo</option><option value="writeoff">Baixa</option>';
        } elseif ($this->status == "disabled") {
            return '<option value="disabled" selected>Inativo</option><option value="actived">Ativo</option><option value="writeoff">Baixa</option>';
        } else {
            return '<option value="writeoff" selected>Baixa</option><option value="actived">Ativo</option><option value="disabled">Inativo</option>';
        }
    }

    /**
     * @return string|null
     */
    public function photo(): ?string
    {
        if ($this->photo && file_exists(__DIR__ . "/../../" .CONF_UPLOAD_DIR. "/{$this->photo}")) {
            return $this->photo;
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

            if (!empty($this->part_number) && $this->find("product_id = :p AND part_number = :n AND id != :i", "p={$this->product_id}&n={$this->part_number}&i={$patrimonyId}", "id")->fetch()) {
                $this->message->warning("O patrimônio {$this->part_number} já está cadastrado");
                return false;
            }
            
            $this->update($this->safe(), "id = :id", "id={$patrimonyId}");
            
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Patrimony Create */
        if (empty($this->id)) {
            if (!empty($this->part_number) && $this->findByPartNumber($this->product_id, $this->part_number, "id")) {
                $this->message->warning("O patrimonio {$this->part_number} informado já está cadastrado");
                return false;
            }

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