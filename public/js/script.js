$( document ).ready(function() {
    var z = $('nav').height();
    var x = $('footer').outerHeight();
    $('body').css( "padding-top", z+'px');
    $('body').css( "padding-bottom", x+'px');
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});

if(("standalone" in window.navigator) && window.navigator.standalone) {
    $('a').click(function(event) {
        event.preventDefault();
        if( location.hostname === this.hostname || !this.hostname.length ) {
            window.location = $(this).attr("href");
        } else {
            window.open( this.href, '_blank');
        }
    });
}

function clickAndDisable(link) {
    $(link).addClass('disabled');
    $(link).find('span').html('procesando...');
}

