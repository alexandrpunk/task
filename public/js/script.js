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

$( document ).ready(function() {
    var z = $('nav').height();
    var x = $('footer').outerHeight();
    $('body').css( "padding-top", z+'px');
    $('body').css( "padding-bottom", x+'px');
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});

$('#search').click(function (event) {
    event.preventDefault();
    $('#main-nav, #search-nav').toggleClass('d-none');
    $( "#search-box" ).attr('disabled', false);
    $( "#search-box" ).focus();
});
$('#cancel-search').click(function (event) {
    event.preventDefault();
    $('#main-nav, #search-nav').toggleClass('d-none');
    $( "#search-box" ).val('');
    $( "#search-box" ).attr('disabled', true);
});

function clickAndDisable(link) {
    $(link).addClass('disabled');
    $(link).find('span').html('procesando...');
}

