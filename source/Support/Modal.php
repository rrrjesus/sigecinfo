<?php

namespace Source\Support;

class Modal
{
    /**
     * Gera o HTML estático para um modal do Bootstrap.
     * @return string
     */
    public static function render(string $id, string $title, string $body, string $confirmUrl, string $confirmText = 'Sim'): string
    {
        return <<<HTML
            <div class="modal fade" id="{$id}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{$title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {$body}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a href="{$confirmUrl}" class="btn btn-danger">{$confirmText}</a>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }
}