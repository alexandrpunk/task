function remove_accent(str) {
    var map={'À':'A','Á':'A','Â':'A','Ã':'A','Ä':'A','Å':'A','Æ':'AE','Ç':'C','È':'E','É':'E','Ê':'E','Ë':'E','Ì':'I','Í':'I','Î':'I','Ï':'I','Ð':'D','Ñ':'N','Ò':'O','Ó':'O','Ô':'O','Õ':'O','Ö':'O','Ø':'O','Ù':'U','Ú':'U','Û':'U','Ü':'U','Ý':'Y','ß':'s','à':'a','á':'a','â':'a','ã':'a','ä':'a','å':'a','æ':'ae','ç':'c','è':'e','é':'e','ê':'e','ë':'e','ì':'i','í':'i','î':'i','ï':'i','ñ':'n','ò':'o','ó':'o','ô':'o','õ':'o','ö':'o','ø':'o','ù':'u','ú':'u','û':'u','ü':'u','ý':'y','ÿ':'y','Ā':'A','ā':'a','Ă':'A','ă':'a','Ą':'A','ą':'a','Ć':'C','ć':'c','Ĉ':'C','ĉ':'c','Ċ':'C','ċ':'c','Č':'C','č':'c','Ď':'D','ď':'d','Đ':'D','đ':'d','Ē':'E','ē':'e','Ĕ':'E','ĕ':'e','Ė':'E','ė':'e','Ę':'E','ę':'e','Ě':'E','ě':'e','Ĝ':'G','ĝ':'g','Ğ':'G','ğ':'g','Ġ':'G','ġ':'g','Ģ':'G','ģ':'g','Ĥ':'H','ĥ':'h','Ħ':'H','ħ':'h','Ĩ':'I','ĩ':'i','Ī':'I','ī':'i','Ĭ':'I','ĭ':'i','Į':'I','į':'i','İ':'I','ı':'i','Ĳ':'IJ','ĳ':'ij','Ĵ':'J','ĵ':'j','Ķ':'K','ķ':'k','Ĺ':'L','ĺ':'l','Ļ':'L','ļ':'l','Ľ':'L','ľ':'l','Ŀ':'L','ŀ':'l','Ł':'L','ł':'l','Ń':'N','ń':'n','Ņ':'N','ņ':'n','Ň':'N','ň':'n','ŉ':'n','Ō':'O','ō':'o','Ŏ':'O','ŏ':'o','Ő':'O','ő':'o','Œ':'OE','œ':'oe','Ŕ':'R','ŕ':'r','Ŗ':'R','ŗ':'r','Ř':'R','ř':'r','Ś':'S','ś':'s','Ŝ':'S','ŝ':'s','Ş':'S','ş':'s','Š':'S','š':'s','Ţ':'T','ţ':'t','Ť':'T','ť':'t','Ŧ':'T','ŧ':'t','Ũ':'U','ũ':'u','Ū':'U','ū':'u','Ŭ':'U','ŭ':'u','Ů':'U','ů':'u','Ű':'U','ű':'u','Ų':'U','ų':'u','Ŵ':'W','ŵ':'w','Ŷ':'Y','ŷ':'y','Ÿ':'Y','Ź':'Z','ź':'z','Ż':'Z','ż':'z','Ž':'Z','ž':'z','ſ':'s','ƒ':'f','Ơ':'O','ơ':'o','Ư':'U','ư':'u','Ǎ':'A','ǎ':'a','Ǐ':'I','ǐ':'i','Ǒ':'O','ǒ':'o','Ǔ':'U','ǔ':'u','Ǖ':'U','ǖ':'u','Ǘ':'U','ǘ':'u','Ǚ':'U','ǚ':'u','Ǜ':'U','ǜ':'u','Ǻ':'A','ǻ':'a','Ǽ':'AE','ǽ':'ae','Ǿ':'O','ǿ':'o'};
    var res='';
    for (var i=0;i<str.length;i++){
        c=str.charAt(i);
        res+=map[c]||c;
    }
    return res;
}
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
        complete: function(result){
            $("#canvas-panel").fadeIn(150);            
            $("li[id^='add-']").hide();     
            $("#add-"+tab).fadeIn(150);
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
            $("#canvas-panel").fadeIn(150);   
        }
    });
});

$('#search').click(function (event) {
    $('#main-nav').hide();
    $('#search-nav').fadeIn(150);
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

$('.nav-item').click(function(e){
    if ( !$(this).hasClass('active') ) {
        closeSearch();
        $(".filter").removeClass('selected');
        $(".filter[data-value='0']").addClass("selected");
        sessionStorage.setItem('tab', this.id);
        sessionStorage.setItem('link', $(this).data('url') );
        loadTab( sessionStorage.getItem('tab') );
        console.log(sessionStorage.getItem('link'));    
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