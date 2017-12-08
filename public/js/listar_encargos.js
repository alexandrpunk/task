$(document).ready(function() {
    $(".filter").click(function(event){
      event.preventDefault();
      $(".filter").removeClass('selected');
      $(this).addClass('selected');
      $.ajax({
          type: "GET",
          url: $(this).attr('href')+'/'+$(this).attr('data-value'),
          success: function(result){
              $("#encargos").empty();
              $("#encargos").html(result);
              console.log(result);
          }
      });
    });
});

filtrarLista = function(id, sel, filter) {
    var a, b, c, i, ii, iii, hit;
    a = w3.getElements(id);
    for (i = 0; i < a.length; i++) {
      b = w3.getElements(sel);
      for (ii = 0; ii < b.length; ii++) {
        hit = 0;
        if (b[ii].innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
          hit = 1;
        }
        c = b[ii].getElementsByTagName("*");
        for (iii = 0; iii < c.length; iii++) {
          if (c[iii].innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
            hit = 1;
          }
        }
        if (hit == 1) {
          b[ii].style.display = "";
        } else {
          b[ii].style.display = "none";
        }
      }
    }
  };