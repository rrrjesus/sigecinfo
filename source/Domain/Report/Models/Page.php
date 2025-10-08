<?php

namespace Source\Domain\Report\Models;

use Source\Core\Model;

/**
 * Class Page
 * @package Source\Domain\Report\Models
 */
class Page extends Model
{
    /**
     * Page constructor.
     */
    public function __construct()
    {
        parent::__construct("report_pages", ["id"], ["url"]);
    }

    /**
     * @param string $url
     * @return Page
     */
    public function report(string $url): Page
    {
        $find = $this->find("url = :url", "url={$url}")->fetch();

        if (!$find) {
            $this->url = $url;
            $this->accesses = 1;
            $this->save();
            return $this;
        }

        $find->accesses += 1;
        $find->save();

        return $find;
    }
}
