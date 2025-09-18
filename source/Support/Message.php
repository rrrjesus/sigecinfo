<?php

namespace Source\Support;

use Source\Core\Session;

/**
 * rrrrjesus | Class Message
 *
 * @author SIGECINFO Team <contato@sigecinfo.com.br>
 * @package Source\Core
 */
class Message
{
    /** @var string */
    private $text;

    /** @var string */
    private $type;

    /** @var string */
    private $after;

    /** @var string */
    private $before;

    /** @var string */
    private $icon;

    /** @return string */
    public function __toString()
    {
        return $this->render();
    }

    /** @return string */
    public function getText(): ?string
    {
        return $this->before.$this->text.$this->after;
    }

    /** @return string */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function before(string $text): Message
    {
        $this->before = $text;
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function after(string $text): Message
    {
        $this->after = $text;
        return $this;
    }

    public function icon(string $text = "exclamation-octagon"): Message
    {
        $this->icon = $text;
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function info(string $message): Message
    {
        $this->type = "info";
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function success(string $message): Message
    {
        $this->type = "success";
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function warning(string $message): Message
    {
        $this->type = "warning";
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function error(string $message): Message
    {
        $this->type = "danger";
        $this->text = $this->filter($message);
        return $this;
    }

    /** @return string */
    public function render(): string
    {
        return "<div class='bd-callout bd-callout-{$this->getType()} fade show text-center fw-semibold'>
                    <i class='bi bi-{$this->getIcon()} me-2'></i> {$this->getText()}
                </div>";
    }

    /** @return string */
    public function json(): string
    {
        return json_encode(["error" => $this->getText()]);
    }

    /**
     * Set flash Session Key
     */
    public function flash(): void
    {
        (new Session())->set("flash", $this);
    }

    /**
     * @param string $message
     * @return string
     */
    private function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_STRIPPED);
    }
}