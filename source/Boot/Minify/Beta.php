<?php
if (strpos(url(), "localhost")) {
    /**
     * CSS
     */
    $minCSS = new MatthiasMullie\Minify\CSS();
    $minCSS->add(__DIR__ . "/../../../shared/styles/boot.css");
    $minCSS->add(__DIR__ . "/../../../shared/styles/bootstrap.min.css");
    $minCSS->add(__DIR__ . "/../../../shared/styles/docs.min.css");
    $minCSS->add(__DIR__ . "/../../../shared/styles/datatables/dataTables.bootstrap5.css");
    $minCSS->add(__DIR__ . "/../../../shared/styles/datatables/buttons.bootstrap5.min.css");
    $minCSS->add(__DIR__ . "/../../../shared/styles/datatables/responsive.bootstrap5.min.css");
    $minCSS->add(__DIR__ . "/../../../shared/styles/bootstrap-icons.min.css");
    $minCSS->add(__DIR__ . "/../../../shared/styles/typeahead.css");

    //theme CSS
    $cssDir = scandir(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/assets/css");
    foreach ($cssDir as $css) {
        $cssFile = __DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/assets/css/{$css}";
        if (is_file($cssFile) && pathinfo($cssFile)['extension'] == "css") {
            $minCSS->add($cssFile);
        }
    }

    //Minify CSS
    $minCSS->minify(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/assets/style.css");

    /**
     * JS
     */
    $minJS = new MatthiasMullie\Minify\JS();
    $minJS->add(__DIR__ . "/../../../shared/scripts/bootstrap/bootstrap.bundle.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/bootstrap/color-modes.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery.form.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery-ui.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery.mask.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery.validate.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/typeahead.bundle.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/dataTables.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/dataTables.bootstrap5.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/dataTables.buttons.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/buttons.bootstrap5.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/jszip.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/vfs_fonts.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/buttons.html5.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/buttons.print.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/buttons.colVis.min.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/dataTables.responsive.js");
    $minJS->add(__DIR__ . "/../../../shared/scripts/datatables/responsive.bootstrap5.js");

    //theme CSS
    $jsDir = scandir(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/assets/js");
    foreach ($jsDir as $js) {
        $jsFile = __DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/assets/js/{$js}";
        if (is_file($jsFile) && pathinfo($jsFile)['extension'] == "js") {
            $minJS->add($jsFile);
        }
    }

    //Minify JS
    $minJS->minify(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/assets/scripts.js");
}