<div class="container-fluid mt-3">
    
    <div class="row mb-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary rounded-3">
            <li class="breadcrumb-item">
                <a class="link-body-emphasis fw-semibold text-decoration-none text-<?=CONF_APP_COLOR?>" href="<?=url("/beta")?>"><i class="bi bi-house-heart text-<?=CONF_APP_COLOR?>"></i> Início</a>
            </li>
            <?php
                if(isset($urls)){
                    echo breadcrumbApp($urls, $namepage, $name);
                }
            ?>
        
            </ol>
        </nav>
    </div>
</div>