import { urlProyect } from "./urlProyecto.js?wjhhe";
import { fnAlertTotalVentas } from "./urlProyecto.js?ufod";
fnAlertTotalVentas();
// fnAlertTotalVentas();
alertasDashboard();
UsuarioLogeado();
function UsuarioLogeado() {
  let Logeo = 0;
  $.ajax({
    url: urlProyect + "controller/DevolverDatos.php",
    type: "post",
    data: {
      Logeo,
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      $(".imagenUsuarioLogeado").attr(
        "src",
        urlProyect + `${respuesta.imgUsuario}`
      );
      $(".nombreUsuario").html(`${respuesta.usuario}`);
      $(".cargoUsuario").html(`${respuesta.cargo}`);
    },
  });
}
ActualizarEstadoCursos();
function ActualizarEstadoCursos() {
  let ActualizarEstadoCursos = 0;

  $.ajax({
    url: urlProyect + "controller/ejecutar_procedimientos.php",
    type: "post",
    data: {
      ActualizarEstadoCursos
    },
    dataType: "json",
    success: function (respuesta) {
     
      
    },
  });
}

$(document).on("click", "#logo-empresa", function () {
  location.href = urlProyect;
});
$(document).on("click", ".nom-simetrika", function () {
  location.href = urlProyect;
});

// // alertas dashboard/////

function alertasDashboard() {
  /* let fechaIni = $("#fecha_inicio").val();
    let fechaFin = $("#fecha_final").val();*/
  let dato = 3;
  $.ajax({
    url: urlProyect + "controller/alertas_dashboard.php",
    type: "post",
    data: {
      dato,
    },
    dataType: "json",
    success: function (respuesta) {
      
      $(".dNumeroTotal").html(`${respuesta.prospectosTotal}`);
      $(".dNumeroCSeguimiento").html(`${respuesta.prospectosTotalSeguidos}`);
      $(".dNumeroTotalVentas").html(respuesta.ventasTotal);
      $(".dNumeroVentas").html(`${respuesta.ventasTotalAbierta}`);
    },
  });
}
$(document).ready(main);

var contador = 1;

function main () {
	$('.menu_bar').click(function(){
		if (contador == 1) {
			$('nav').animate({
				left: '0'
			});
			contador = 0;
		} else {
			contador = 1;
			$('nav').animate({
				left: '-100%'
			});
		}
	});

	// Mostramos y ocultamos submenus
	$('.submenu').click(function(){
		$(this).children('.children').slideToggle();
	});
}