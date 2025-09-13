<?= $this->layout("_theme", ["head" => $head]); ?>

<div class="row g-5 p-4">
    <div class="col-8">
        <h2 class="pb-4 mb-4 border-bottom">
            Versões da Agenda de Contatos SIGECINFO
        </h2>

        <article class="blog-post">
            <h2 class="blog-post-title" id="agendav1">Agenda na versão 1.0</h2>
            <p class="fs-6">Por <a href="https://github.com/rrrjesus/sigecinfo" class="text-decoration-none fw-semibold text-<?=color_month();?>"><i class="bi bi-github"></i> rrrjesus</a> em 19/09/2023</p>
            <p class="fw-medium">A agenda de contatos SIGECINFO na versão 1.0 veio para iniciar o processo de inovação na área de desenvolvimento web.</p>
            <img class="img-fluid" src="<?=theme("/assets/images/agendav1.jpg")?>">
            <p class="mt-3">Para facilitar o acesso dos servidores de SIGECINFO a lista de ramais, a agenda de contatos foi desenvolvida em ambiente web, utilizando
                linguagens como <strong>PHP</strong>, <strong>javascript</strong> e <strong>msqly</strong>. O projeto conta com tabela de setores e contatos com ramais,
                no primeiro campo da lista o usuário seleciona um filtro por <strong>Setor</strong> e de maneira dinâmica os contatos do setor selecionado são filtrados, em seguida
                é possível digitar no campo <strong>Nome</strong> os caracteres que criam um filtro na lista selecionada, facilitando assim a busca.
            </p>
            <p>As vantagens com os filtros de campo ajudaram a encontrar os ramais, porém a obrigatoriedade de um filtro inicial por <strong>Setor</strong> trouxe certa dificuldade
                a alguns servidores, as vezes se busca um nome de contato e não se tem o Setor ao qual o contato faz parte, isso dificulta no processo de seleção do primeiro
                filtro. A primeira versão da agenda de contatos foi desenvolvida por <strong>Julio N. Sales</strong> e foi utilizada durante aproximadamente 4 anos.</p>
            <hr>

            <h2 class="blog-post-title" id="agendav2">Agenda na versão 2.0</h2>
            <p class="fs-6">Por <a href="https://github.com/rrrjesus/sigecinfo" class="text-decoration-none fw-semibold text-<?=color_month();?>"><i class="bi bi-github"></i> rrrjesus</a> em 19/09/2023</p>
            <p class="fw-medium">A versão 2.0 veio trazendo o plugin jquery Datatables, o PHP orientado a objetos e uma CSS customizada.</p>
            <img class="img-fluid" src="<?=theme("/assets/images/agendav2.jpg")?>">
            <p class="mt-2">Surge então o projeto <strong>Agenda 2.0</strong> com a proposta de um filtro de contatos mais dinâmico, um layout mais limpo e intuitivo e ferramentas de
                código aberto para facilitar o uso da agenda. A estrutura foi construída em <a class="text-decoration-none text-<?=color_month();?> fw-semibold" target="_blank"
                href="https://www.php.net/manual/pt_BR/language.oop5.php">PHP POO</a> segundo as <a class="text-decoration-none text-<?=color_month();?> fw-medium"
                href="https://www.php-fig.org/psr/" target="_blank"> PSRs</a> da linguagem e a estrutura no <strong>Padrão MVC</strong> (Model-View-Controller), o MVC é utilizado em muitos projetos
                devido a arquitetura que possui, o que possibilita a divisão do projeto em camadas muito bem definidas. Cada uma delas, o Model, o Controller e a View,
                executa o que lhe é definido e nada mais do que isso.</p>
            <p>Na estrutura do projeto com a força da linguagem PHP POO estão alguns dos melhores recursos, pacotes e práticas no desenvolvimento usando a linguagem,
                entre eles :</p>
            <ul>
                <li>Composer PHP</li>
                <li>Packagist PHP</li>
                <li>PHP-FIG</li>
            </ul>
            <hr>
            <p class="fw-medium">Datatables Jquery e seus recursos de paginação, pesquisa instantânea e ordenação de colunas.</p>
            <img class="img-fluid" src="<?=theme("/assets/images/datatables.jpg")?>">
            <p class="mt-2">Além disso o plugin <a class="text-decoration-none text-<?=color_month();?> fw-semibold" target="_blank" href="https://datatables.net/">Jquery Datatables</a>
                trouxe a lista de contatos recursos poderosos da linguagem Javascript e sua biblioteca <a class="text-decoration-none text-<?=color_month();?> fw-semibold" target="_blank" href="https://pt.wikipedia.org/wiki/JQuery">
                Jquery</a>, o filtro de buscas ficou dinâmico e qualquer caractere ou palavra digitada faz uma busca precisa, além disso a paginação ajuda a percorrer a lista com apenas
                alguns cliques. No cabeçalho de cada campo da lista é possível com um clique ordenar a coluna, também é possível definir a quantidade de linhas a serem exibidas selecionando a opção de
                <strong>Resultados por página</strong>.
            </p>

            <hr>
            <h2 class="blog-post-title">Agenda na versão 2.1</h2>
            <p class="fs-6">Por <a href="https://github.com/rrrjesus/sigecinfo" class="text-decoration-none fw-semibold text-<?=color_month();?>"><i class="bi bi-github"></i> rrrjesus</a> em 19/09/2023</p>
            <p class="fw-medium">A versão 2.1 veio trazendo o kit de ferramentas de front-end Bootstrap 5.3 e o tema escuro</p>
            <img class="img-fluid" src="<?=theme("/assets/images/dark_mode_agenda.jpg")?>">


            <p class="mt-2" >Na <strong>Agenda 2.1</strong> o foco é no front-end responsivo, para isso o kit de ferramentas repleto de recursos <a class="text-decoration-none text-<?=color_month();?> fw-semibold"
                href="https://blog.getbootstrap.com/" target="_blank">Bootstrap 5.3</a> foi utilizado. Bootstrap é um framework web com código-fonte aberto para
                desenvolvimento de componentes de interface e front-end para sites e aplicações web, usando HTML, CSS e JavaScript, baseado em modelos de design
                para a tipografia, melhorando a experiência do usuário em um site amigável e responsivo.</p>
            <p>A nova versão traz recursos que facilitam a experiência visual e paupável do usuário, permitindo o acesso do sistema seus diversos aparelhos e tamanhos
                de tela de forma renderizando as páginas de acordo com o tamanho da tela.</p>
            <img class="img-fluid" src="<?=theme("/assets/images/modo.jpg")?>">
            <hr>
            <p class="mt-2">O tema pode ser selecionado no modo <span class="badge text-bg-light">Claro</span>, <span class="badge text-bg-dark">Escuro</span> e auto, no menu superior com um clique, o sistema muda a <a class="text-decoration-none text-<?=color_month();?> fw-semibold" target="_blank"
                    href="https://getbootstrap.com/docs/5.3/customize/color-modes/">cor do tema</a> e as cores se adaptam ao tema escolhido. </p>

            <img class="img-fluid" src="<?=theme("/assets/images/icons.jpg")?>">
            <hr>
            <p>Os icones também foram adicionados para facilitar o acesso, diversos deles estão espalhados por toda a agenda.</p>
        </article>
    </div>

    <div class="col-4">
      <div class="position-sticky" style="top: 2rem;">
      <div class="p-4 mb-3 text-bg-<?=color_month();?> text-light rounded">
            <h4 class="fst-italic">Sobre</h4>
            <p class="mb-0">A <strong>Agenda de Contatos SIGECINFO</strong> é desenvolvida por servidores de SIGECINFO de forma
                voluntária e gratuita. O objetivo é inovar para facilitar os processos e demandas de trabalho.</p>
        </div>

        <div class="p-4">
            <h4 class="fst-italic">Versões da Agenda</h4>
            <ol class="list-unstyled mb-0">
                <li><i class="bi bi-book-half me-2 fs-5 text-<?=color_month();?>"></i><a class="text-decoration-none text-<?=color_month();?> fw-semibold"
                    href="#agendav1">Agenda 1.0 - Janeiro de 2019</a></li>
                <li><i class="bi bi-book-half me-2 fs-5 text-<?=color_month();?>"></i><a class="text-decoration-none text-<?=color_month();?> fw-semibold"
                    href="#agendav2">Agenda 2.0 - Agosto de 2023</a></li>
                <li><i class="bi bi-book-half me-2 fs-5 text-<?=color_month();?>"></i><a class="text-decoration-none text-<?=color_month();?> fw-semibold"
                    href="<?=url("/contatos")?>">Agenda 2.1 - Versão Atual</a></li>

            </ol>
        </div>

        <div class="p-4">
            <h4 class="fst-italic">Redes Socias SIGECINFO</h4>
            <ol class="list-unstyled">
                <li class="mb-2"><a target="_blank" class="text-decoration-none text-<?=color_month();?> fw-bold"
                                    href="https://www.facebook.com/<?= CONF_SOCIAL_FACEBOOK_PAGE; ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="<?=CONF_SITE_NAME?> no Facebook"><i class="bi bi-facebook"></i> /SIGECINFO</a></li>
                <li class="mb-2"><a target="_blank" class="text-decoration-none text-<?=color_month();?> fw-bold"
                                    href="https://www.instagram.com/<?= CONF_SOCIAL_INSTAGRAM_PAGE; ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="<?=CONF_SITE_NAME?> no Instagram"><i class="bi bi-instagram"></i> @SIGECINFO</a></li>
                <li class="mb-2"><a target="_blank" class="text-decoration-none text-<?=color_month();?> fw-bold" href="https://www.youtube.com/<?= CONF_SOCIAL_YOUTUBE_PAGE; ?>"
                                    data-bs-toggle="tooltip" data-bs-placement="left" title="<?=CONF_SITE_NAME?> no YouTube"><i class="bi bi-youtube"></i> /SIGECINFO</a></li>

            </ol>
        </div>
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