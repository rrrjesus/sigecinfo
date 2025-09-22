<?php

namespace Source\Models\Company;

use Source\Core\Model;

/**
 * Class Church
 * @package Source\Models\Company
 */
class Church extends Model
{
    /**
     * Church constructor.
     */
    public function __construct()
    {
        $requiredFields = [
            "church_name", "country_id", "code_id", "zip_code",
            "address", "address_number", "city", "state"
        ];

        parent::__construct("churchs", ["id"], $requiredFields);
    }

    /**
     * @param string|null $code_id
     * @param string $columns
     * @return null|Church
     */
    public function findByCode(?string $code_id, string $columns = "*"): ?Church
    {
        if (empty($code_id)) {
            return null;
        }

        $find = $this->find("code_id = :code", "code={$code_id}", $columns);
        return $find->fetch();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        foreach ($this->required as $field) {
            if (empty($this->data->$field)) {
                $this->message->warning("Por favor, preencha todos os campos obrigatórios.");
                return false;
            }
        }

        $checkByName = $this->find("church_name = :name AND id != :id", "name={$this->church_name}&id={$this->id}");
        if ($checkByName->count()) {
            $this->message->warning("A igreja informada já está cadastrada no sistema.");
            return false;
        }

        if (!empty($this->code_id)) {
            $checkByCode = $this->find("code_id = :code AND id != :id", "code={$this->code_id}&id={$this->id}");
            if ($checkByCode->count()) {
                $this->message->warning("O código informado já está em uso por outra igreja.");
                return false;
            }
        }

        return parent::save();
    }
}