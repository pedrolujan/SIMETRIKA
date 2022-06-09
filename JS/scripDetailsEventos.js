import { urlProyect } from "./urlProyecto.js?hjhj";
import { msgAlertas } from "./urlProyecto.js?hjhj";
import { fnCargarLoader } from "./urlProyecto.js?hjhj";
import { fnIconosEdicionXEstadoVenta } from "./urlProyecto.js?hjhj";
import { fnBotonEdicionXEstadoVenta } from "./urlProyecto.js?hjhj";
import { fnBotonEditar } from "./urlProyecto.js?hjhj";
import { fnBorrarExportaciones } from "./urlProyecto.js?hjhj";
import { fnMostrarExportaciones } from "./urlProyecto.js?hjhj";
import { fnIconosModalidadClase } from "./urlProyecto.js?jmk";
const combos = document.querySelectorAll(".ContenedorBuscarVentas select");
const fechas = document.querySelectorAll(".ContenedorBuscarVentas input");

// combos.forEach((select) => {
//   select.addEventListener("change", fnBuscarVentas);
// });

// fechas.forEach((select) => {
//   select.addEventListener("change", fnBuscarVentas);
// });

fnBuscarDetalleEventos();

function fnBuscarDetalleEventos() {

  let codigoEvento = $("#txtCodEvento").val();
  let BusquedaDetalleEventos = "ok";
  $.ajax({
    data: {
      codigoEvento,
      BusquedaDetalleEventos
    },
    url: urlProyect + "controller/ejecutar_procedimientos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      alert(resp);
      console.log(resp);
      let datos = JSON.parse(resp);
      let DetalleVenta = "";
      let datCliente="";
      let datEvento="";
      let icono;
      let boton;
      let i = 1;
      datos.forEach((ele) => {
        
        datEvento+=`<div class="m-0 p-0 col-12">
                        <div class="m-0 p-0 col-12">
                          <h6 class="m-0 p-0 col-12">Evento</h6>
                          <hr class="m-1">
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 d-flex p-2">
                          <h5 class="col-1">${ele.idEvento}</h5>
                          <h5 class="col-5">${ele.cDescripcion}</h5>
                          <h5 class="col-4">${ele.cCodModalidad}</h5>
                          <h5 class="col-2">${ele.importeMonedaCambio}</h5>
                        </div>
                    </div>`;
        ele.certificado.forEach((element) => {
          DetalleVenta += ` <tr captIdDetalleEvento="${element.idDetalleEvento}"  class='celBusquedaCliente' id='celBusquedaCliente'>
                          
                          <td class="col-1"><span>${i}</td>
                          <td class="col-4"><span>${element.cNombreCortoCurso}</td>
                          <td class="col-2 text-center text-left-md">
                            <img src="${urlProyect+element.disenioFrontal}" width="100" alt="" srcset="">                       
                          </td>                   
                          <td class="col-2 text-center text-left-md">
                            <img src="${urlProyect+element.disenioPosterior}" width="100" alt="" srcset="">
                          </td>                   
                                   
                          <td class="mb-lg-0 col-2 text-center" captIdDetalleEvento="${element.idDetalleEvento}">
                            <span class="ml-md-2 btnActualizarCertificado"><a href="#formularioDatosDeClase" rel="modal:open">${fnBotonEditar()}</a></span>
                          </td>                   
                         
                         
                      </tr>`;
          i++;
        });
        
      });
      $(".contenedorDatosEvento").html(datEvento);

      fnBorrarExportaciones("example");

      $(`#tbListarTemplante`).html(DetalleVenta);

      fnMostrarExportaciones("example","Buscar Certificado","fBrtilp");
    },
    error: function () {
      alert("error al cargar ventas");
    },
  });
}

$(document).on("click",".btnActualizarCertificado",function(){
  alert("Esta Funcion aun no se encuentra disponible.");
})