$("#password-request-form").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    audioAlert.init();
    $.ajax({
        type: "POST",
        url: $("#password-request-form").data('url'),
        dataType: 'json',
        data:  $("#password-request-form").serialize(), // serializes the form's elements.
        beforeSend: function(){
            $('#password-request-form input').prop('readonly', true);
            $('#password-request-form :input[type="submit"], #password-request-form :input[type="reset"]').prop('disabled', true);
        },
        success: function(data) {
            notify.success( {msj:data.message} );
            audioAlert.success();
        },
        error: function(error) {
            let errors = [error.responseJSON.errors];
            notify.danger({msj:error.responseJSON.message,list:errors});
            audioAlert.error();
            $('#password-request-form input').prop('readonly', false);
            $('#password-request-form :input[type="submit"], #password-request-form :input[type="reset"]').prop('disabled', false);
        }    
    });
});

$("#reestablecer-form").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    audioAlert.init();
    $.ajax({
        type: "POST",
        url: $("#reestablecer-form").data('url'),
        dataType: 'json',
        data:  $("#reestablecer-form").serialize(), // serializes the form's elements.
        beforeSend: function(){
            $('#reestablecer-form input').prop('readonly', true);
            $('#reestablecer-form :input[type="submit"], #reestablecer-form :input[type="reset"]').prop('disabled', true);
        },
        success: function(data) {
            audioAlert.success();
            location.reload();
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
            $('#reestablecer-form input').prop('readonly', false);
            $('#reestablecer-form :input[type="submit"], #reestablecer-form :input[type="reset"]').prop('disabled', false);
        }   
    });
});