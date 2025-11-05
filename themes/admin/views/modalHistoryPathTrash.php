<?php

echo \Source\Support\Modal::render(
    "pathtrashModal{$user->id}",
    "Ativar Usuário",
    "<p>Deseja ativar o usuário: <b>{$user->user_name}</b>?</p>",
    url("/painel/usuarios/excluir/{$user->id}/delete"),
    "Sim"
);
