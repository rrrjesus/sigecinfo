<?= $this->layout("_theme", ["head" => $head]); ?>

<!-- CARROUSSEL -->
    <div id="myCarousel" class="carousel slide mb-2 carousel-fade" data-bs-ride="carousel">
       <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" class="active" aria-label="Slide 2"></button>
        </div>

    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
            <img src="<?=theme(slide_month())?>" width="100%" height="100%">
            <!-- <div class="container">
                <div class="carousel-caption" style="text-shadow: 0.1em 0.1em 0.2em #063cee">
                    <h1>Service Desk COTI.</h1>
                    <p>As vantagens e agilidade que o serviço de suporte traz para seu dia dia na SIGECINFO.</p>
                    <p><a class="btn btn-lg btn-<?=color_month();?> text-light" href="<?=url("/contatos")?>" data-bs-togglee="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="Clique para acessar os Contatos">Agenda de Contatos</a></p>
                </div>
            </div> -->
        </div>
        <div class="carousel-item" data-bs-interval="20000">
            <img src="<?=theme("/assets/images/jira.jpg")?>" width="100%" height="100%">
            <!-- <div class="container">
                <div class="carousel-caption" style="text-shadow: 0.05em 0.05em 0.1em #06b8ee">
                    <h1 class="text-dark">Gerador de Assinatura de E-mail.</h1>
                    <p class="text-dark">Mais uma ferramenta para facilitar seu dia a dia , basta preencher seus dados e gerar sua assinatura de e-mail na hora.</p>
                    <p>
                        <a class="btn btn-lg btn-<?=color_month();?> text-light me-5" href="<?=url("/contatos")?>" data-bs-togglee="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="Clique para acessar os Contatos"><i class="bi bi-book-half me-2"></i>Agenda de Contatos</a>
                        <a class="btn btn-lg btn-<?=color_month();?> text-light" href="<?=url("/email")?>" data-bs-togglee="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="Clique para acessar o Gerador de Assinatura de E-mail"><i class="bi bi-card-heading me-2"></i>Assinatura de E-mail</a></p>
                </div>
            </div> -->
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>

    <!-- CARDS -->
    <div class="container px-4 py-5" id="featured-3">
        <h2 class="pb-2 border-bottom">Os 3 pilares do Suporte de TI na S</h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="feature col">
                <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-success bg-gradient fs-2 mb-3">
                    <i class="bi bi-wrench-adjustable-circle mb-3"></i>
                </div>
                <h3 class="fs-2 text-body-emphasis">Abertura de Chamado - TI</h3>
                <p>Para solicitação de suporte técnico é necessário a abertura de chamado no.
                    Basta enviar e-mail para <strong>informatica.setor11@gmail.com</strong>. Ao enviar o e-mail o sistema abre automaticamente um chamado. É possivel acompanhar as tratativas nas respostas de e-mail.</p>
                <!-- <a href="<?=url("/blog/servicedesk")?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-placement="bottom" 
                    data-bs-title="Saiba Mais">Saiba Mais</a> -->
            </div>
            <div class="feature col">
                <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-warning bg-gradient fs-2 mb-3">
                    <i class="bi bi-envelope-at mb-3 text-light"></i>
                </div>
                <h3 class="fs-2 text-body-emphasis">E-mail TI do Setor 11</h3>
                <p>Existe um e-mail de contato para <strong>Informática do Setor 11</strong> caso necessário : <a class="text-decoration-none fw-bold" href="mailto:<?=CONF_SITE_EMAIL?>"><?=CONF_SITE_EMAIL?></a>,
                    os chamados de suporte técnico também devem ser realizados através do envio de e-mail para que sejam devidamente tratados e solucionados.</p>
                    <!-- <a href="<?=url("/#")?>" class="btn btn-primary">Saiba Mais</a> -->
            </div>
            <div class="feature col">
                <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-danger bg-gradient fs-2 mb-3">
                    <i class="bi bi-telephone-forward mb-3 text-light"></i>
                </div>
                <h3 class="fs-2 text-body-emphasis">Telefones de Contato</h3>
                <p>Por fim e não menos importante, os telefones de atendimento da <strong>Informática do Setor 11</strong> na
                    <a href="<?=url("/contatos")?>" class="text-decoration-none fw-bold">agenda</a> da <strong>Informática do Setor 11</strong>. É só acessar e pesquisar na agenda por
                    <strong>COTI</strong> e aparecerão os telefones de contato com os nomes dos colaboradores que atenderão os mesmos.</p>
                <!--                <a href="--><?php //=url("/blog/ramais-coti")?><!--" class="btn btn-primary">Saiba Mais</a>-->
            </div>
        </div>
    </div>