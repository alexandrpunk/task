function closeSearch() {
    $('#search-nav').hide();
    $( "#search-box" ).val('');
    $( "#search-box" ).attr('disabled', true);
    $('#main-nav').fadeIn(150);
}

function filtrarLista(search) {
    var value =  remove_accent(search);
    $("#lista > .list-group-item").each(function() {
        if ( remove_accent( $(this).data('search').toLowerCase() ).search(value) > -1) {
            $(this).slideDown(50);
        }
        else {
            $(this).slideUp(50);
        }
    });
}

function loadTab(tab) {
    $.ajax({
        type: "GET",
        url: sessionStorage.getItem('link'),
        beforeSend: function(){
            $("#canvas-panel").hide();
            $("#canvas-panel").empty();
            $('.nav-item').not('#'+tab).removeClass('active');
            $('.nav-item').not('#'+tab).attr('aria-selected','false');
            $('#'+tab).addClass('active');
            $('#'+tab).attr('aria-selected','true');
            $('#titulo-pagina').text('estas en '+tab);
        },
        success: function(result){            
            $("#canvas-panel").html(result);
        },
        complete: function(){
            $("#canvas-panel").fadeIn(200);            
            $("li[id^='add-']").hide();     
            $("#add-"+tab).fadeIn(200);
            iosLinks();
            setButtons();
        }
    });
}

$(".filter").click(function(){
    $(".filter").removeClass('selected');
    $(".filter").attr('aria-checked',false);
    $(this).addClass('selected');
    $(this).attr('aria-checked',true);      
    $.ajax({
        type: "GET",
        url: sessionStorage.getItem('link')+'/'+$(this).data('value'),
        beforeSend: function(){
            $("#canvas-panel").hide();
            $("#canvas-panel").empty();
        },
        success: function(result){
            $("#canvas-panel").html(result);
        },
        complete: function(result){
            $("#canvas-panel").fadeIn(200);
            iosLinks();
            setButtons();
        }
    });
});

$('#search').click(function (event) {
    $('#main-nav').hide();
    $('#search-nav').fadeIn(200);
    if ( $('.nav-item.active').data('filter') ) {
        $('#filtro').show();
    } else {
        $('#filtro').hide();
    }
    $( "#search-box" ).attr('disabled', false);
    $( "#search-box" ).focus();
});

$('#cancel-search').click(function () {
    closeSearch();
});

$('.nav-item').click(function(){
    if ( !$(this).hasClass('active') ) {
        closeSearch();
        $(".filter").removeClass('selected');
        $(".filter[data-value='0']").addClass("selected");
        sessionStorage.setItem('tab', this.id);
        sessionStorage.setItem('link', $(this).data('url') );
        loadTab( sessionStorage.getItem('tab') );  
    }
});

$("#search-box").keyup(function(){
    filtrarLista( $(this).val().toLowerCase() );
});

if( sessionStorage.getItem('tab') === null) {
    sessionStorage.setItem('tab','encargos');
    sessionStorage.setItem('link', $( '#'+ sessionStorage.getItem('tab') ).data('url') );
}
loadTab( sessionStorage.getItem('tab') );

function setButtons() {
    $('.finalizar-encargo').on('click', function() {
        let btn = this;
        audioAlert.init();
        if( btn.classList.contains('concluir') ? encargoAction.concluir({btn:btn}) : encargoAction.rechazar({btn:btn}) ) {
            quitarEncargo(btn);
        }
    });
};

function quitarEncargo(btn) {
    $(btn).parent().parent().hide(150, function(){
        $(btn).parent().parent().remove();
    });
};
