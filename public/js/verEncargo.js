$("#silenciar").on('click', function(){
    audioAlert.click();
    $.ajax({
        type: "GET",
        url: $(this).attr('data-url'),
        beforeSend: function() {
            $("#silenciar").prop('disabled', true);
        },
        success: function(result){
            $("#silenciar").toggleClass('text-muted text-dark');
            $("#mute-icon").toggleClass('fa-bell fa-bell-slash');
            $('#silenciar').data('muted', ( $('#silenciar').data('muted') ) ?  0: 1);
        },
        complete:function() {
            $("#silenciar").prop('disabled', false);
        }
    });
});

$('.finalizar-encargo').on('click', function() {
    let btn = this;
    audioAlert.init();
    if ( btn.classList.contains('concluir') ) {
        encargoAction.concluir({btn:btn,final:concluirEncargo});
    } else {
        encargoAction.rechazar({btn:btn,final:concluirEncargo});
    }
});

$("#comentarios-form").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    audioAlert.init();
    $.ajax({
        type: "POST",
        url: $("#comentarios-form").data('url'),
        dataType: 'json',
        data: $("#comentarios-form").serialize(), // serializes the form's elements.
        beforeSend: function(){
            $('#comentarios-form input, #comentarios-form textarea').prop('readonly', true);
            $('#comentarios-form button').prop('disabled', true);            
        },
        success: function(data) {
            $('#comentarios-form')[0].reset();
            notify.success({msj:data.message});
            audioAlert.success();
            appendComent(data.comentario);
        },
        error: function(error) {
            if (error.responseJSON.errors) {
                let errors = [];
                Object.values(error.responseJSON.errors).forEach(function (e) {           
                    Object.values(e).forEach(function(f) {
                        errors.push(f);
                    });
                });
                notify.danger({msj:error.responseJSON.message,list:errors});
            } else {
                notify.danger({msj:error.responseJSON.message});                
            }
            audioAlert.error();
        },
        complete: function(){
            $('#comentarios-form input, #comentarios-form textarea').removeAttr("readonly");
            $('#comentarios-form button').removeAttr("disabled");
        }     
    });
});



function appendComent(comentario) {
    let noComent = document.getElementById('no-coment-text');
    if (noComent != null) {
        noComent.parentNode.removeChild(noComent);
    } 
    let coment = document.createElement('div');
    coment.className = 'comentario';

    let nombre = document.createElement ('label');
    nombre.className = 'text-info';
    nombre.innerText = comentario.nombre+' comento:';
    coment.appendChild(nombre);

    let hora = document.createElement('small');
    hora.className = 'pull-right text-muted'
    hora.innerText = comentario.hora;
    coment.appendChild(hora);

    let textComent = document.createElement('p');
    textComent.innerText = comentario.comentario;
    coment.appendChild(textComent);

    document.getElementById('comentarios').appendChild(coment);    
}

function concluirEncargo (data) {
    $('#encargo').css('border-left-color',data.estado.color);
    document.getElementById('svg-inline--fa-title-1').innerHTML = data.estado.nombre;
    $('#encargo-opciones').fadeOut(200, function() { $('#encargo-opciones').remove(); });
    $('#silenciar').fadeOut(200, function () { $('#silenciar').remove(); });
};