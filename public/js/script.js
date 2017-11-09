$( document ).ready(function() {
    var z = $('nav').height();
    var x = $('footer').outerHeight();
    $('body').css( "padding-top", z+'px');
    $('body').css( "padding-bottom", x+'px');
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});

function clickAndDisable(link) {
    $(link).addClass('disabled');
    $(link).find('span').html('procesando...');
} 