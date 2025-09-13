/**
 * Função para gerar DOM de image .PNG
 *
 * @param {Object} asspng obrigatório Parametro obrigatório
 * @param {Text} assnome obrigatório Parametro obrigatório
 * @return {VoidFunction}
 */

$(function () {
    $("#gerarpng").on("click", function () {
        var asspng = $('.assinatura-download')[0]; //returns a HTML DOM Object
        var assnome = $('.asnome').text();
        var inpNome = $('#nomeinp').val();
        var inpCargo = $('#cargoinp').val();
        var inpSector = $('#sector').val();
        var inpEmail = $('#emailinp').val();
        var tempDate = new Date();
        var dataAtual = [tempDate.getDate(), tempDate.getMonth() + 1, tempDate.getFullYear(), tempDate.getHours(), tempDate.getMinutes(), tempDate.getSeconds()].join('/');

        if (inpNome !== '' && inpCargo !== '' && inpSector !== '' && inpEmail !== '') {
            // Obtendo um blob de imagem PNG e baixando (usando FileSaver):
            domtoimage.toBlob(asspng)
                .then(function (blob) {
                    window.saveAs(blob, assnome + '_' + dataAtual);
                }).catch(function (error) {
                console.error('Não foi possivel gerar a imagem ...', error);
            });
        }

    });
});

/**
 * Função para tratativas e preenchimentos automáticos de campos
 *
 * @return {VoidFunction}
 */

$(function () {
    $("input[name='nomeinp']").on('focusout',function() {
        var emailinp = $("input[name='emailinp']");

        emailinp.val('');

        $.getJSON(
            '../themes/smsubiframe/autocomplete/complete-email.php',
            { nomeinp: $( this ).val() },
            function( json )
            {
                var jsonnome = json.nomeinp;
                var jsonemail = json.emailinp;
                if(jsonemail!==''){
                    $('.asnome').html(jsonnome);
                    emailinp.val(jsonemail);
                    var alias = '@smsub.prefeitura.sp.gov.br';
                    $('.asemail').html(jsonemail + alias);
                    $("#emailinp").prop('readonly',true);
                }else{
                    $("#emailinp").prop('readonly',false);
                }
            }
        );
    });

    $("input[name='secsubinp']").on('focusout',function() {
        var enderecoinp = $("input[name='enderecoinp']");
        var cepinp = $("input[name='cepinp']");

        enderecoinp.val('');
        cepinp.val('');

        $.getJSON(
            '../themes/smsubiframe/autocomplete/complete-secsub.php',
            { secsubinp: $( this ).val() },
            function( json )
            {
                var jsonendereco = json.enderecoinp;
                var jsoncep = json.cepinp;
                var jsonphoto = json.asphoto;
                var jsonurl = json.url;
                var photo = '<img id="logo-assinatura mb-0" src="../themes/smsubiframe/assets/images/assinatura/' + jsonphoto + '">';
               
                if(jsonendereco!=='') {
                    enderecoinp.val(jsonendereco);
                    cepinp.val(jsoncep);
                    $('.asphoto').html(photo);
                    $('.asendereco').html(jsonendereco)
                    $('.ascep').html(jsoncep)
                    $('.asurl').html(jsonurl)
                } else {
                    $('.asphoto').html(photo);
                    $('.asendereco').html("Rua José Buono, 65 - Jaçanã  ")
                    $('.ascep').html("02273-120");
                    $('.asurl').html("www.prefeitura.sp.gov.br/cidade/secretarias/subprefeituras/ ");
                }

            }
        );
    });

    var photoinicial = '<img id="logo-assinatura mb-0" src="../themes/smsubiframe/assets/images/assinatura/logo_ass_smsub.png">';

    $('.asnome').html("NOME COMPLETO");
    $('.ascargo').html("CARGO");
    $('.assector').html("SETOR");
    $('.asphoto').html(photoinicial);
    $('.asendereco').html("Rua José Buono, 65 - Jaçanã  ");
    $('.ascep').html("02273-120");
    $('.asemail').html("@smsub.prefeitura.sp.gov.br");
    $('.asramal').html("Tel : +55 (11) 4934-3000");

    $('.nomeinp').on('keyup',function(){
        var asnome = $('#nomeinp').val().toUpperCase();
        if(asnome==='') {
            $('.asnome').html("NOME COMPLETO");
        } else {
            $('.asnome').html(asnome);
        }
    });
    $('.cargoinp').on('focusout',function() {
        var ascargo = $('#cargoinp').val().toUpperCase();
        if(ascargo==='') {
            $('.ascargo').html("CARGO");
        } else {
            $('.ascargo').html(ascargo);
        }
    });
    $('.sector').on( "focusout", function() {
        var sector = $('#sector').val().toUpperCase();
        if(sector==='') {
            $('.assector').html("SETOR");
        } else {
            $('.assector').html(sector);
        }
    });

    $('.enderecoinp').on( "keyup", function() {
        var asendereco = $('.enderecoinp').val().toLowerCase().replace(/(?:^|\s)\S/g, function(a) {
            return a.toUpperCase();
        });
        if(asendereco==='') {
            $('.asendereco').html("Rua José Buono, 65 - Jaçanã  ");
        } else {
            $('.asendereco').html(asendereco);
        }
    });

    $('.cepinp').on( "keyup", function() {
        var ascep = $('.cepinp').val().toUpperCase();
        if(ascep==='') {
            $('.ascep').html("02273-120");
        } else {
            $('.ascep').html(ascep);
        }
    });

    $('.emailinp').on('keyup',function() {
        $(this).val($(this).val().toLowerCase());
        var asemail = $('.emailinp').val().toLowerCase();
        var alias = '@smsub.prefeitura.sp.gov.br';
        if(asemail==='') {
            $('.asemail').html("@smsub.prefeitura.sp.gov.br");
        } else {
            $('.asemail').html(asemail + alias);
        }
    });
    $('.ramalinp').on('focusout',function() {
        var astelefone = 'Tel : +55 (11) ';
        var asramal = $('#ramalinp').val();
        if(asramal==='') {
            $('.asramal').html("Tel : +55 (11) 4934-3000");
        } else {
            $('.asramal').html(astelefone +  '4934-' + asramal);
        }
    });

    $('.andarinp').on('keyup',function() {
        var asandar = $('.andarinp').val().toUpperCase();
        var nomeAndar = 'º Andar';
        if(asandar==='') {
            $('.asandar').html("");
        } else {
            $('.asandar').html(asandar + nomeAndar);
        }
    });
    $('.salainp').on('keyup',function() {
        $(this).val($(this).val().toUpperCase());
        var nomeSala = ' - Sala ';
        var assala = $('.salainp').val().toUpperCase();
        if(assala==='') {
            $('.assala').html("");
        } else {
            $('.assala').html(nomeSala + assala);
        }
    });
});


