
$(document).ready(function(){
    //Chamada Slider
    $('.slider').slider();

    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();

    // Chamada select destinos
    $('select').material_select();

    $('#form_dataNascimento').formatter({
        'pattern': '{{99}}/{{99}}/{{9999}}',
        'persistent': true
    });

    $('#form_cpf').formatter({
        'pattern': '{{999}}.{{999}}.{{999}}-{{99}}',
        'persistent': true
    });

    $('#form_cep').formatter({
        'pattern': '{{99999}}-{{999}}',
        'persistent': true
    });


    $('#form_telefoneRes').formatter({
        'pattern': '+55 ({{99}}) {{9999}}-{{9999}}',
        'persistent': true
    });
    $('#form_telefoneCel').formatter({
        'pattern': '+55 ({{99}}) {{99999}}-{{9999}}',
        'persistent': true
    });

    $('#currency-demo').formatter({
        'pattern': '$ {{999}}-{{999}}-{{999}}.{{99}}',
        'persistent': true
    });
    $('#credit-demo').formatter({
        'pattern': '{{9999}}-{{9999}}-{{9999}}-{{9999}}',
        'persistent': true
    });

    $('#product-key').formatter({
        'pattern': 'm{{*}}-{{999}}-{{999}}-C{{99}}',
        'persistent': true
    });
    $('#purchase-code').formatter({
        'pattern': 'ISBN{{9999}}-{{9999}}-{{9999}}-{{9999}}',
        'persistent': true
    });
});
