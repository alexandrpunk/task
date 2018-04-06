$("#contactoForm").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    notify.closeAll();
    audioAlert.init();
    $('#contactoForm input').attr('readonly', 'readonly');
    $('#contactoForm button').attr('disabled', 'disabled');
    $.ajax({
        type: "POST",
        url: $("#contactoForm").data("url"),
        dataType: 'json',
        data: $("#contactoForm").serialize(), // serializes the form's elements.
        beforeSend:function () {
            
        },
        success: function(data) {
            notify.success({msj:data.message});
            audioAlert.success();
        },
        error: function(error) {
            notify.danger({msj:error.responseJSON.message});
            audioAlert.error();
        },
        complete: function () {
            $('#contactoForm input').removeAttr('readonly');
            $('#contactoForm button').removeAttr('disabled');
        }
    });
});