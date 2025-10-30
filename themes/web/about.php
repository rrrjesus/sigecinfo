<?= $this->layout("_theme", ["head" => $head]); ?>

<div class="container p-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="pb-4 mb-4 border-bottom">
                Sobre o SIGECINFO
            </h2>

            <p class="fs-6">
                O <strong>SIGECINFO (Sistema de Gerenciamento e Controle de Informações)</strong> é uma aplicação web robusta, construída em <strong>PHP 8.2+</strong> com uma arquitetura <strong>MVC (Model-View-Controller)</strong>. O sistema foi projetado para oferecer uma solução completa para o gerenciamento e controle de pessoas, eventos e reuniões, fornecendo <strong>agilidade, segurança e centralização de dados</strong>.
            </p>
            <p>
                O projeto inclui uma <strong>API REST</strong> para integração com outras aplicações, como sistemas mobile, e utiliza as melhores práticas de desenvolvimento para garantir um código limpo, organizado e de fácil manutenção.
            </p>

            <hr class="my-5">

            <h3 class="pb-3 mb-3 border-bottom">
                Funcionalidades Principais
            </h3>
            <article class="blog-post">
                <p>O SIGECINFO oferece um conjunto de ferramentas para otimizar a gestão de eventos e informações:</p>
                <ul>
                    <li><strong>Gestão de Eventos:</strong> Cadastro e gerenciamento completo de eventos e reuniões.</li>
                    <li><strong>Controle de Acesso:</strong> Controle de portaria e acessos com identificação via QR Code.</li>
                    <li><strong>Relatórios Detalhados:</strong> Geração de relatórios de participantes, frequência e outros dados relevantes.</li>
                    <li><strong>Lista de Chamada:</strong> Funcionalidade de lista de chamada automática para eventos.</li>
                    <li><strong>API RESTful:</strong> Exposição de dados de forma segura para consumo por outras aplicações.</li>
                    <li><strong>Autenticação Social:</strong> Login com Google (OAuth 2.0).</li>
                    <li><strong>Envio de E-mails:</strong> Integração com PHPMailer e SendGrid para notificações.</li>
                </ul>
            </article>

            <hr class="my-5">

            <h3 class="pb-3 mb-3 border-bottom">
                Tecnologias Utilizadas
            </h3>
            <article class="blog-post">
                <p>O projeto foi construído com tecnologias modernas e bibliotecas consolidadas no mercado:</p>
                <ul>
                    <li><strong>Backend:</strong> PHP 8.2+, Arquitetura MVC, PDO</li>
                    <li><strong>Frontend:</strong> Bootstrap 5.3, JavaScript</li>
                    <li><strong>Roteamento:</strong> `coffeecode/router`</li>
                    <li><strong>Templates:</strong> `league/plates`</li>
                    <li><strong>Comunicação:</strong> `phpmailer/phpmailer`, `sendgrid/sendgrid`</li>
                    <li><strong>Autenticação:</strong> `league/oauth2-google`</li>
                    <li><strong>Mídia e Utilitários:</strong> `coffeecode/uploader`, `coffeecode/cropper`, `coffeecode/paginator`</li>
                </ul>
            </article>

            <hr class="my-5">

            <h3 class="pb-3 mb-3 border-bottom">
                Versões
            </h3>
            <article class="blog-post">
                <h4 class="blog-post-title">Versão 1.0.0 - Lançamento Inicial</h4>
                <p class="blog-post-meta">Lançado em Outubro de 2025</p>
                <p>A versão inicial do sistema, com todas as funcionalidades listadas acima.</p>
            </article>

            <article class="blog-post mt-4">
                <h4 class="blog-post-title">Próximas Versões</h4>
                <p>O desenvolvimento do SIGECINFO é contínuo. Para as próximas versões, estamos planejando:</p>
                <ul>
                    <li>Integração com aplicativos mobile (Android/iOS).</li>
                    <li>Módulos de comunicação interna (mensagens e notificações).</li>
                    <li>Dashboards personalizáveis com gráficos e estatísticas.</li>
                </ul>
            </article>

        </div>
    </div>
</div>

<?php if (!empty($faq)): ?>
    <section class="faq">
        <div class="faq_content content container">
            <header class="faq_header">
                <img class="title_image" title="Perguntas frequentes" alt="Perguntas frequentes"
                     src="<?= theme("/assets/images/faq-title.jpg"); ?>"/>
                <h3>Perguntas frequentes:</h3>
                <p>Confira as principais dúvidas e repostas sobre o Siegcinfo.</p>
            </header>
            <div class="faq_asks">
                <?php foreach ($faq as $question): ?>
                    <article class="faq_ask j_collapse">
                        <h4 class="j_collapse_icon icon-plus"><?= $question->question; ?></h4>
                        <div class="faq_ask_coll j_collapse_box"><?= $question->response; ?></div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>