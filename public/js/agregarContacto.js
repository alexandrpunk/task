var url = window.location.pathname;
var urlId = url.substring(url.lastIndexOf('/')+1);
var Audio = new Audio();
Audio.volume = 1;

$("#contactoForm").submit(function(e) {
    Audio.src = '/sound/null.mp3';
    Audio.play();
    $('#contactoForm input').attr('readonly', 'readonly');
    $('#contactoForm button').attr('disabled', 'disabled');
    e.preventDefault(); // avoid to execute the actual submit of the form.
    $.ajax({
        type: "POST",
        url: $("#contactoForm").data("url"),
        dataType: 'json',
        data: $("#contactoForm").serialize(), // serializes the form's elements.
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
            $('#contactoForm')[0].reset();
            $('#contactoForm input').removeAttr("readonly");
            $('#contactoForm button').removeAttr("disabled");
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
            $('#contactoForm input').removeAttr("readonly");
            $('#contactoForm button').removeAttr("disabled");    
        }        
    });
});

$("#closeAlert").click(function(){ 
    $( "#alerta" ).removeClass('alert-success alert-danger alert-warning alert-info show');
    $( "#closeAlert" ).addClass('d-none');
    $( "#alerta" ).css('z-index','-9999');
    $( "#alert-field" ).empty();
});
