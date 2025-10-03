$(function () {

    $.validator.setDefaults({
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        },

        errorElement: 'label',
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

    $.validator.addMethod('ascento', function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
    });

    $.validator.addMethod('strongPassword', function(value, element) {
        return this.optional(element)
            || value.length >= 8
    }, 'Sua senha deve ter pelo menos 6 caracteres e conter pelo menos um número e um caractere.');


    $("#login").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                strongPassword: true
            }
        },
        messages: {
            email: {
                required: "Digite seu email !!!",
                email: "Por favor, digite um endereço de email válido."
            },
            password: {
                required: "Digite sua senha !!!",
                strongPassword: "Sua senha deve ter pelo menos 8 caracteres"
            }
        }
    });

    $("#forget").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Digite seu email !!!",
                email: "Por favor, digite um endereço de email válido."
            }
        }
    });

    $("#reset").validate({
        rules: {
            password: {
                required: true,
                strongPassword: true
            },
            password_re: {
                required: true,
                strongPassword: true,
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                required: "Digite sua senha !!!",
                required: true,
                strongPassword: "Sua nova senha deve ter no mínimo 8 caracteres e conter pelo menos um número e um caractere"
            },
            password_re: {
                required: "Redigite a sua senha !!!",
                required: true,
                strongPassword: "Sua nova senha deve ter no mínimo 8 caracteres e conter pelo menos um número e um caractere",
                equalTo: "As senhas não conferem !!!"
            }
        }
    });

     //  data-bs-toggle-tooltip="tooltip" Bootstrap Title
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle-tooltip="tooltip"]'));

    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    const togglePasswordCheckbox = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#password');

    if (togglePasswordCheckbox && passwordField) {
        togglePasswordCheckbox.addEventListener('change', function () {
            // Verifica o tipo atual do campo e alterna para o outro
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        });
    }

});