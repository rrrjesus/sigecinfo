<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

/**
 * Class Menu
 *
 * @package Source\Domain\Models
 * @package Source\Models
 */
class Menu extends Model
{
    /**
     * Menu constructor.
     */
    public function __construct()
    {
        parent::__construct("menus", ["id", "created_at", "updated_at"], ["name"]);
    }

    /**
     * @return array|null
     */
    public function submenus(): ?array
    {
        return (new Submenu())->find("menu_id = :menu_id", "menu_id={$this->id}")->order("submenu_order ASC")->fetch(true);
    }

    /**
     * @return bool
     */
    public function hasSubmenus(): bool
    {
        if (empty($this->submenus())) {
            return false;
        }

        return true;
    }
}