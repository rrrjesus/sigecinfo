<?php

namespace Source\Support;

class Modal
{
    /**
     * Gera o HTML estático para um modal do Bootstrap.
     * @return string
     */
    public static function render(string $id, string $title, string $body, string $confirmUrl, string $confirmText = 'Sim', string $headerClass = 'bg-secondary text-white'): string
    {
        return <<<HTML
            <div class="modal fade" id="{$id}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header {$headerClass}">
                            <h5 class="modal-title">{$title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body fw-semibold text-center">
                            {$body}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
                            <a href="{$confirmUrl}" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-check-circle"></i> {$confirmText}</a>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    /**
     * Gera o HTML para um modal com um formulário.
     * @return string
     */
    public static function renderForm(string $id, string $title, string $formAction, string $formContent, string $submitText = 'Enviar'): string
    {
        return <<<HTML
            <div class="modal fade" id="{$id}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{$formAction}" method="post">
                        <div class="modal-content">
                            <div class="modal-header bg-secondary text-white">
                                <h5 class="modal-title">{$title}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body fw-semibold text-center">
                                {$formContent}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
                                <button type="submit" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-check-circle"></i> {$submitText}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        HTML;
    }

    /**
     * Gera o HTML para um modal que exibe uma imagem.
     * @return string
     */
    public static function renderImage(string $id, string $title, string $imageUrl, string $altText): string
    {
        return <<<HTML
            <div class="modal fade" id="{$id}" tabindex="-1" aria-labelledby="{$id}Label" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="{$id}Label">{$title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body fw-semibold text-center">
                    <img src="{$imageUrl}" class="img-fluid" alt="{$altText}">
                  </div>
                </div>
              </div>
            </div>
        HTML;
    }
}