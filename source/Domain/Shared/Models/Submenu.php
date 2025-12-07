<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

/**
 * Class Submenu
 *
 * @package Source\Domain\Models
 * @package Source\Models
 */
class Submenu extends Model
{
    /**
     * Submenu constructor.
     */
    public function __construct()
    {
        parent::__construct("submenus", ["id", "created_at", "updated_at"], ["menu_id", "name", "url"]);
    }

    /**
     * @return Menu|null
     */
    public function menu(): ?Menu
    {
        if ($this->menu_id) {
            return (new Menu())->findById($this->menu_id);
        }
        return null;
    }

    /**
     * @return Submenu|null
     */
    public function parent(): ?Submenu
    {
        if ($this->parent_id) {
            return (new Submenu())->findById($this->parent_id);
        }
        return null;
    }

    /**
     * @return array|null
     */
    public function children(): ?array
    {
        return (new Submenu())->find("parent_id = :parent_id", "parent_id={$this->id}")->order("submenu_order ASC")->fetch(true);
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        if (empty($this->children())) {
            return false;
        }
        return true;
    }
}
