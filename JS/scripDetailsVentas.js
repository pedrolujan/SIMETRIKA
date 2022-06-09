import { urlProyect } from "./urlProyecto.js?hjhj";
import { msgAlertas } from "./urlProyecto.js?hjhj";
import { fnCargarLoader } from "./urlProyecto.js?hjhj";
import { fnIconosEdicionXEstadoVenta } from "./urlProyecto.js?hjhj";
import { fnBotonEdicionXEstadoVenta } from "./urlProyecto.js?hjhj";
import { fnBotonEditar } from "./urlProyecto.js?hjhj";
import { fnIconosModalidadClase } from "./urlProyecto.js?jmk";
const combos = document.querySelectorAll(".ContenedorBuscarVentas select");
const fechas = document.querySelectorAll(".ContenedorBuscarVentas input");

// combos.forEach((select) => {
//   select.addEventListener("change", fnBuscarVentas);
// });

// fechas.forEach((select) => {
//   select.addEventListener("change", fnBuscarVentas);
// });

fnBuscarDetalleVentas();

function fnBuscarDetalleVentas() {
  let codigoVenta = $("#txtCodVenta").val();
  let codigoCliente = $("#txtCodCliente").val();
  let idEvento = $("#txtidEvento").val();
  let BusquedaDetalleVenta = "ok";
  $.ajax({
    data: {
      codigoVenta,
      codigoCliente,
      idEvento,
      BusquedaDetalleVenta
    },
    url: urlProyect + "controller/ejecutar_procedimientos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      console.log(resp);
      let datos = JSON.parse(resp);
      let DetalleVenta = "";
      let datCliente="";
      let datEvento="";
      let icono;
      let boton;
      let i = 1;
      datos.forEach((ele) => {
        datCliente+=`<div class="m-0 p-0 col-12">
                        <div class="m-0 p-0 col-12">
                          <h6 class="m-0 p-0 col-12">Cliente</h6>
                          <hr class="m-1">
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 d-flex p-2">
                          <h5 class="col-4">${ele.nombresCliente+" "+ele.apellidosCliente}</h5>
                          <h5 class="col-4">${ele.correoCliente}</h5>
                          <h5 class="col-4">${ele.telefonoCliente}</h5>
                        </div>
                    </div>`;
          datEvento+=`<div class="m-0 p-0 col-12">
                        <div class="m-0 p-0 col-12">
                          <h6 class="m-0 p-0 col-12">Evento</h6>
                          <hr class="m-1">
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 d-flex p-2">
                          <h5 class="col-6">${ele.cDescripcion}</h5>
                          <h5 class="col-6">${ele.cNombreCampania}</h5>
                        </div>
                    </div>`;
        ele.detalleVenta.forEach((element) => {
          DetalleVenta += ` <tr captCodVenta="${element.idClaseRealizar}" capCodCliente="${ele.codCliente}"  class='celBusquedaCliente' id='celBusquedaCliente'>
                          
                          <td class="col-4"><span>${element.cNombreCortoCurso}</td>
                          <td class="col-1 text-center text-left-md"></span><span class="m-3">${fnIconosModalidadClase(element.cCodModalidad)}</span></td>                   
                          <td class="col-2 text-center text-left-md">${element.FechaInicioCurso}</td>                   
                          <td class="col-2 text-center text-left-md">${element.FechaFinalCurso}</td>                   
                          <td class="col-2 text-center">${element.cNomProgresoClase}</td>                   
                                      
                          <td class="mb-lg-0 d-lg-flex" capFechaIni="${element.fechaIni}" capFechaFin="${element.fechaFin}" capProgreso="${element.cCodProgresoClase}">
                            <span class="btnVerDetallesVenta">${fnBotonEdicionXEstadoVenta(element.CodEstadoventa)}</span>
                            <span class="ml-md-2 btnActualizarCursos"><a href="#formularioDatosDeClase" rel="modal:open">${fnBotonEditar()}</a></span>
                          </td>                   
                         
                         
                      </tr>`;
          i++;
        });
        
      });
      $(".contenedorCliente").html(datCliente);
      $(".contenedorEvento").html(datEvento);
      fnBorrarExportaciones();

      $(`tbody`).html(DetalleVenta);

      fnMostrarExportaciones();
    },
    error: function () {
      alert("error al cargar ventas");
    },
  });
}

$(document).on("click", ".btnVerDetallesVenta", function () {
  let element = $(this)[0].parentElement.parentElement;
  let Codventa = $(element).attr("captCodVenta");
  let idCliente = $(element).attr("capIdCliente");
  let url="../../consult-ventas/";
  var form = $('<form action="' + url + '" method="post">' +
  '<input type="hidden" name="codVenta"  value="' + Codventa + '" />' +
  '<input type="hidden" name="idAlumno"  value="' + idCliente + '" />' +
  '</form>');
$('body').append(form);
form.submit();
  // setTimeout(`location.href='../../consult-ventas/?codSale=${Codventa}&idCli=${idCliente}'`, 100);
});
$(document).on("click", ".btnActualizarCursos", function () {
  
  let elActualizar = $(this)[0].parentElement;
  let element = $(this)[0].parentElement.parentElement;
  let Codventa = $(element).attr("captCodVenta");
  let codCliente = $(element).attr("capCodCliente");
  // alert($(elActualizar).attr("capFechaIni"));

  $("#txtCodAlumnoMod").val(codCliente);
  $("#txtCodVentaMod").val(Codventa);
  $("#formularioDatosDeClase h5").html("Actualizar datos de curso");
  $("#btnGuardarVenta").val("Actualizar datos");
  $("#formularioDatosDeClase div.bg-warning span").html("¡ Actualizar correctamente las fechas y progreso del curso !");
  $("#dtFechaInicio").val($(elActualizar).attr("capFechaIni"));
  $("#dtFechaFin").val($(elActualizar).attr("capFechaFin"));
  $("#cboProgresoClase").val("'"+$(elActualizar).attr("capProgreso")+"'");
  // setTimeout(`location.href='../../consult-ventas/?codSale=${Codventa}&idCli=${idCliente}'`, 100);
});


$(document).on("click", "#btnGuardarVenta ", function (e) {
  e.preventDefault();
  if($("#btnGuardarVenta").val()=="Actualizar datos"){
    let Codventa=$("#txtCodVentaMod").val();
    let codCliente=$("#txtCodAlumnoMod").val();
    // alert("CodEvento "+Codventa+" idEvento "+codCliente);
    fnRegistrarActualizacionClase(Codventa,codCliente);
  }
});

function fnRegistrarActualizacionClase(Codventa,codCliente){
  fnCargarLoader("block");
  let ActualizarFechasCurso="clase";
  let dFechaIni=$("#dtFechaInicio").val();
  let dFechaFin=$("#dtFechaFin").val();
  let cboProgreso=$("#cboProgresoClase").val();
  $.ajax({
    data: {Codventa,codCliente,ActualizarFechasCurso,dFechaIni,dFechaFin,cboProgreso},
    url: urlProyect + "controller/ejecutar_procedimientos.php",
    type: "POST",
    dataType: "json",
    beforeSend: function () {},
    success: function (resp) {
      if (resp.ok != undefined) {
        msgAlertas("msjs", "alert-success", "alert-danger", resp.ok);
        fnBuscarDetalleVentas();
        setTimeout(function () {
          $(".cerrarModal").click();
        }, 200);
      } else {
        msgAlertas("msjs", "alert-danger", "alert-success", resp.error);
      }
      fnCargarLoader("none");
    },
    error: function (e) {
      console.log(e);
      alert("error En la venta" + e);
    },
  });

}

function fnBorrarExportaciones() {
  var table = $("#example").DataTable();
  table.destroy();
}

function fnMostrarExportaciones() {
  $("#example").DataTable({
    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      info: "Registros del _START_ al _END_ de _TOTAL_ registros",
      infoEmpty: "No se encontro resultados",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      sSearch: "Buscar:</br>",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Sig.",
        sPrevious: "Ant.",
      },
      sProcessing: "Procesando...",
    },
    // para usar los botones
    responsive: "true",
    dom: "fBrtilp",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<span>Excel</span> <i class="fas fa-file-excel"></i> ',
        titleAttr: "Exportar a Excel",
        className: "btn btn-success",
      },
      {
        extend: "pdfHtml5",
        text: '<span>PDF</span> <i class="fas fa-file-pdf"></i> ',
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger",
      },
      {
        extend: "print",
        text: '<span>Imprimir</span> <i class="fa fa-print"></i> ',
        titleAttr: "Imprimir",
        className: "btn btn-info",
      },
    ],
  });
}





