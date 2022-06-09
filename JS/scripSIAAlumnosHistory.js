import { urlProyect } from "./urlProyecto.js?hjhj";
import { fnIconosModalidadClase } from "./urlProyecto.js?jmk";
import { fnTipoOpcionContextmenu } from "./urlProyecto.js?jmk";
import { fnCargarLoader } from "./urlProyecto.js?hjhj";
import { msgAlertas } from "./urlProyecto.js?hjhj";
import { fnBorrarExportaciones } from "./urlProyecto.js?hjhj";
import { fnMostrarExportaciones } from "./urlProyecto.js?hjhj";
// import { fnBotonEditar } from "./urlProyecto.js?hjhj";

const combos = document.querySelectorAll(".ContenedorFiltrar select");
const fechas = document.querySelectorAll(".ContenedorFiltrar input");
// codigo para abrir modal sobre modal
combos.forEach((select) => {
  // select.addEventListener("change", fnBuscarAlumnosXCurso);
});

fechas.forEach((select) => {
  // select.addEventListener("change", fnBuscarAlumnosXCurso);
});

fnBuscarHistorialCliente();
// codigo para el historial de los alumnos
$(document).on("click", "#btn-SIA_A-busHistory", function () {
  $("#rbCliente").click();
  $(".lblRbProspecto").css("display", "none");
});

$(document).on("click", "#rbCliente", function () {
  // alert("click");
  $(".divdinamicosBusqueda").addClass("d-none");
  $(".divdinamicosBusqueda").removeClass("d-block");
  $(".contenCampaniaBusq").addClass("col-lg-10");
  $(".contenCampaniaBusq").removeClass("col-lg-4");
  $("#headerNombresAlumno").html("Cliente");
});

$(document).on("keypress", "#txtBuscarClienteModal", function (e) {
  var code = e.keyCode ? e.keyCode : e.which;
  if (code == 13) {
    e.preventDefault();
    let pcBuscar = $("#txtBuscarClienteModal").val();
    let RadioButon = $("input:radio[name=rbtipoBusqueda]:checked").val();
    let Campania = $("#cboCampaniaModal").val();
    let Evento = $("#cboEventoModal").val();
    let CursoXevento = $("#cboCursosXevento").val();
    let FechaInicio = $("#fecha_inicio").val();
    let FechaFinal = $("#fecha_final").val();

    // alert("Radio " +  RadioButon +  " Campania " +  Campania +  " Evento " +  Evento +  " Curso " +  CursoXevento +  " fecha inicio " +  FechaInicio +  " fecha final " +  FechaFinal);
    $.ajax({
      data: {
        pcBuscar,
        RadioButon,
        Campania,
        Evento,
        CursoXevento,
        FechaInicio,
        FechaFinal,
      },
      url: "../../../../controller/DevolverDatos.php",
      type: "post",
      beforeSend: function () {},
      success: function (resp) {
        console.log(resp);
        let datos = JSON.parse(resp);
        let Prospectos = "";
        let i = 1;
        datos.forEach((element) => {
          Prospectos += ` 
                <tr captIdCliente="${element.id}" captCodCliente="${element.codCliente}" class='celBusquedaCliente' id='celBusquedaCliente'>
                    <td class="col-1" style="width: 1px;">${i}</td>
                    <td class="col-4">${element.nombre}</td>
                    <td class="col-4">${element.email}</td>
                    <td class="col-3">${element.telefono}</td>                   
                   
                </tr>`;
          i++;
        });

        $(`#tbodyBuscarClientes`).html(Prospectos);

        $("div.holder").jPages({
          containerID: "tbodyBuscarClientes",
          perPage: 10,
          startPage: 1,
          midRange: 2,
          previous: "an",
          next: "sig",
        });

        $(`#Contenedor_Loader`).hide();
      },
      error: function (ex) {
        console.log("error al cargar Alumnos" + ex);
      },
    });
  }
});

// capturar cliente especifico
$(document).on("dblclick", ".celBusquedaCliente", function () {
  let element = $(this)[0];
  let idCliente = $(element).attr("captIdCliente");
  let codCliente = $(element).attr("captCodCliente");
  $("#txtCodCliente").val(codCliente);
  fnBuscarHistorialCliente();
  $("#btnCerrarModal").click();
});

function fnBuscarHistorialCliente() {
  let codCliente = $("#txtCodCliente").val();
  let BusquedaHistoryAlumno = "ok";
  $.ajax({
    data: {
      codCliente,
      BusquedaHistoryAlumno,
    },
    url: urlProyect + "controller/ejecutar_procedimientos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      fnBorrarExportaciones("tbHistoryAlumnos");
      console.log(resp);
      // return;
      let datos = JSON.parse(resp);
      let datosHistorial = "";
      let AlumnoEspecifico = "";
      let i = 0;
      datos.forEach((element) => {
        AlumnoEspecifico += `<div class="pt-2 pl-0 pr-0 d-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 align-items-center" style="border-bottom:solid 1px #ccc; background: #ccc;">
                              <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-6 ">
                                <h6 style="font-weight: bold;">Nombres</h6>
                              </div>
                              <div class="col-6 p-2 d-flex align-items-center">
                                <div class="col-5 d-none d-lg-block">Correo</div>
                                <div class="col-4">Telefono</div>
                                <div class="col-3">Pais</div>
                              </div>  
                          </div>
                        <div class="pt-2 pb-2 pl-0 pr-0 d-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 align-items-center" style="border-bottom:solid 1px #ccc;">
                            <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-6 ">
                              <h6 style="font-weight: bold;">${element.nombreAlumno}</h6>
                            </div>
                            <div class="col-6 p-2 d-flex align-items-center">
                              <div class="col-5 d-none d-lg-block">${element.correo}</div>
                              <div class="col-4">${element.telefono}</div>
                              <div class="col-3">${element.Nombre_pais}</div>
                            </div>  
                        </div>
                        `;

        element.historial.forEach((ele) => {
          datosHistorial += ` 
                <tr  class="trAlumnos">
                    <td class="tdNumero" style="width: 10px;" width="10px">${i+1}</td>
                   
                    <td class="tdCliente col-3">${ele.nombreCruso}</td>
                    <td class="col-2 text-center" >
                    <div class="col-12 d-flex justify-content-around">
                      <span>${ele.modalidad=="MODV0001"?"Live":"Ondemand"}</span>
                      <span>${fnIconosModalidadClase(ele.modalidad)}</span>
                    </div>
                    </td>
                    <td class="col-1 text-center">
                      <span class="spnNotas">${ele.promedio??0}</span>
                    </td>
                    <td class="col-1 text-center">
                      <span class="spnNotas">${ele.fechaIni}</span>
                    </td>
                    <td class="col-1 text-center">
                      <span class="spnNotas">${ele.fechaFin}</span>
                    </td>
                    <td class="col-1 text-center">
                      <span class="spnNotas">${ele.importeTotal}</span>
                     
                    </td>
                </tr>`;
          i++;
        });
      });

      $(".contenedorDatosAlumno").html(AlumnoEspecifico);
      $("#tbHistoryAlumnosBody").html(datosHistorial);
      fnMostrarExportaciones("tbHistoryAlumnos", "Buscar Historial", "fBrtilp");
      fnCargarLoader("none");
    },
    error: function () {
      alert("error al cargar ventas");
    },
  });
}