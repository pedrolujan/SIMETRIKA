import { urlProyect } from "./urlProyecto.js?wjhhe";
import { funcionMensaje } from "./urlProyecto.js?wjhhe";
import { msgAlertas } from "./urlProyecto.js?777";
import { fnCargarLoader } from "./urlProyecto.js?hjhj";

const combos = document.querySelectorAll(".ContenedorBuscarPorFechas select");
const fechas = document.querySelectorAll(".ContenedorBuscarPorFechas input");

combos.forEach((select) => {
  select.addEventListener("change", fnBuscarClientes);
});

fechas.forEach((select) => {
  select.addEventListener("change", fnBuscarClientes);
});

fnBuscarClientes();
$(document).on("change", "#CboCampaniaVenta", function () {
  $("#txtCampaniaGeneral").val($("#CboCampaniaVenta").val());
});
$(document).on("change", "#CboCampania", function () {
  $("#txtEvento").val($("#CboCampania").val());
});
$(document).on("change", "#CboCursos", function () {
  $("#txtCurso").val($("#CboCursos").val());
});
$(document).on("change", "#fecha_inicio", function () {
  $("#txtFechaIni").val($("#fecha_inicio").val());
});
$(document).on("change", "#fecha_final", function () {
  $("#txtFechaFinal").val($("#fecha_final").val());
});

// codigo para editar datos prospectos

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

$(document).on("click", "#btn_txtBuscar", function (e) {
  /*  $(".contengif").html('<div class="loading"><img src="../imagenes/loader.gif" style="height: 20px; margin-left: 10px;"/></div>').show(); */ e.preventDefault();
  
  fnBuscarClientes();
});

// /codigo para buscar los prospectos
function fnBuscarClientes() {
  fnCargarLoader("block");
  var mensaje = {};
  let idCampaniaGeneral = $("#CboCampaniaVenta").val();
  let idCampania = $("#CboCampania").val();
  // alert(idCampania);
  let idCurso = 0;
  if ($("#CboCursos").val() == "" || $("#CboCursos").val() == null) {
    idCurso = 0;
  } else {
    idCurso = $("#CboCursos").val();
  }
  let fechaInicio = $("#fecha_inicio").val();
  let fechaFinal = $("#fecha_final").val();
  let idPersonal = $("#txtidPersonal").val();
  let Habilitarfechas = 0;
  if (fechaInicio != "" && fechaFinal != "") {
    Habilitarfechas = 1;
  }
  $.ajax({
    data: {
      idCampaniaGeneral,
      idCampania,
      idCurso,
      Habilitarfechas,
      fechaInicio,
      fechaFinal,
      idPersonal
    },
    url: urlProyect + "controller/buscar_prospectos.php",
    type: "post",
    // dataType: "JSON",
    // async: true,
    success: function (response) {
      console.log(response);
      // return;
      let datos = JSON.parse(response);
      let Prospectos = "";
      let i = 1;
      datos.forEach((element) => {
        Prospectos += ` <tr captId="${element.id
        } " class='celProspecto' id='celProspecto' style="cursor:pointer;">
                <td class="tdNumero">${i}</td>
                <td>${element.nombre}</td>
                <td>${element.email}</td>
                <td>${element.telefono}</td>
                <td>${element.pais}</td>
                <td>${
                  element.curso.length < 5 ? "No especificado" : element.curso
                }</td>
                <td class="text-center tdSeguimiento">${element.estado}</td>
               
            </tr>`;
        i++;
      });
      fnBorrarExportaciones();
      $(`#tbofy`).html(Prospectos);
      fnMostrarExportaciones();
    //   $("div.holder").jPages({
    //     containerID: "tbofy",
    //     perPage: 50,
    //     startPage: 1,
    //     midRange: 2,
    //     previous: "an",
    //     next: "sig",
    //   });
      $(`.contador`).html(datos.length);

      fnCargarLoader("none");
    },

    error: function () {},
  });
}

// $(document).on('click','#rbCompleto',function(){
//     // location.reload();
//     $("#rbCompleto").attr('checked', 'checked');
// })
// $(document).on('click','#rbSendinBlue',function(){
//     // location.reload();
//     $("#rbCompleto").attr('checked', 'checked');
// })
// $(document).on('click','#rbContactos',function(){
//     // location.reload();
//     $("#rbCompleto").attr('checked', 'checked');
// })

$(document).on("click", "#export_data", function (e) {
  setTimeout(function () {
    location.reload();
  }, 3000);
});
// codigo para accede al prospecto especifico
$(document).on("click", ".celProspecto", function () {
  let element = $(this)[0];
  let id = $(element).attr("captId");
  let url = "views/infoProspecto/";

  var form = $(
    '<form action="' +
      urlProyect +
      url +
      '" method="get">' +
      '<input type="hidden" name="identifier" id="identifier" value="' +btoa(id) +'">' +
      "</form>"
  );
  $("body").append(form);
  form.submit();
});

// codigo para guardar la la tarea que hiso el asistente de ventas para con el prospecto


// codigo para ventana modals de registro de prospécto

$(document).on("change", "#CboPais", function () {
  let idPais = $("#CboPais").val();
  $.ajax({
    data: {
      idPais,
    },
    url: urlProyect + "controller/DevolverDatos.php",
    type: "post",
    beforeSend: function () {},
    success: function (response) {
      let datos = JSON.parse(response);
      let codigo = "";
      datos.forEach((element) => {
        $("#CodigoPais").html(`${element.codigo}`);
        $(".CodigoPais").val(`${element.codigo}`);
      });
    },
    error: function () {
      alert("error al cargar codigo");
    },
  });
});

// guardar prospectos
$(document).on("click", "#btn_guardarProspectos", function (e) {
  e.preventDefault();
  let datos = $("#frmReguistrarProspectos").serialize();
  let result = fnValidarDatosRegProspectos();
  if (result == true) {
    $.ajax({
      data: datos,
      url: urlProyect + "controller/registro_prospectoXpersonal.php",
      type: "post",
      dataType: "json",
      async: true,
      success: function (resp) {
        // funcionMensaje(resp, "formulario__mensaje");

        if (resp.ok != undefined) {
          msgAlertas(
            "formulario__mensaje",
            "alert-success",
            "alert-danger",
            resp.ok
          );
          setTimeout("location.href=' '", 2000);
        } else {
          msgAlertas(
            "formulario__mensaje",
            "alert-danger",
            "alert-success",
            resp.error
          );
        }
      },
    });
  } else {
    msgAlertas(
      "formulario__mensaje",
      "alert-danger",
      "alert-success",
      "Porfavor complete los datos"
    );
  }
});

function fnValidarDatosRegProspectos() {
  if ($("#txtEmail").val() == "" || $("#txtEmail").val().length < 4) {
    msgAlertas(
      "formulario__mensaje",
      "alert-danger",
      "alert-success",
      "Ingrese correctamente correo"
    );
    return false;
  } else if (
    $("#txtnombres").val() == "" ||
    $("#txtnombres").val().length < 3
  ) {
    msgAlertas(
      "formulario__mensaje",
      "alert-danger",
      "alert-success",
      "Ingrese correctamente nombres"
    );
    return false;
  } else if (
    $("#txtApellidos").val() == "" ||
    $("#txtApellidos").val().length < 4
  ) {
    msgAlertas(
      "formulario__mensaje",
      "alert-danger",
      "alert-success",
      "Ingrese correctamente apellidos"
    );
    return false;
  } else {
    return true;
  }
}

// function msgAlertas(id, claseAdd, claseRemove, msg) {
//   $("#" + id)
//     .addClass(claseAdd)
//     .text(msg)
//     .show(800)
//     .delay(2000)
//     .hide(300);
//   $("#" + id).removeClass(claseRemove);
//   $(`#Contenedor_Loader`).delay(1000).hide(200);
// }

function fnBorrarExportaciones() {
  var table = $("#tableProspectos").DataTable();
  table.destroy();
}

function fnMostrarExportaciones() {
  $("#tableProspectos").DataTable({
    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      info: "Registros del _START_ al _END_ de _TOTAL_ registros",
      infoEmpty: "No se encontro resultados",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      sSearch: "Buscar prospecto:</br>",
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
