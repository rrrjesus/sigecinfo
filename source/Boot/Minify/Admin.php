<?php
if (strpos(url(), "localhost")) {
    /**
     * CSS
     */
    $minAdminCSS = new MatthiasMullie\Minify\CSS();
    $minAdminCSS->add(__DIR__ . "/../../../shared/styles/boot.css");
    $minAdminCSS->add(__DIR__ . "/../../../shared/styles/bootstrap.min.css");
    $minAdminCSS->add(__DIR__ . "/../../../shared/styles/docs.min.css");
    $minAdminCSS->add(__DIR__ . "/../../../shared/styles/datatables/dataTables.bootstrap5.css");
    $minAdminCSS->add(__DIR__ . "/../../../shared/styles/datatables/buttons.bootstrap5.min.css");
    $minAdminCSS->add(__DIR__ . "/../../../shared/styles/datatables/responsive.bootstrap5.min.css");
    $minAdminCSS->add(__DIR__ . "/../../../shared/styles/bootstrap-icons.min.css");
    $minAdminCSS->add(__DIR__ . "/../../../shared/styles/typeahead.css");

    //theme CSS
    $cssDir = scandir(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/assets/css");
    foreach ($cssDir as $css) {
        $cssFile = __DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/assets/css/{$css}";
        if (is_file($cssFile) && pathinfo($cssFile)['extension'] == "css") {
            $minAdminCSS->add($cssFile);
        }
    }

    //Minify CSS
    $minAdminCSS->minify(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/assets/style.css");

    /**
     * JS
     */
    $minAdminJS = new MatthiasMullie\Minify\JS();
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/bootstrap/bootstrap.bundle.min.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/bootstrap/color-modes.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery.min.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery.form.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery-ui.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery.mask.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/jquery/jquery.validate.min.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/typeahead.bundle.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/dataTables.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/dataTables.bootstrap5.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/jszip.min.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/dataTables.buttons.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/buttons.bootstrap5.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/vfs_fonts.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/buttons.html5.min.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/buttons.print.min.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/buttons.colVis.min.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/dataTables.responsive.js");
    $minAdminJS->add(__DIR__ . "/../../../shared/scripts/datatables/responsive.bootstrap5.js");

    //theme CSS
    $jsDir = scandir(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/assets/js");
    foreach ($jsDir as $js) {
        $jsFile = __DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/assets/js/{$js}";
        if (is_file($jsFile) && pathinfo($jsFile)['extension'] == "js") {
            $minAdminJS->add($jsFile);
        }
    }

    //Minify JS
    $minAdminJS->minify(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/assets/scripts.js");
}