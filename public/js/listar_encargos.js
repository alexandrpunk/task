$(document).ready(function() {
    $("#filtrar").click(function(){
        $.ajax({
            type: "GET",
            url: $(this).attr('data-url')+'/'+$( "#estados_tareas" ).val(),
            success: function(result){
                $("#tareas").empty();
                $("#tareas").html(result);
                console.log(result);
            }
        });
    });
});

