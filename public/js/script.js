$( document ).ready(function() {
    var z = $('nav').height();
    $('body').css( "padding-top", z+15+'px');

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});

function clickAndDisable(link) {
    $(link).addClass('disabled');
    $(link).find('span').html('procesando...');
} 