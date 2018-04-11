document.getElementById('editar').addEventListener('click', function (){
    $( "#editar" ).fadeOut(150,function () {
        $( "#guardar, #cancelar" ).fadeIn(150);        
    });
    $('#perfil-form input').prop("disabled", false);
});

document.getElementById('cancelar').addEventListener('click', function (){
    $( "#guardar, #cancelar" ).fadeOut(150,function () {
        $( "#editar" ).fadeIn(150);  
    });
    $("#display, #nombre, #apellido, #telefono").prop("disabled", true);
});

$("#perfil-form").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    audioAlert.init();
    let formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: $("#perfil-form").data('url'),
        dataType: 'json',
        data: formData, // serializes the form's elements.
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#perfil-form button').prop('disabled', true);
            $('#perfil-form input').prop('readonly', true);          
        },
        success: function(data) {
            notify.success({msj:data.message});
            audioAlert.success();
            $( "#guardar, #cancelar" ).fadeOut(150,function () { $( "#editar" ).fadeIn(150); });
            $('#perfil-form input').prop('disabled', true);
            $('.display').attr('src', '/storage/profile/'+data.userData.display);
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
            $('#perfil-form input').prop('readonly', false); 
            $('#perfil-form button').prop('disabled', false);
        }     
    });
});