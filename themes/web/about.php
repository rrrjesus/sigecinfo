<?= $this->layout("_theme", ["head" => $head]); ?>

<div class="row g-5 p-4">
    <div class="col-8">
        <h2 class="pb-4 mb-4 border-bottom">
            Versões do SIGECINFO
        </h2>
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