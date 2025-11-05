<?php

echo \Source\Support\Modal::render(
    "modalSair",
    "Sair do Sistema",
    "<p>Deseja sair do sistema?</p>",
    url("/painel/logoff"),
    "Sim"
);