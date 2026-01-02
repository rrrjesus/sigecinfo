<div class="card h-100 shadow-sm">
    <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex align-items-start fw-semibold">
    <i class="bi bi-person-circle me-2"></i> O Seu Perfil
    </div>
<div class="card-body d-flex flex-column">
    <p class="card-text">Mantenha os seus dados de contacto e senha sempre atualizados.</p>
    <div class="mt-auto">
        <?= button([
            "href" => url("/app/perfil"),
            "name" => "Editar Perfil",
            "class" => "text-dark-emphasis",
            "icon" => "pencil-square me-1", // Corrigido para um ícone válido
            "btncolor" => "warning",
            "title" => "Acessar e editar seu perfil",
            "custom" => "custom-tooltip-secondary"
        ]); ?>
    </div>
</div>
</div>
