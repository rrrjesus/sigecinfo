$(function () {

    $.validator.setDefaults({
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        },

        // errorElement: 'span',
        errorClass: 'help-block',

        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            }
            else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            }
            else if (element.prop('type') === 'password') {
                error.appendTo(element.parent());
            }
            else if (element.prop('type') === 'file') {
                error.appendTo(element.parent());
            }
            if (element.parent('select').length) {
                error.insertAfter(element.parent());
            }
            else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod('valsenha', function(value, element) {
        return this.optional(element)
            || value.length >= 8
            && /\d/.test(value)
            && /[a-z]/i.test(value);
    }, 'Sua senha deve ter no mínimo 8 caracteres e conter pelo menos um número e um caractere.');


    $("#user").validate({
        rules: {
            login: {
                required: true
            }
        },
        messages: {
            login: {
                required: "Digite o login !!!"
            }
        }
    });

    $("#profile").validate({
        rules: {
            password: {
                valsenha: true
            },
            password_re: {
                valsenha: true,
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                valsenha: "Sua nova senha deve ter no mínimo 8 caracteres e conter pelo menos um número e um caractere"
            },
            password_re: {
                valsenha: "Sua nova senha deve ter no mínimo 8 caracteres e conter pelo menos um número e um caractere",
                equalTo: "As senhas não conferem !!!"
            }
        }
    });

    $("#patrimony").validate({
        rules: {
            movement_id: {
                required: true
            },
            product_id: {
                required: true
            },
            unit_id: {
                required: true
            },
            type_part_number: {
                required: true
            },
            part_number: {
                required: true
            }
        },
        messages: {
            movement_id: {
                required: "Digite o estado do patrimônio !!!"
            },
            product_id: {
                required: "Digite o produto !!!"
            },
            unit_id: {
                required: "Digite a unidade !!!"
            },
            type_part_number: {
                required: "Digite o tipo de registro !!!"
            },
            part_number: {
                required: "Digite o número de registro !!!"
            }
        }
    });


    //  data-bs-toggle="tooltip" Bootstrap Title
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-togglee="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })


    /*
        * CARREGAR A FOTO NO UPLOAD
    */

    /* Atribui ao evento change do input FILE para upload da foto*/
    var inputFile = document.getElementById("photo");
    var foto_cliente = document.getElementById("foto-cliente");
    if (inputFile != null && inputFile.addEventListener) {
        inputFile.addEventListener("change", function(){loadFoto(this, foto_cliente)});
    } else if (inputFile != null && inputFile.attachEvent) {
        inputFile.attachEvent("onchange", function(){loadFoto(this, foto_cliente)});
    }

    /* Função para exibir a imagem selecionada no input file na tag <img>  */
    function loadFoto(file, img){
        if (file.files && file.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                img.src = e.target.result;
            }
            reader.readAsDataURL(file.files[0]);
        }
    }

    /*
     * jQuery MASK
     */
        $(".mask-money").mask('000.000.000.000.000,00', {reverse: true, placeholder: "0,00"});
        $(".mask-date").mask('00/00/0000', {reverse: true});
        $(".mask-month").mask('00/0000', {reverse: true});
        $(".mask-doc").mask('000.000.000-00', {reverse: true});
        $(".mask-imei").mask('000000000000000', {reverse: true});
        $(".mask-card").mask('0000  0000  0000  0000', {reverse: true});
        $('.mask-cell-phone').mask('(00)00000-0000');
        $('.mask-fixed-phone').mask('(00)0000-0000');
        $('.mask-cep').mask('00000-000');
        $('.mask-login').mask('S000000');
        $('.mask-rf').mask('0000000');

    //  data-bs-toggle="tooltip" Bootstrap Title
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-togglee="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    /*
     * IMAGE RENDER
     */
        $("[data-image]").change(function (e) {
            var changed = $(this);
            var file = this;
    
            if (file.files && file.files[0]) {
                var render = new FileReader();
    
                render.onload = function (e) {
                    $(changed.data("image")).fadeTo(100, 0.1, function () {
                        $(this).css("background-image", "url('" + e.target.result + "')")
                            .fadeTo(100, 1);
                    });
                };
                render.readAsDataURL(file.files[0]);
            }
        });

    /**
     * Função para tratativas e preenchimentos automáticos de campos
     *
     * @return {VoidFunction}
     */

    $("input[name='user_id']").blur(function(){
        var $unit_id = $("input[name='unit_id']");

        $unit_id.val('Carregando...');

        $.getJSON(
            '../../themes/smsubapp/autocomplete/complete-user.php',

            {user_id: $(this).val()},

            function( json )
            {
                $unit_id.val( json.unit_id );
            }
        );
    });

     /**
     * Função para tratativas e preenchimentos automáticos de campos
     *
     * @return {VoidFunction}
     */

     $("input[name='user_id_edit']").blur(function(){
        var $unit_id_edit = $("input[name='unit_id_edit']");

        $unit_id_edit.val('Carregando...');

        $.getJSON(
            '../../../themes/smsubapp/autocomplete/complete-user-edit.php',

            {user_id_edit: $(this).val()},

            function( json )
            {
                $unit_id_edit.val( json.unit_id_edit );
            }
        );
    });

     /**
     * Função para tratativas e preenchimentos automáticos de campos
     *
     * @return {VoidFunction}
     */

     $("input[name='user_id_history_edit']").blur(function(){
        var $unit_id_history_edit = $("input[name='unit_id_history_edit']");

        $unit_id_history_edit.val('Carregando...');

        $.getJSON(
            '../../../../themes/smsubapp/autocomplete/complete-user-history-edit.php',

            {user_id_history_edit: $(this).val()},

            function( json )
            {
                $unit_id_history_edit.val( json.unit_id_history_edit );
            }
        );
    });

    /*
        * AJAX FORM
        */
    $("form:not('.ajax_off')").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var load = $(".ajax_load");
        var flashClass = "ajax_response";
        var flash = $("." + flashClass);

        form.ajaxSubmit({
            url: form.attr("action"),
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            uploadProgress: function (event, position, total, completed) {
                var loaded = completed;
                var load_title = $(".ajax_load_box_title");
                load_title.text("Enviando (" + loaded + "%)");

                form.find("input[type='file']").val(null);
                if (completed >= 100) {
                    load_title.text("Aguarde, carregando...");
                }
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    load.fadeOut(200);
                }

                //reload
                if (response.reload) {
                    window.location.reload();
                } else {
                    load.fadeOut(200);
                }

                //message
                if (response.message) {
                    if (flash.length) {
                        flash.html(response.message).fadeIn(100).effect("bounce", 300);
                    } else {
                        form.prepend("<div class='" + flashClass + "'>" + response.message + "</div>")
                            .find("." + flashClass).effect("bounce", 300);
                    }
                } else {
                    flash.fadeOut(100);
                }
            },
            complete: function () {
                if (form.data("reset") === true) {
                    form.trigger("reset");
                }
            },
            error: function () {
                var message = "<div class='alert alert-warning alert-dismissible fade show text-center fw-semibold fs-5x' role='alert'><i class='bi bi-exclamation-diamond p-2'></i>Desculpe mas não foi possível processar a requisição. Favor tente novamente!</div>";

                if (flash.length) {
                    flash.html(message).fadeIn(100).effect("bounce", 300);
                } else {
                    form.prepend("<div class='" + flashClass + "'>" + message + "</div>")
                        .find("." + flashClass).effect("bounce", 300);
                }

                load.fadeOut();
            }
        });
    });
});