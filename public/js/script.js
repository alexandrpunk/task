if(("standalone" in window.navigator) && window.navigator.standalone) {
    $('a').click(function(event) {
        event.preventDefault();
        if ( !$(this).hasClass('simpleButton') ) {
            if( location.hostname === this.hostname || !this.hostname.length ) {
                window.location = $(this).attr("href");
            } else {
                window.open( this.href, '_blank');
            }
        }
    });
}

$( document ).ready(function() {
    var z = $('nav').height();
    $('body').css( "padding-top", z+'px');
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});

function clickAndDisable(link) {
    $(link).addClass('disabled');
    $(link).find('span').html('procesando...');
}

