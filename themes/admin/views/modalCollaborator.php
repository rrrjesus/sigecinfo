<?php

echo \Source\Support\Modal::render(
    "disableModal{$collaborator->id}",
    "Desativar Colaborador",
    "<p>Deseja desativar o colaborador: <b>{$collaborator->user_name}</b>?</p>",
    url("/painel/colaboradores/desativar/{$collaborator->id}"),
    "Sim"
);

echo \Source\Support\Modal::render(
    "trashModal{$collaborator->id}",
    "Ativar Colaborador",
    "<p>Deseja ativar o colaborador: <b>{$collaborator->user_name}</b>?</p>",
    url("/painel/colaboradores/excluir/{$collaborator->id}/delete"),
    "Sim"
);
