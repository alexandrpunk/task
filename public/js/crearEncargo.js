var url = window.location.pathname;
let urlId = url.substring(url.lastIndexOf('/')+1);
let responsable = $("[data-id='" + urlId +"']").data('nombre');
if(!isNaN(urlId)){
    $('#pagina-encargo').fadeIn(200);
    $('#encargoForm').data('contacto', urlId);
    $('#responsable').text(responsable);
    $("#encargo").focus();
} else {
    $('#pagina-contacto').fadeIn(200);
}

document.getElementById('filtrarContactos').addEventListener('keyup',function () {
    let value =  remove_accent( $('#filtrarContactos').val().toLowerCase() );
    $(".contact-list > .contact-item").each(function() {
        if ( remove_accent( $(this).data('nombre').toLowerCase()+' '+$(this).data('email').toLowerCase() ).search(value) > -1) {
            $(this).show();
        }
        else {
            $(this).fadeOut(200);
        }
    });
});

$("#encargoForm").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    audioAlert.init();
    $.ajax({
        type: "POST",
        url: $("#encargoForm").data("url")+"/"+$("#encargoForm").data("contacto"),
        dataType: 'json',
        data: $("#encargoForm").serialize(), // serializes the form's elements.
        beforeSend: function(){
            $('#encargoForm input, #encargoForm textarea').attr('readonly', 'readonly');
            $('#encargoForm button').attr('disabled', 'disabled');
        },
        success: function(data) {
            $('#encargoForm')[0].reset();
            notify.success({msj:data.message});
            audioAlert.success();
        },
        error: function(error) {
            let errors = [];
            Object.values(error.responseJSON.errors).forEach(function (e) {           
                Object.values(e).forEach(function(f) {
                    errors.push(f);
                });
            });
            notify.danger({msj:error.responseJSON.message,list:errors});
            audioAlert.error();
        },
        complete: function(){
            $('#encargoForm input, #encargoForm textarea').removeAttr("readonly");
            $('#encargoForm button').removeAttr("disabled");
        }     
    });
});

$(".contact-item").click(function(){ 
    $('#pagina-contacto').hide();
    $('#encargoForm').data('contacto',$(this).data('id'));
    $('#responsable').text( $(this).data('nombre') );
    $('#pagina-encargo').fadeIn(200);
    $("#encargo").focus();
    $('#filtrarContactos').val('');
});

$("#cambioResponsable").click(function(){
    $('#pagina-encargo').hide();
    $('#responsable').text( $(this).data('') );
    $('#encargoForm')[0].reset();
    $("#filtrarContactos").focus();
    $('#pagina-contacto').fadeIn(200);
});