$(function () {
    BASE = $("link[rel='base']").attr("href");
    BETA = $("link[rel='base']").attr("title");
    FILE = BASE + "/_app/dash.php";

    /*
     * LOAD DASH_VIEWS
     */
    $(window).on("load", function () {
        $(".dash_view").fadeIn();
    });

    $("*[data-fadeIn]").click(function () {
        $($(this).attr("data-fadeIn")).fadeIn();
    });

    $("*[data-fadeInFlex]").click(function () {
        $($(this).attr("data-fadeInFlex")).fadeIn().css("display", "flex");
    });

    $("*[data-fadeOut]").click(function () {
        $($(this).attr("data-fadeOut")).fadeOut();
    });

    $("*[data-slideToggle]").click(function () {
        $($(this).attr("data-slideToggle")).slideToggle();
        $(this).toggleClass("icon-cancel-circle icon-circle-down");
    });

    $("*[data-fadeToggle]").click(function () {
        $($(this).attr("data-fadeToggle")).fadeToggle();
        $(this).toggleClass("icon-cancel-circle icon-circle-down");
    });

    $("[data-overOut]").click(function (e) {
        if (e.target == this) {
            $(this).fadeOut();
        }
    });

    //POST IMAGE RESET
    $(".htmlcontent p:has(img), .htmlcontent p:has(iframe)").css({"padding": "30px 0"});

    //############## GET CEP
    $('*[data-getCep]').change(function () {
        var input = $(this);
        var form = $(this).parents("form");
        var zipcode = input.val().replace('-', '').replace('.', '');
        if (zipcode.length === 8) {
            $.get("https://viacep.com.br/ws/" + zipcode + "/json", function (data) {
                if (!data.erro) {
                    input.val(zipcode.substring(0, 5) + "-" + zipcode.substring(5));
                    form.find("input[name='street']").val(data.logradouro);
                    form.find("input[name='complement']").val(data.complemento);
                    form.find("input[name='district']").val(data.bairro);
                    form.find("input[name='city']").val(data.localidade);
                    form.find("input[name='state']").val(data.uf);
                    form.find("input[name='country']").val("Brasil");
                }
            }, 'json');
        }
    });

    /*
     * USER DOCUMENT VALIDATE
     */
    $('form[name="user_document"]').submit(function (event) {
        event.preventDefault();

        $(this).ajaxSubmit({
            url: FILE,
            data: {case: "user_document"},
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $("<div class='upload_modal'><div class='upload_modal_box'></div></div>").prependTo("body");
            },
            uploadProgress: function (evento, posicao, total, completo) {
                var porcento = completo + '%';
                $('.upload_modal_box').text(porcento);

                if (completo <= '90') {
                    $('.upload_modal').fadeIn().css('display', 'flex');
                }
            },
            success: function (data) {
                if (data.trigger) {
                    $('.upload_modal').fadeOut(400, function () {
                        $(this).remove();
                    });

                    trigger(data.trigger);
                }

                //LOCATION USER
                if (data.location) {
                    window.location.href = data.location;
                    if (data.location === window.location.href) {
                        window.location.reload();
                    }
                }

                //RELOAD NOW
                if (data.reload) {
                    window.location.reload();
                }
            },
            error: function () {
                $('.upload_modal').fadeOut(400, function () {
                    $(this).remove();
                });

                triggerModal({
                    "color": "red",
                    "icon": "sad",
                    "title": "Ooops, seu JPG parece não ser um JPG :/",
                    "message": "Os arquivos de documento que você enviou não podem ser lidos como JPG em nosso servidor. <b>Você usou algum conversor ou alterou a extensão dele?</b> <p><b>COMO RESOLVER:</b> Use um conversor online ou abra os arquivos e tire uma PRINT deles para ter um JPG válido.</p><p><b>NÃO CONSEGUIU?</b> Entre em contato com nossa equipe que te ajudamos com isso, combinado?</p>",
                    "location": true
                });
            }
        });
    });

    /*
     * UPLOAD PHOTO USER
     */
    $('.user_thumb_avatar').change(function () {
        var form = $(this).parents("form");
        var target = $(".dash_profile_section_content_photo_img img, .dash_nav_header_thumb");
        form.ajaxSubmit({
            url: FILE,
            data: {case: "user_profile_thumb"},
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                target.fadeTo(400, 0.1);
                $("<div class='upload_modal'><div class='upload_modal_box'></div></div>").prependTo("body");
            },
            uploadProgress: function (evento, posicao, total, completo) {
                var porcento = completo + '%';
                $('.upload_modal_box').text(porcento);

                if (completo <= '90') {
                    $('.upload_modal').fadeIn().css('display', 'flex');
                }
                //PREVENT TO RESUBMIT
                form.trigger("reset");
            },
            success: function (data) {
                if (data.trigger) {
                    trigger(data.trigger);
                    return false;
                }

                if (data.thumb) {
                    $('.upload_modal').fadeOut('slow', function () {
                        $('.upload_modal').remove();
                    });
                    target.attr('src', data.thumb).fadeTo(800, 1);
                }
            }
        });
    });

    /*
     * NOTIFY CONTROL
     */
    $(".dash_notificator_list").click(function () {
        if (!$(".dash_notificator").length) {
            $.post(FILE, {case: 'dash_notificator', notsleep: true}, function (data) {
                if (data.trigger) {
                    trigger(data.trigger);
                }

                if (data.notify) {
                    $("body").css("overflow", "hidden").prepend("<div class='dash_notificator'><div class='dash_notificator_box'>" + data.notify + "</div></div>");
                    $(".dash_notificator").animate({"right": "0"}, 200);
                    $(".dash_notificator_list").find("b").fadeOut(100, function () {
                        $(this).remove();
                    });

                    $(".dash_notificator_box_notify").one('click', function () {
                        $(this).fadeTo(200, 0.1, function () {
                            $.post(FILE, {
                                case: 'dash_notificator_click',
                                notify_id: $(this).attr("data-notify"),
                                notsleep: true
                            }, function (data) {
                                if (data.trigger) {
                                    trigger(data.trigger);
                                }

                                if (data.location) {
                                    window.location.href = data.location;
                                    if (data.location === window.location.href) {
                                        window.location.reload();
                                    }
                                }
                            }, 'json');
                        }).css("cursor", "default");
                    });
                }

                //REMOVE
                $("body").click(function (e) {
                    if ($(e.target).attr("class").search("dash_notificator")) {
                        $(".dash_notificator").animate({"right": "-300px"}, 200, function () {
                            $(this).remove();
                            $("body").css("overflow", "auto");
                        });
                    }
                });
            }, 'json');
        }
    });

    /*
     * HIGHLIGHT
     */
    if ($('*[class="brush: php;"]').length) {
        $("head").append('<link rel="stylesheet" href="' + BASE + '/_cdn/highlight.min.css">');
        $.getScript(BASE + '/_cdn/highlight.min.js', function () {
            $('*[class="brush: php;"]').each(function (i, block) {
                hljs.highlightBlock(block);
            });
        });
    }

    /*
     * IMAGE LOAD ERRO
     */
    $("img").error(function () {
        if ($(this).attr("src").search("tim.php") >= 1) {
            var get_url_replace = $(this).attr("src").split("&");
            $(this).attr("src", BASE + "/../tim.php?src=" + BETA + "/_img/no_image.jpg&w=" + get_url_replace[1].replace("w=", "") + "&h=" + get_url_replace[2].replace("h=", ""));
        } else {
            $(this).attr("src", BASE + "/_img/no_image.jpg");
        }
    });

    /*
     * MENU MOBILE
     */
    $(".dash_main_header_menu").click(function () {
        if ($(".dash_nav").css("margin-left") === '-240px') {
            $(".dash_nav").animate({"margin-left": "0"}, 100).removeClass("dash_nav_hide_menu");
        } else {
            $(".dash_nav").animate({"margin-left": "-240px"}, 100).addClass("dash_nav_hide_menu");
        }
    });

    /*
     * CLASS MENU
     */
    if ($(".dash_view_class").length) {
        $(window).scroll(function () {
            if ($(window).scrollTop() > $(".dash_view_class_media").next().offset().top + 500 && !$(".dash_view_class_media_tools_suspense").length) {
                $(".dash_view_class").append("<div class='dash_view_class_media_tools_suspense'><div class='dash_view_class_media_tools'>" + $(".dash_view_class_media_tools").html() + "</div></div>");
                $(".dash_view_class_media_tools_suspense").animate({"opacity": "1"}, 200);
            } else if ($(window).scrollTop() < $(".dash_view_class_media").next().offset().top && $(".dash_view_class_media_tools_suspense").length) {
                $(".dash_view_class_media_tools_suspense").animate({"opacity": "0"}, 200, function () {
                    $(this).remove();
                });
            }
        });
    }

    /*
     * TIMER VALIDATION
     */
    if ($(".dash_nav").length) {
        var dash = setInterval(function () {
            $.post(FILE, {case: "dash"}, function (data) {
                //REAL TIME ERROR
                if (data.trigger) {
                    trigger(data.trigger);
                }

                //STOP INTERVAL
                if (data.stop) {
                    clearInterval(dash);
                }

                //REAL TIME NOTIFY
                if (data.notify) {
                    if (!$(".dash_notificator_list b").length) {
                        $(".dash_notificator_list").html("<b style='display: none;'>" + data.notify + "</b>").find("b").fadeIn(100);
                    } else {
                        $(".dash_notificator_list b").html(data.notify);
                    }
                } else if ($(".dash_notificator_list b").length) {
                    $(".dash_notificator_list").find("b").remove();
                }

                //LOCATION USER
                if (data.location) {
                    window.location.href = data.location;
                    if (data.location === window.location.href) {
                        window.location.reload();
                    }
                }
            }, "json");
        }, 1000 * 10);
    }

    $('body').on('click', '.check_module', function (event) {
        event.preventDefault();

        var value = $(this).data('value');

        $.post(FILE, {
            case: 'check_module',
            value: value
        }, function (data) {

            if (data.success === true) {
                $('h3.dash_view_course_module_class_row.title.icon-checkbox-unchecked[data-mod=' + value + ']').removeClass('icon-checkbox-unchecked').addClass('icon-checkbox-checked');
            }

            //REAL TIME ERROR
            if (data.trigger) {
                trigger(data.trigger);
            }
        }, "json");
    });

    $('body').on('click', '.uncheck_module', function (event) {
        event.preventDefault();

        var value = $(this).data('value');

        $.post(FILE, {
            case: 'uncheck_module',
            value: value
        }, function (data) {

            if (data.success === true) {
                $('h3.dash_view_course_module_class_row.title.icon-checkbox-checked[data-mod=' + value + ']').removeClass('icon-checkbox-checked').addClass('icon-checkbox-unchecked');
            }

            //REAL TIME ERROR
            if (data.trigger) {
                trigger(data.trigger);
            }
        }, "json");
    });

    /*
     * DATA ACTION CLICK
     */
    $("body").on('click', '*[data-action]', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var button = $(this);
        var dash = button.attr("data-action");
        var value = button.attr("data-value");
        var plan_id = button.attr("data-plan");
        var course_id = button.attr("data-course");
        var student_class = button.attr("data-class");

        $.post(FILE, {
            case: dash,
            value: value,
            plan_id: plan_id,
            course_id: course_id,
            student_class: student_class
        }, function (data) {
            //REAL TIME ERROR
            if (data.trigger) {
                trigger(data.trigger);
            }

            //TOOTLE CLASS
            if (data.tootleClass) {
                button.toggleClass(data.tootleClass);
            }

            //CHECKOUT
            if (data.checkout) {
                dashCheckout(data);
            }

            //CLASS CHECK
            if (data.classfree) {
                studentClassFree(data);
            }

            //CLASS REVIEW
            if (data.classreview) {
                $(".dash_view_class_support_ticket_review").animate({"opacity": 0}, 400, function () {
                    $(this).html(data.classreview).animate({"opacity": 1}, 400);
                });
            }

            //DATA TEXT ON CLASS
            if (data.htmltext) {
                $(data.htmltext[0]).html(data.htmltext[1]);
            }

            //STOP INTERVAL
            if (data.stop) {
                clearInterval(dash);
            }

            //RELOAD NOW
            if (data.reload) {
                window.location.reload();
            }

            //LOCATION NOW
            if (data.location) {
                window.location.href = data.location;
                if (data.location === window.location.href) {
                    window.location.reload();
                }
            }
        }, "json");
    });

    /*
     * FORM SUBMIT
     */
    $("body").on("submit", "form:not(.ajax_off)", function (e) {
        e.preventDefault();

        //TINYMCE SAVE CONTENT
        if (typeof tinyMCE !== 'undefined') {
            tinyMCE.triggerSave();
        }

        var form = $(this);
        var form_data = $(this).serialize() + "&case=" + form.attr("action");
        var form_button = ($("button[form='" + form.attr("id") + "']").length ? $("button[form='" + form.attr("id") + "']") : $(form.find("button:last")));
        var form_button_text = form_button.html();

        $.ajax({
            url: FILE,
            data: form_data,
            dataType: 'json',
            type: 'POST',
            beforeSend: function (xhr) {
                form_button.attr("disabled", "disabled").width(form_button.width()).html("<img height='16' src='" + BASE + "/_img/load_white.gif' alt='Aguarde...' title='Aguarde...'>");
            },
            success: function (data, textStatus, jqXHR) {
                //TRIGGER CONTROL
                if (data.trigger) {
                    trigger(data.trigger);
                }

                //CHECKOUT
                if (data.checkout) {
                    dashCheckout(data);
                }

                //RELOAD NOW
                if (data.reload) {
                    window.location.reload();
                }

                //LOCATION NOW
                if (data.location) {
                    window.location.href = data.location;
                    if (data.location === window.location.href) {
                        window.location.reload();
                    }
                }

                //RESET
                if (data.reset) {
                    form.trigger("reset");
                }

                //LOAD REMOVE
                if (!data.location && !data.checkout && !data.reload) {
                    form_button.removeAttr("disabled").width("").html(form_button_text);
                }

                //FADE REMOVE
                if (data.faderemove) {
                    $(data.faderemove).fadeOut(function () {
                        $(this).remove();
                    });
                }
            }
        });
    });

    //CARD NUMBER
    $("input[name='card_number']").on("keypress change", function (e) {
        if ($(this).val().length < 17) {
            $(this).val(function (index, value) {
                return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ').trim();
            });
        }

        var key = e.which;
        if ((key < 47 || key > 58)) {
            return (key === 8 || key === 0) ? true : false;
        }
    });

    /*
     * CLASS PLAY VIMEO
     */
    if ($(".dash_view_class_media_player").length) {
        var videoPlayer = $(".dash_view_class_media_player");
        var videoRepeat = 1000 * 10;

        $.getScript("https://player.vimeo.com/api/player.js", function () {
            var vimeo = (videoPlayer.find(".dash_view_class_media_player_vimeo").length ? new Vimeo.Player(document.querySelector(".dash_view_class_media_player_vimeo")) : null);
            var vimeoPlay = null;

            //vimeo player
            if (vimeo) {
                clearInterval(vimeoPlay);

                //start progress
                if (videoPlayer.attr('data-progress') >= 20) {
                    vimeo.setCurrentTime(videoPlayer.attr('data-progress') - 10).then(function () {
                        vimeo.pause();
                    });
                }

                //playback rate
                if (videoPlayer.attr("data-playback") != 1.0) {
                    vimeo.setPlaybackRate(videoPlayer.attr("data-playback"));
                }

                vimeo.on("ratechange", function (rate) {
                    $.post(FILE, {case: "course_class_playback_rate", rate: rate.playbackRate});
                });

                //PLAYER ACTIONS :: class
                vimeo.on("play", function (play) {
                    var vimeoSeconds = 0;
                    vimeo.on('timeupdate', function (time) {
                        vimeoSeconds = time.seconds;
                    });

                    var vimeoPlay = setInterval(function () {
                        $.post(FILE, {
                            case: "course_class_play",
                            class_id: videoPlayer.attr("data-class"),
                            progress: vimeoSeconds,
                            seconds: videoRepeat
                        }, function (data) {
                            //TRIGGER CONTROL
                            if (data.trigger) {
                                trigger(data.trigger);
                            }

                            //STOP TIMER
                            if (data.stop) {
                                vimeo.pause();
                                clearInterval(vimeoPlay);
                            }

                            //FREE
                            if (data.classfree) {
                                studentClassFree(data);
                            }
                        }, 'json');
                    }, videoRepeat);

                    //PLAYER ACTIONS :: pause
                    vimeo.on('pause', function () {
                        clearInterval(vimeoPlay);
                    });

                    //PLAYER ACTIONS :: finish
                    vimeo.on('ended', function () {
                        clearInterval(vimeoPlay);
                        $.post(FILE, {
                            case: "course_class_play",
                            class_id: videoPlayer.attr("data-class"),
                            progress: "ended",
                            seconds: videoRepeat
                        });
                    });
                });

                //folder pause
                $(".class_folder").click(function () {
                    vimeo.pause();
                });
            } else {
                //OTHER PLAYER
                var otherPlayer = setInterval(function () {
                    $.post(FILE, {
                        case: "course_class_play",
                        class_id: videoPlayer.attr("data-class"),
                        progress: null,
                        seconds: videoRepeat
                    }, function (data) {
                        //TRIGGER CONTROL
                        if (data.trigger) {
                            trigger(data.trigger);
                        }

                        //FREE
                        if (data.classfree) {
                            studentClassFree(data);
                        }
                    }, 'json');
                }, videoRepeat);
            }
        });

    }

    /*
     * SUPPORT EDITOR
     */
    if ($('.dash_view_class_support_form, .app_upinside_class_comments_content_form, .app_upinside_class_request_modal_box').length) {
        tinyMCE.init({
            selector: ".editor",
            language: 'pt_BR',
            menubar: false,
            theme: "modern",
            statusbar: false,
            autoresize_min_height: 20,
            autoresize_bottom_margin: 0,
            autoresize_overflow_padding: 15,
            verify_html: true,
            skin: 'light',
            entity_encoding: "raw",
            theme_advanced_resizing: true,
            plugins: [
                "paste autolink link autoresize fullscreen"
            ],
            toolbar: "styleselect |  bold | italic | link | unlink",
            content_css: BASE + "/_cdn/tinymce/tinyMCE.css",
            style_formats: [
                {title: 'Normal', block: 'p'},
                {title: 'Título', block: 'h3'},
                {title: 'Sub-Título', block: 'h4'},
                {title: 'Código', block: 'pre', classes: 'brush: php;'}
            ],
            link_title: false,
            target_list: false,
            media_dimensions: false,
            media_poster: false,
            media_alt_source: false,
            media_embed: false,
            extended_valid_elements: "a[href|target=_blank|rel|class]",
            image_dimensions: false,
            relative_urls: false,
            remove_script_host: false,
            resize: false,
            paste_as_text: true
        });
    }

    /*
     * FORUM EDITOR 
     */
    if ($(".app_forum_create_form").length) {
        tinyMCE.init({
            selector: ".editor",
            language: 'pt_BR',
            menubar: false,
            theme: "modern",
            height: 260,
            statusbar: false,
            verify_html: true,
            skin: 'light',
            entity_encoding: "raw",
            theme_advanced_resizing: true,
            plugins: [
                "paste autolink link fullscreen"
            ],
            toolbar: "styleselect |  bold | italic | link | unlink | upinsideimage | fullscreen",
            content_css: BASE + "/_cdn/tinymce/tinyMCE.css",
            style_formats: [
                {title: 'Normal', block: 'p'},
                {title: 'Título', block: 'h3'},
                {title: 'Sub-Título', block: 'h4'},
                {title: 'Código', block: 'pre', classes: 'brush: php;'}
            ],
            setup: function (editor) {
                editor.addButton('upinsideimage', {
                    title: 'Enviar Imagem',
                    icon: 'image',
                    onclick: function () {
                        $(".app_forum_create_form_image").fadeIn().css("display", "flex");

                        $("body").click(function (e) {
                            if ($(e.target).attr("class") === "app_forum_create_form_image") {
                                $(".app_forum_create_form_image").fadeOut();
                            }
                        });

                        $(".app_forum_create_form_image form").submit(function (e) {
                            e.preventDefault();
                            var form = $(this);
                            form.ajaxSubmit({
                                url: FILE,
                                data: {case: form.attr("action")},
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function () {
                                    $("<div class='upload_modal'><div class='upload_modal_box'></div></div>").prependTo("body");
                                },
                                uploadProgress: function (evento, posicao, total, completo) {
                                    var porcento = completo + '%';
                                    $('.upload_modal_box').text(porcento);

                                    if (completo <= '90') {
                                        $('.upload_modal').fadeIn().css('display', 'flex');
                                    }
                                    //PREVENT TO RESUBMIT
                                    form.trigger("reset");
                                },
                                success: function (data) {
                                    $('.upload_modal').fadeOut(function () {
                                        $(this).remove();
                                    });

                                    if (data.trigger) {
                                        trigger(data.trigger);
                                    }

                                    //TINYMCE LOAD CONTENT
                                    if (typeof tinyMCE !== 'undefined' && data.image) {
                                        tinyMCE.activeEditor.insertContent(data.image);
                                    }

                                    if (data.uploaded) {
                                        $(".app_forum_create_form_image").fadeOut();
                                        $(".app_forum_create_form_image form").off("submit");
                                    }
                                }
                            });
                        });
                    }
                });
            },
            link_title: false,
            target_list: false,
            media_dimensions: false,
            media_poster: false,
            media_alt_source: false,
            media_embed: false,
            extended_valid_elements: "a[href|target=_blank|rel|class]",
            image_dimensions: false,
            relative_urls: false,
            remove_script_host: false,
            resize: false,
            paste_as_text: true
        });

        $(".app_forum_create_form_forum").change(function () {
            $(".app_forum_create_form_category").html("<option value='' selected disabled>Carregando...</option>");
            $.post(FILE, {case: "forum_category", forum_id: $(this).val()}, function (data) {
                //TRIGGER CONTROL
                if (data.trigger) {
                    trigger(data.trigger);
                }

                if (data.options) {
                    $(".app_forum_create_form_category").html(data.options);
                }
            }, "json");
        });

        $(".forum_form_upload_image").change(function () {
            $(".forum_form_upload").submit();
            $(this).val("");
        });
    }

    /*
     * FOLDER CONTROL
     */
    if ($(".dash_view_class_folder").length) {
        var folder = $(".dash_view_class_folder");
        $(".class_folder").click(function (e) {
            folder.fadeIn(1, function () {
                $("html").css("overflow", "hidden");
                folder.animate({"right": "0"}, 400, function () {
                    $(".dash_view_class_folder_close").fadeIn(1);
                });
            });
        });

        $(".dash_view_class_folder_close").click(function () {
            $(this).fadeOut(1, function () {
                $("html").css("overflow", "auto");
                folder.animate({"right": "-700px"}, 400, function () {
                    $(this).fadeOut(1);
                });
            });
        });
    }

    /*
     * CONQUEST CONTROL
     */
    $(".j_conquest_open").click(function () {
        $.post(FILE, {case: 'activities_conquest', conquest_id: $(this).attr("id"), notsleep: true}, function (data) {
            if (data.trigger) {
                trigger(data.trigger);
            }

            if (data.conquest) {
                $(".dash_view_activities_sidebar_conquests").prepend(data.conquest);
                $(".dash_view_activities_sidebar_conquests_modal").fadeIn(200).css("display", "flex");
            }
        }, "json");

        $(".dash_view_activities_sidebar_conquests").on("click", ".j_conquest_close", function (e) {
            if ($(e.target).hasClass("j_conquest_close")) {
                $(".dash_view_activities_sidebar_conquests_modal").fadeOut(200, function () {
                    $(this).remove();
                });
            }
        });

        $(document).keyup(function (e) {
            if (e.keyCode === 27) {
                $(".j_conquest_close").click();
            }
        });
    });

    /*
     * MASK
     */
    if ($('.formDate').length || $('.formTime').length || $('.formCep').length || $('.formCpf').length || $('.formPhone').length || $(".formDateExpirationCard").length) {
        $.getScript(BASE + '/_cdn/maskinput.js', function () {
            $(".formDate").mask("99/99/9999");
            $(".formTime").mask("99/99/9999 99:99");
            $(".formCep").mask("99999-999");
            $(".formCpf").mask("999.999.999-99");
            $(".formDateExpirationCard").mask("99/99");

            var SPMaskBehavior = function (val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                spOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };
            $('.formPhone').mask(SPMaskBehavior, spOptions);
        });
    }

    /*
     * PLAY
     */
    $('.app_upinside_class_post_video_media_more_item').click(function () {

        var videoPlay = $(this);
        var videoEmbed = $(".app_upinside_class_post_video_media .embed-container");
        var videoId = videoPlay.data('video');
        var videoColor = videoPlay.data('color');

        videoEmbed.fadeTo(200, 0, function () {
            var url = "https://player.vimeo.com/video/" + videoId + "?color=" + videoColor + "&title=0&byline=0&portrait=0";
            if (videoId.length >= 25) {
                url = "https://player-vz-51e63e61-c92.tv.pandavideo.com.br/embed/?v=" + videoId + "&color=" + videoColor;
            }

            videoEmbed.find("iframe").attr('src', url);
            $('.app_upinside_class_post_video_media_more_item').removeClass('now icon-mug').addClass('icon-play2');
            videoPlay.addClass('now icon-mug').removeClass('icon-play2');
            videoEmbed.delay(600).fadeTo(200, 1);
        });
    });

    $("[data-played]").click(function (e) {
        var played = $(this);
        var post_id = played.attr("data-id");

        if (played.hasClass("played")) {
            played
                .addClass("icon-checkbox-unchecked")
                .removeClass("icon-checkbox-checked played")
                .text("Marcar como concluído");
        } else {
            played
                .addClass("icon-checkbox-checked played")
                .removeClass("icon-checkbox-unchecked")
                .text("Concluído");
        }

        $.post(FILE, {case: 'class_played', post_id: post_id, notsleep: true}, function (data) {
            if (data.reload) {
                window.location.reload();
            }
        }, "json");
    });

    $("[data-review]").click(function (e) {
        var review = $(this);
        var post_id = review.attr("data-id");
        var star = $(this).index() + 1;

        review.addClass("icon-star-full").removeClass("icon-star-empty");
        review.prevAll().addClass("icon-star-full").removeClass("icon-star-empty");
        review.nextAll().addClass("icon-star-empty").removeClass("icon-star-full");
        $.post(FILE, {case: 'class_review', post_id: post_id, review: star, notsleep: true});
    });
});

/*
 * studentClassFree: controla ações de botão na aula
 * @param {type} arrTrigger
 */
function studentClassFree(data) {
    if (data.classfree[0] === 'free') {
        var freeBtn = "<span class='icon-checkbox-unchecked'>CONCLUIR AULA</span>";
        $(".classcheck").html(freeBtn).removeClass("classpending classfinish").attr({
            "data-action": "course_class_check",
            "data-class": data.classfree[1]
        });

    } else if (data.classfree[0] === 'check') {
        var freeBtn = "<span class='icon-checkbox-checked'>AULA CONCLUÍDA</span>";
        $(".classcheck").html(freeBtn).removeClass("classpending").addClass("classfinish").attr({
            "data-action": "course_class_check",
            "data-class": data.classfree[1]
        });
    }
}

/*
 * dashCheckout: gerencia todo o processo de liberação de cursos
 * @param {type} data
 * @returns {undefined}
 */
function dashCheckout(data) {
    var timeAnimation = 300;

    $("body").css("overflow", "hidden");
    if (!$(".dash_checkout").length) {
        var dashCheckoutBox = "<div class='dash_checkout'>";
        dashCheckoutBox += "<div class='dash_checkout_box'>";
        dashCheckoutBox += "<span class='dash_checkout_close icon-cross icon-notext'></span>";
        dashCheckoutBox += "<div class='dash_checkout_box_load'></div>";
        dashCheckoutBox += "</div></div>";
        $("body").append(dashCheckoutBox).find(".dash_checkout").fadeIn(timeAnimation / 2).css("display", "flex");
    } else {
        $(".dash_checkout_box").slideUp(timeAnimation);
    }

    //LOAD
    setTimeout(function () {
        $(".dash_checkout_box_load").load(data.checkout, function () {
            //USER
            $(".user_name").text(data.user_name);

            //COURSE
            $(".course_id").val(data.course_id);
            $(".course_title").text(data.course_title);
            $(".course_link").attr("href", data.course_link);

            //CLUB
            $(".club_plan").text(data.club_plan);
            $(".club_enrollments_free").text(data.club_enrollments_free);
            $(".plan_enrollments").text(data.plan_enrollments);

            //SHOW
            $(".dash_checkout_box").slideDown(timeAnimation);
        });
    }, timeAnimation);

    //CLOSE
    $(".dash_checkout_close").click(function () {
        $(".dash_checkout_box").slideUp(timeAnimation, function () {
            $(".dash_checkout").fadeOut(timeAnimation / 2, function () {
                if ($(".dash_checkout_view_success").length) {
                    window.location.reload();
                } else {
                    $(this).remove();
                    $("body").css("overflow", "auto");
                }
            });
        });
    });
}

/*
 * trigger: trata o objeto para executar qualquer tipo de trigger
 * @param {array} arrTrigger
 */
function trigger(arrTrigger) {
    if (arrTrigger[0]) {
        var delay = 0;
        $.each(arrTrigger, function (i, trigger) {
            setTimeout(function () {
                if (trigger.type === 'notify') {
                    //MULT NORIFY
                    triggerNotify(trigger);
                } else if (trigger.type === "modal") {
                    alert("DEV: Mult-Modal Not Support");
                    return;
                }

            }, delay);
            delay += 1000;
        });
    } else {
        if (arrTrigger.type === 'notify') {
            triggerNotify(arrTrigger);
        } else if (arrTrigger.type === "modal") {
            triggerModal(arrTrigger);
        }
    }
}

/*
 * triggerNotify: cria norifição superior direita.
 * @param data color|icon|message|type|[,time]
 * @returns html notify
 */
function triggerNotify(data) {
    var timeMessage = data.time || 5000;
    var triggerMessage = "<div class='trigger_notify icon-" + data.icon + " trigger_" + data.color + "' style='left: 100%; opacity: 0;'>";
    triggerMessage += data.message;
    triggerMessage += "<span class='trigger_notify_time'></span>";
    triggerMessage += "</div>";

    //GET OR ADD TRIGGER BOX
    if (!$(".trigger_notify_box").length) {
        $("body").prepend("<div class='trigger_notify_box'></div>");
    } else {
        $(".trigger_notify:gt(1)").animate({"left": "100%", "opacity": "0"}, 400, function () {
            $(this).remove();
        });
    }

    $(".trigger_notify_box").prepend(triggerMessage);
    $(".trigger_notify:first").stop().animate({"left": "0", "opacity": "1"}, 200, function () {
        $(this).find(".trigger_notify_time").animate({"width": "100%"}, timeMessage, "linear", function () {
            $(this).parent(".trigger_notify").animate({"left": "100%", "opacity": "0"}, 200, function () {
                $(this).remove();
            });
        });
    });

    $("body").on('click', '.trigger_notify', function () {
        $(this).animate({"left": "100%", "opacity": "0"}, 200, function () {
            $(this).remove();
        });
    });
}

/*
 * triggerNotify: cria norifição superior direita.
 * @param data color|icon|title|message|type|[,close url]
 * @returns html notify
 */
function triggerModal(data) {
    var triggerMessage = "<div class='trigger_modal_box'>";
    triggerMessage += "<div class='trigger_modal trigger_" + data.color + "'>";
    triggerMessage += "<span class='icon-cross trigger_modal_close icon-notext'></span>";
    triggerMessage += "<div class='trigger_modal_icon icon-" + data.icon + "2 icon-notext'></div>";
    triggerMessage += "<div class='trigger_modal_content'>";
    triggerMessage += "<div class='trigger_modal_content_title'>" + data.title + "</div>";
    triggerMessage += "<div class='trigger_modal_content_message'>" + data.message + "</div>";
    triggerMessage += "</div></div></div>";

    if (!$(".trigger_modal_box").length) {
        $("body").prepend("<div class='trigger_notify_box'>" + triggerMessage + "</div>");
    } else {
        $(".trigger_modal").fadeOut(200, function () {
            $(this).remove();
            $(".trigger_modal_box").html(triggerMessage);
        });
    }

    $(".trigger_modal_box").fadeIn(200, function () {
        var modal_box = $(this);
        modal_box.find(".trigger_modal").animate({"top": "0", "opacity": "1"}, 200);

        modal_box.on("click", ".trigger_modal_close", function () {
            modal_box.find(".trigger_modal").animate({"top": "100", "opacity": "0"}, 200, function () {
                modal_box.fadeOut(200, function () {
                    $(this).remove();
                    if (data.location) {
                        if (data.location === true) {
                            window.location.reload();
                        } else {
                            window.location.href = data.location;
                            if (window.location.href === data.location) {
                                window.location.reload();
                            }
                        }
                    }
                });
            });
        });
    }).css("display", "flex");
}
