  $(document).ready(function(){
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $('.modal').modal();
    cargarPaginacion(1);

    document.querySelectorAll(".-b-expander").forEach(function(el) {
      el.addEventListener("click", () => {
        el.classList.toggle("-b-text-undexpanded");
      });
    });
  });

  function cargarPaginacion(page){
    var url = "../testcastores/php/back.php/cargarPaginacion";
    var data = {
      page : page,
      accion  : "cargarPaginacion"
    };
    $('#loager').fadeIn('slow');
    $.ajax({
      data: data,
      url: url,
      type: 'post',
      beforeSend: function () {
        $("#loager").html("<div class='progress'><div class='indeterminate'></div></div>");
      },
      error: function(){
        Swal.fire(
          'Error con servidor',
          'Hubo problemas al mandar la información, intente más tarde',
          'error'
        );
      },
      success: function(response){
        $(".outer_div").html(response).fadeIn('slow');
        $('#loader').html("");
      }
    });
  }