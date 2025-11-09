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

    $.validator.addMethod("greaterThan", function(value, element, params) {
        var startDate = $(params).val();
        if (!value || !startDate) {
            return true; // Don't validate if either field is empty
        }
        return new Date(value) >= new Date(startDate);
    }, "A data de término deve ser maior ou igual à data de início.");

    $("#userCreate").validate({
        rules: {
            user_name: { required: true },
            email: { required: true, email: true },
            password: { required: true, valsenha: true }, // Senha é obrigatória aqui
            password_re: { required: true, equalTo: "#password" },
            place_id: { required: true },
            position_id: { required: true },
            level_id: { required: true }
        },
        messages: {
            user_name: { required: "O nome é obrigatório." },
            email: { required: "O e-mail é obrigatório.", email: "Digite um e-mail válido." },
            password: { required: "A senha é obrigatória." },
            password_re: { required: "Repita a senha.", equalTo: "As senhas não correspondem." },
            place_id: { required: "Selecione um locai." },
            position_id: { required: "Selecione um cargo." },
            level_id: { required: "Selecione um nível de acesso." }
        }
    });

    // Validação para o formulário de EDIÇÃO de utilizador
    $("#userUpdate").validate({
        rules: {
            user_name: { required: true },
            email: { required: true, email: true },
            password: { valsenha: true },
            password_re: { equalTo: "#password" },
            place_id: { required: true },
            position_id: { required: true },
            level_id: { required: true }
        },
        messages: {
            user_name: { required: "O nome é obrigatório." },
            email: { required: "O e-mail é obrigatório.", email: "Digite um e-mail válido." },
            password_re: { equalTo: "As senhas não correspondem." },
            place_id: { required: "Selecione um locai." },
            position_id: { required: "Selecione um cargo." },
            level_id: { required: "Selecione um nível de acesso." }
        }
    });

    // event create
    $("#eventCreate").validate({
        rules: { title: { required: true },
            type_id: { required: true },
            start_at: { required: true },
            end_at: { greaterThan: "#start_at" }
        },
        messages: {
            title: { required: "O título do evento é obrigatório." },
            type_id: { required: "Por favor, selecione um tipo de evento." },
            start_at: { required: "A data e hora de início são obrigatórias." }
        }
    });

    // event update
    $("#eventUpdate").validate({
        rules: { 
            title: {required: true },
            type_id: { required: true },
            start_at: { required: true },
            end_at: { greaterThan: "#start_at" }
        },
        messages: {
            title: { required: "O título do evento é obrigatório." },
            type_id: { required: "Por favor, selecione um tipo de evento." },
            start_at: { required: "A data e hora de início são obrigatórias." }
        }
    });

    $("#userposition").validate({
        rules: {
            position_name: { required: true }
        },
        messages: {
            position_name: { required: "Digite o cargo do servidor !!!" }
        }
    });

   $("#placeCreate").validate({
        rules: {
            place_name: { required: true },
            country_id: { required: true },
            code_id: { required: true },
            address: { required: true },
            address_number: { required: true },
            zip_code: { required: true },
            city: { required: true },
            state: { required: true }
        },
        messages: {
            place_name: { required: "O nome do locai ou local é obrigatório." },
            country_id: { required: "Informe o país (ex.: BR, US)." },
            code_id: { required: "Informe o código." },
            address: { required: "O endereço é obrigatório." },
            address_number: { required: "O número é obrigatório." },
            zip_code: { required: "Informe o CEP." },
            city: { required: "Informe a cidade." },
            state: { required: "Informe o estado (ex.: SP)." }
        }
    });

    $("#placeUpdate").validate({
        rules: {
            place_name: { required: true },
            country_id: { required: true },
            code_id: { required: true },
            address: { required: true },
            address_number: { required: true },
            zip_code: { required: true },
            city: { required: true },
            state: { required: true }
        },
        messages: {
            place_name: { required: "O nome do locai ou local é obrigatório." },
            country_id: { required: "Informe o país (ex.: BR, US)." },
            code_id: { required: "Informe o código." },
            address: { required: "O endereço é obrigatório." },
            address_number: { required: "O número é obrigatório." },
            zip_code: { required: "Informe o CEP." },
            city: { required: "Informe a cidade." },
            state: { required: "Informe o estado (ex.: SP)." }
        }
    });

    // No seu ficheiro scripts.js

    $("#eventForm").validate({
        rules: {
            title: {
                required: true
            },
            type_id: {
                required: true
            },
            start_at: {
                required: true
            }
        },
        messages: {
            title: {
                required: "O título do evento é obrigatório."
            },
            type_id: {
                required: "Por favor, selecione um tipo de evento."
            },
            start_at: {
                required: "A data e hora de início são obrigatórias."
            }
        }
    });

    // Adicione ao seu scripts.js
    $("#eventTypeCreate").validate({
        rules: { name: { required: true } },
        messages: { name: { required: "O nome do tipo de evento é obrigatório." } }
    });

    $("#eventTypeUpdate").validate({
        rules: { name: { required: true } },
        messages: { name: { required: "O nome do tipo de evento é obrigatório." } }
    });

    //  data-bs-toggle-tooltip="tooltip" Bootstrap Title
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle-tooltip="tooltip"]'))
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

    /* Função que decide qual máscara usar      */
    var maskBehavior = function (val) {
        // Remove todos os caracteres que não são dígitos
        var digits = val.replace(/\D/g, '');
        
        // Se o número de dígitos for 11 (ou mais), usa a máscara de celular.
        // Senão, usa a máscara de telefone fixo.
        return digits.length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    };

    var options = {
        onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };

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
        $('.mask-phone').mask(maskBehavior, options);
        $('.mask-fixed-phone').mask('(00)0000-0000');
        $('.mask-cep').mask('00000-000');
        $('.mask-zip-code').mask('00000-000');
        $('.mask-state').mask('SS', {translation: {'S': { pattern: /[A-Za-z]/ }},onKeyPress: function(value, e, field, options) {field.val(value.toUpperCase());}});// permite maiúsculas e minúsculas
        $('.mask-code').mask('00-0000');
        //$('.mask-login').mask('S000000');
        $('.mask-country').mask('SS', {translation: {'S': { pattern: /[A-Za-z]/ }},onKeyPress: function(value, e, field, options) {field.val(value.toUpperCase());}});// permite maiúsculas e minúsculas
        $(".mask-sei").mask('0000.0000/0000000-0', {reverse: true});

    //  data-bs-toggle-tooltip="tooltip" Bootstrap Title
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle-tooltip="tooltip"]'))
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
                var message = "<div class='bd-callout bd-callout-warning fade show text-center fw-semibold fs-5x' role='alert'><i class='bi bi-exclamation-diamond p-2'></i>Desculpe mas não foi possível processar a requisição. Favor tente novamente!</div>";

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