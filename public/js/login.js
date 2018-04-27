$("#login-form").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    audioAlert.init();
    $.ajax({
        type: "POST",
        url: $("#login-form").data('url'),
        dataType: 'json',
        data:  $("#login-form").serialize(), // serializes the form's elements.
        beforeSend: function(){
            $('#login-form input').prop('readonly', true);
            $('#login-form button').prop('disabled', true);
        },
        success: function(data) {
            audioAlert.success();
            location.reload();
        },
        error: function(error) {
            let errors = [error.responseJSON.errors];
            notify.danger({msj:error.responseJSON.message,list:errors});
            audioAlert.error();
        },
        complete: function(){
            $('#login-form input').prop('readonly', false);
            $('#login-form button').prop('disabled', false);
        }     
    });
});