var url = window.location.pathname;
var urlId = url.substring(url.lastIndexOf('/')+1);
var Audio = new Audio();
Audio.volume = 1;

function remove_accent(str) {
    var map={'À':'A','Á':'A','Â':'A','Ã':'A','Ä':'A','Å':'A','Æ':'AE','Ç':'C','È':'E','É':'E','Ê':'E','Ë':'E','Ì':'I','Í':'I','Î':'I','Ï':'I','Ð':'D','Ñ':'N','Ò':'O','Ó':'O','Ô':'O','Õ':'O','Ö':'O','Ø':'O','Ù':'U','Ú':'U','Û':'U','Ü':'U','Ý':'Y','ß':'s','à':'a','á':'a','â':'a','ã':'a','ä':'a','å':'a','æ':'ae','ç':'c','è':'e','é':'e','ê':'e','ë':'e','ì':'i','í':'i','î':'i','ï':'i','ñ':'n','ò':'o','ó':'o','ô':'o','õ':'o','ö':'o','ø':'o','ù':'u','ú':'u','û':'u','ü':'u','ý':'y','ÿ':'y','Ā':'A','ā':'a','Ă':'A','ă':'a','Ą':'A','ą':'a','Ć':'C','ć':'c','Ĉ':'C','ĉ':'c','Ċ':'C','ċ':'c','Č':'C','č':'c','Ď':'D','ď':'d','Đ':'D','đ':'d','Ē':'E','ē':'e','Ĕ':'E','ĕ':'e','Ė':'E','ė':'e','Ę':'E','ę':'e','Ě':'E','ě':'e','Ĝ':'G','ĝ':'g','Ğ':'G','ğ':'g','Ġ':'G','ġ':'g','Ģ':'G','ģ':'g','Ĥ':'H','ĥ':'h','Ħ':'H','ħ':'h','Ĩ':'I','ĩ':'i','Ī':'I','ī':'i','Ĭ':'I','ĭ':'i','Į':'I','į':'i','İ':'I','ı':'i','Ĳ':'IJ','ĳ':'ij','Ĵ':'J','ĵ':'j','Ķ':'K','ķ':'k','Ĺ':'L','ĺ':'l','Ļ':'L','ļ':'l','Ľ':'L','ľ':'l','Ŀ':'L','ŀ':'l','Ł':'L','ł':'l','Ń':'N','ń':'n','Ņ':'N','ņ':'n','Ň':'N','ň':'n','ŉ':'n','Ō':'O','ō':'o','Ŏ':'O','ŏ':'o','Ő':'O','ő':'o','Œ':'OE','œ':'oe','Ŕ':'R','ŕ':'r','Ŗ':'R','ŗ':'r','Ř':'R','ř':'r','Ś':'S','ś':'s','Ŝ':'S','ŝ':'s','Ş':'S','ş':'s','Š':'S','š':'s','Ţ':'T','ţ':'t','Ť':'T','ť':'t','Ŧ':'T','ŧ':'t','Ũ':'U','ũ':'u','Ū':'U','ū':'u','Ŭ':'U','ŭ':'u','Ů':'U','ů':'u','Ű':'U','ű':'u','Ų':'U','ų':'u','Ŵ':'W','ŵ':'w','Ŷ':'Y','ŷ':'y','Ÿ':'Y','Ź':'Z','ź':'z','Ż':'Z','ż':'z','Ž':'Z','ž':'z','ſ':'s','ƒ':'f','Ơ':'O','ơ':'o','Ư':'U','ư':'u','Ǎ':'A','ǎ':'a','Ǐ':'I','ǐ':'i','Ǒ':'O','ǒ':'o','Ǔ':'U','ǔ':'u','Ǖ':'U','ǖ':'u','Ǘ':'U','ǘ':'u','Ǚ':'U','ǚ':'u','Ǜ':'U','ǜ':'u','Ǻ':'A','ǻ':'a','Ǽ':'AE','ǽ':'ae','Ǿ':'O','ǿ':'o'};
    var res='';
    for (var i=0;i<str.length;i++){
        c=str.charAt(i);
        res+=map[c]||c;
    }
    return res;
}

function filtrarLista() {
    var value =  remove_accent( $('#filtrarContactos').val().toLowerCase() );
    $(".contact-list > .contact-item").each(function() {
        if ( remove_accent( $(this).data('nombre').toLowerCase()+' '+$(this).data('email').toLowerCase() ).search(value) > -1) {
            $(this).show();
        }
        else {
            $(this).fadeOut(300);
        }
    });
}

$("#encargoForm").submit(function(e) {
    Audio.src = '/sound/null.mp3';
    Audio.play();
    $('#encargoForm input, #encargoForm textarea').attr('readonly', 'readonly');
    $('#encargoForm button').attr('disabled', 'disabled');
    e.preventDefault(); // avoid to execute the actual submit of the form.
    $.ajax({
        type: "POST",
        url: $("#encargoForm").data("url")+"/"+$("#encargoForm").data("contacto"),
        dataType: 'json',
        data: $("#encargoForm").serialize(), // serializes the form's elements.
        success: function(data) {
            Audio.src ='/sound/send_1.mp3';
            Audio.play();
            $( "#alerta" ).removeClass('alert-success alert-danger alert-warning alert-info show');
            $( "#alerta" ).css('z-index','-9999');
            $( "#closeAlert" ).removeClass('d-none');
            $( "#alert-field" ).empty();
            $( "#alerta" ).addClass('alert-success show');
            $( "#alerta" ).css('z-index','9999');
            $( "#alert-field" ).append('<p>'+data.message+'</p>');
            $('#encargoForm')[0].reset();
            $('#encargoForm input, #encargoForm textarea').removeAttr("readonly");
            $('#encargoForm button').removeAttr("disabled");
        },
        error: function(error) {
            Audio.src = '/sound/error_1.mp3';
            Audio.play();
            $( "#alerta" ).removeClass('alert-success alert-danger alert-warning alert-info show');
            $( "#alerta" ).css('z-index','-9999');
            $( "#closeAlert" ).removeClass('d-none');
            $( "#alert-field" ).empty();

            var data = error.responseJSON;
            $( "#alert-field" ).append('<p>'+data.message+'</p>');
            var list = '<ul>';
            $.each(data.errors, function(i, item) {
                if (item.constructor === Array) {
                    $.each(item, function(f, foo) {
                       list += "<li>" + foo + "</li>"
                    });
                }
            });
            list += '</ul>';
            $( "#alert-field" ).append(list);
            $( "#alerta" ).addClass('alert-danger show');
            $( "#alerta" ).css('z-index','9999');
            $('#encargoForm input, #encargoForm textarea').removeAttr("readonly");
            $('#encargoForm button').removeAttr("disabled");    
        }        
    });
});

$("#closeAlert").click(function(){ 
    $( "#alerta" ).removeClass('alert-success alert-danger alert-warning alert-info show');
    $( "#closeAlert" ).addClass('d-none');
    $( "#alerta" ).css('z-index','-9999');
    $( "#alert-field" ).empty();
});

$(".contact-item").click(function(){ 
    $('#pagina-contacto, #pagina-encargo, #block-responsable').toggleClass('d-none');
    $('#encargoForm').data('contacto',$(this).data('id'));
    $('#responsable').text( $(this).data('nombre') );
    $("#encargo").focus();
    $('#filtrarContactos').val('');
    filtrarLista();
});

$("#cambioResponsable").click(function(){
    $('#pagina-contacto, #pagina-encargo, #block-responsable').toggleClass('d-none');
    $('#responsable').text( $(this).data('') );
    $('#encargoForm')[0].reset();
    $("#filtrarContactos").focus();
});


$( document ).ready(function() {
    console.log(urlId);
    var responsable = $("[data-id='" + urlId +"']").data('nombre');
    console.log(responsable);
    if(!isNaN(urlId)){
        $('#pagina-contacto, #pagina-encargo, #block-responsable').toggleClass('d-none');
        $('#encargoForm').data('contacto', urlId);
        $('#responsable').text(responsable);
        $("#encargo").focus();
    }
});