import { urlProyect } from "./urlProyecto.js";
// import { msgAlertas } from "./urlProyecto.js?hjhj";
import { fnBorrarExportaciones } from "./urlProyecto.js?hjhj";
import { fnMostrarExportaciones } from "./urlProyecto.js?hjhj";
// import { funcionMensaje } from "./urlProyecto";
fnBuscarProspectosPorPersonal(0);

$(document).on("click", "#personalUnico", function () {
  let element = $(this)[0];
  let idPersonal = $(element).attr("capId");
  $("#txtMidPersonal").val(idPersonal);
  $("#txtIdPersonal").val(idPersonal);
  fnBuscarProspectosPorPersonal(0);
});

$(document).on("change", "#CboCampania", function () {
  let idCampania = $("#CboCampania").val();
  $.ajax({
    data: {
      idCampania,
    },
    url: urlProyect + "controller/DevolverDatos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      $("#CboCursos").html(resp);
    },
    error: function () {
      alert("error");
    },
  });
});
// codigo para accede al prospecto especifico del usuario que realizo el segimiento especifico
$(document).on("click", ".celProspecto", function () {
  let element = $(this)[0];
  let id = $(element).attr("captIdProspecto");
  let idPersonal = $("#txtIdPersonal").val();

  var form = $(
    '<form action="' +
      urlProyect +
      'views/prospectoUsDetalle/" method="post">' +
      '<input type="hidden" name="txtidProspecto" id="txtidProspecto" value="' +
      id +
      '">' +
      '<input type="hidden" name="txtidPersonal" id="txtidPersonal" value="' +
      idPersonal +
      '">' +
      "</form>"
  );
  $("body").append(form);
  form.submit();
});
let aregloprospectosActivoDasactvados = new Array();

$(document).on("click", "#btnAsiganrProspectos", function () {
  fnBuscarProspectosPorPersonal(1);
  /* $('#formularioAsignacionManual input[type=checkbox]').each(function () {
        if (this.checked==false) {
            aregloprospectosActivoDasactvados.push($(this).val());
        }

    }); */
});
function fnCargarLoader($estado) {
  $("#Contenedor_Loader").css("display", $estado);
}

// buscar prospectos por personal
function fnBuscarProspectosPorPersonal(lntipoCon) {
  fnCargarLoader("block");
  let idPersonal = $("#txtIdPersonal").val();
  $.ajax({
    data: {
      idPersonal,
      lntipoCon,
    },
    url: urlProyect + "controller/DevolverDatos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      console.log(resp);
      let datos = JSON.parse(resp);
      let Prospectos = "";
      let personal = "";
      let seguimiento = "";
      let i = 0;
      datos.forEach((element) => {
        if (
          element.tipoSeguimiento == "mensaje" &&
          element.estadoSeguimiento == "1"
        ) {
          seguimiento = `<i class='icon-bubbles' style='color: green; font-size: 25px text-align: center;'></i>`;
        } else if (
          element.tipoSeguimiento == "llamada" &&
          element.estadoSeguimiento == "1"
        ) {
          seguimiento = `<i class='fas fa-phone-volume' style='transform:rotate(-45deg); color: green; font-size: 25px; text-align: center;'></i>`;
        } else {
          seguimiento = `<i class='icon-notification' style='color: brown;'></i>`;
        }

        personal =
          idPersonal != 0 ? " de :" + element.personal : ": Sin Seguimiento";
        if (lntipoCon == 0) {
          i++;
          Prospectos +=            `
                        <tr captIdProspecto="${element.id} " class='celProspecto'>
                            <td class="campoNombre">${i}</td>
                            <td class="campoNombre">${element.nombre}</td>
                            <td>${element.email}</td>
                            <td>${element.telefono}</td>
                            <td>${element.pais}</td>
                            <td>${element.personal}</td>
                            <td>` +
            seguimiento +
            `</td>
                        </tr>`;
        } else if (lntipoCon == 1) {
          aregloprospectosActivoDasactvados.push(element.id);
          Prospectos += `
            <div class="m-0 p-0 text-left" style="border:none;">
                <div class="m-0 p-0 text-left d-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12"  style="border:none;">
                    <div class="p-0 col-1 col-xs-1 col-sm-1 col-md-1 col-lg-1">${i + 1}</div>
                        <input type="checkbox"   class="cheks ${i} ${element.id} p-0 text-left col-1 col-xs-1 col-sm-1 col-md-1 col-lg-1" name="txtProspecto${i}" id="${element.id}" value="${element.id}" readonly>
                        <label class="labelProspectos col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8" for="${element.id}">${element.nombre}</label>
                        <span class="col-2 col-xs-2 col-sm-2 col-md-2 col-lg-2">${seguimiento}</span>
                    </div>
               </div>
            </div>        
                          `;
          i++;
        }
      });
      fnCargarLoader("none");
      $("#txtPersonalact").html("Prospectos " + personal);
      let divContenedor =
        lntipoCon == 0 ? "cargarDatosProspectos" : "contenedorProspectos";
      let holader = lntipoCon == 0 ? "holderBase" : "holderModal";
      if(lntipoCon==0){
       fnBorrarExportaciones("tablaProspectos");
      }
      $("#" + divContenedor).html(Prospectos);
      if(lntipoCon==0){
        fnMostrarExportaciones("tablaProspectos","Buscar prospecto","fBrtilp");
      }
      $("div.holderModal").jPages({
        containerID: "contenedorProspectos",
        perPage: 30,
        startPage: 1,
        midRange: 2,
        previous: "an",
        next: "sig",
      });
    },
    error: function () {
      alert("error");
    },
  });
}

// funcion para traer las ventas segun cada prospecto

function fnDevolverVentas(){
  let idUsuarioParaVentas=$("#txtIdPersonal").val();
  $.ajax({
    data: {
      idUsuarioParaVentas,
      lntipoCon,
    },
    url: urlProyect + "controller/DevolverDatos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      console.log(resp);
      let datos = JSON.parse(resp);
      let Prospectos = "";
      let i = 0;
      datos.forEach((element) => {
        
        
      });
      
      $("#").html(Prospectos);
      $("div.").jPages({
        containerID: divContenedor,
        perPage: 30,
        startPage: 1,
        midRange: 2,
        previous: "an",
        next: "sig",
      });
    },
    error: function () {
      alert("error");
    },
  });
}


var itemsChekeados = 0;
let aregloprospectosActivo = new Array();

$(document).on(
  "change",
  "#formularioAsignacionManual input[type=checkbox]",
  function () {
    aregloprospectosActivo.push(0);
    aregloprospectosActivo.push($(this).val());
  }
);
$(document).on("keyup", "#txtCantidadItemsActivar", function (e) {
  let NumCheks = $("#txtCantidadItemsActivar").val();
  // var code = e.keyCode ? e.keyCode : e.which;
  // if (code == 13) {
  if (NumCheks > aregloprospectosActivo.length) {
    fnactivarChecksBox(NumCheks);
  } else {
    fndesactivarChecksBox(NumCheks);
  }

  // }
});

function fndesactivarChecksBox(dato) {
  // let NumCheksDescativar = $("#txtCantidadItemsDesactivar").val();
  let itemArray = parseInt(aregloprospectosActivo.length);
  let cantDesactivar = parseInt(itemArray - dato);

  for (let i = itemArray; i > dato - 1; i--) {
    $("input#" + aregloprospectosActivo[i]).prop("checked", false);
    aregloprospectosActivo.splice(i, i);
  }
  // alert(aregloprospectosActivo.length);
}

// function removeItemFromArr ( arr, item ) {
// var i = arr.indexOf( item );
// arr.splice( i, 1 );
// }
function fnactivarChecksBox(dato) {
  aregloprospectosActivo.length = 0;
  for (let index = 0; index < dato; index++) {
    $("input#" + aregloprospectosActivoDasactvados[index]).prop("checked",true);
  }
  $("#formularioAsignacionManual input[type=checkbox]").each(function () {
    if (this.checked) {
      aregloprospectosActivo.push($(this).val());
    }
  });
}
// $(document).on("keypress", "#txtCantidadItemsDesactivar", function (e) {
// var code = e.keyCode ? e.keyCode : e.which;

// if (code == 13) {

//     itemsChekeados = cantDesactivar;
// }
// });
function fnValidarAsignacionPersonal() {
  let itemArray = parseInt(aregloprospectosActivo.length);
  if (itemArray < 1) {
    msgAlertas(
      "msgAsignacion",
      "alert-danger",
      "alert-success",
      "Seleccione al Menos un Prospecto"
    );
    return false;
  } else if ($("#cboidUsuarioPersonal").val() == 0) {
    msgAlertas(
      "msgAsignacion",
      "alert-danger",
      "alert-success",
      "Seleccione Personal a Asignar"
    );
    return false;
  } else {
    return true;
  }
}
// codigo para guardar  asignacion de prospectos a otros asistente de ventas
$(document).on("click", "#btnGuardarAsignacion", function (e) {
  e.preventDefault();
  fnCargarLoader("block");
  let datos = $("#formularioAsignacionManual").serialize();
  if (fnValidarAsignacionPersonal() == true) {
    $.ajax({
      data: datos,
      url: "../../controller/GuardarAsignacionProspectos.php",
      type: "POST",
      dataType: "json",
      beforeSend: function () {},
      success: function (resp) {
        // alert(resp);
        fnCargarLoader("none");
        if (resp.ok != undefined) {
          fnBuscarProspectosPorPersonal(1);
          msgAlertas("msgAsignacion", "alert-success", "alert-danger", resp.ok);
          $("#txtCantidadItemsActivar").val("");
          // setTimeout(function () {location.reload();}, 2000);
        } else {
          msgAlertas(
            "msgAsignacion",
            "alert-danger",
            "alert-success",
            resp.error
          );
        }
      },
      error: function (e) {
        alert("error En la Asignacion" + e);
      },
    });
  } else {
    fnCargarLoader("none");
  }
});

function msgAlertas(id, claseAdd, claseRemove, msg) {
  $("#" + id)
    .addClass(claseAdd)
    .text(msg)
    .show(800)
    .delay(2000)
    .hide(300);
  $("#" + id).removeClass(claseRemove);
  // $(`#Contenedor_Loader`).delay(1000).hide(200);
}
