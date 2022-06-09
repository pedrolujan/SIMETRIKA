import { urlProyect } from "./urlProyecto.js?hjhj";
import { fnBotonEditar } from "./urlProyecto.js?hjhj";
import { msgAlertas } from "./urlProyecto.js?hjhj";
import { fnCargarLoader } from "./urlProyecto.js?hjhj";

const combos = document.querySelectorAll(".ContenedorFiltrar select");
const fechas = document.querySelectorAll(".ContenedorFiltrar input");
// codigo para abrir modal sobre modal
$(document).on("click", "#btn-SIA_NuevoEvento", function() {
    TraerCursos();
    $("#formulariosBuscarCurso").css("display", "block");
});
$(document).on("click", "#btn-SIA_GuardarEvento", function() {
    fnCargarLoader("#Contenedor_Loader", "block");
    let datosFormulario = new FormData($("#formularioNuevoEvento")[0]);
    // let datosFormulario = $("#formularioNuevoEvento").serialize();
    $.ajax({
        data: datosFormulario,
        url: "../../../controller/procesos_evento.php",
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        beforeSend: function() {},
        success: function(resp) {
            console.log(resp);
            if (resp.ok != undefined) {
                msgAlertas("msjs", "alert-success", "alert-danger", resp.ok);

                // fnCargarLoader("#formulariosBuscarCurso","none");
                fnBuscarCursos();
                setTimeout(function() {
                    $(".cerrarModal").click();
                }, 1000);
            } else {
                msgAlertas("msjs", "alert-danger", "alert-success", resp.error);
            }
            fnCargarLoader("#Contenedor_Loader", "none");
        },
        error: function(e) {
            console.log(e);
            fnCargarLoader("#Contenedor_Loader", "none");
            alert("error En la venta" + e);
        },
    });
});

function TraerCursos() {
    let CURSOS = "CURSOS";
    $.ajax({
        data: {
            CURSOS,
        },
        url: urlProyect + "controller/DevolverDatos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            let datos = JSON.parse(resp);
            let Cursos = "";
            datos.forEach((element) => {
                Cursos += `
            <div class="contenChecks">
                <input type="checkbox"  class="cheks" name="" id="${element.id}" value="${element.id}">
                <label for="${element.id}">${element.nombre}</label>
            </div>`;
            });
            $(".contenedorCargarCursos").html(Cursos);
            $("div.holder").jPages({
                containerID: "contenedorCargarCursos",
                perPage: 15,
                startPage: 1,
                midRange: 2,
                previous: "an",
                next: "sig",
            });
        },
        error: function() {
            alert("error");
        },
    });
}

// codigo para capturar los cursos especificos

$(document).on("click", "#btnCapturarCursos", function() {
    $(".contenedorLLanarCursos").html("");
    let aregloCursos = new Array();
    let seleccionados = $("input:checkbox[class=cheks]:checked");
    // let DatosCursos=$("#formulariosBuscarCurso").serialize();
    $(seleccionados).each(function() {
        aregloCursos.push($(this).val());
    });

    $.ajax({
        data: {
            arregloCursos: JSON.stringify(aregloCursos),
        },
        url: urlProyect + "controller/DevolverDatos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            let cursosEspecificos = "";
            let i = 0;
            let datos = JSON.parse(resp);
            datos.forEach((element) => {
                cursosEspecificos += `
            <div class="contenCursosEspecificos d-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8">
                  <input type="checkbox"  class="cheks m-0" name="checksBoxCursos${i}" id="${element.id}" value="${element.id}" checked>
                  <label for="${element.id}">${element.nombre}</label>
                </div>
                
            </div>`;
                // precioSubTotal += parseFloat(element.precio);
                i++;
            });
            aregloCursos = [];
            // console.log(aregloCursos);

            $("#txtNumCursos").val(i);

            $("#contenedorLLanarCursosModal").html(cursosEspecificos);
            $("#formulariosBuscarCurso").css("display", "none");
            // // $(`#Contenedor_Loader`).hide();
        },
        error: function() {
            alert("error al cargar entidad bancaria");
        },
    });
});

combos.forEach((select) => {
    select.addEventListener("change", fnBuscarCursos);
});

fechas.forEach((select) => {
    select.addEventListener("change", fnBuscarCursos);
});

fnBuscarCursos();

function fnBuscarCursos() {
    let idDocente = $("#CboDocente_fl").val();
    let modalidad = $("#CboModalidad_fl").val();
    let estadoEvento = $("#CboEstado_fl").val();
    let idCampania = $("#CboCampania_fl").val();
    let dFechaInicio = $("#fecha_in_fl").val();
    let dFechaFin = $("#fecha_fin_fl").val();
    let Habilitarfechas = 0;
    if (dFechaInicio != "" && dFechaFin != "") {
        Habilitarfechas = 1;
    }
    let BusquedaCursos = "ok";
    $.ajax({
        data: {
            idDocente,
            modalidad,
            estadoEvento,
            idCampania,
            Habilitarfechas,
            dFechaInicio,
            dFechaFin,
            BusquedaCursos,
        },
        url: urlProyect + "controller/ejecutar_procedimientos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            console.log(resp);
            // return;
            let datos = JSON.parse(resp);
            let DatosEventos = "";
            let iconLive = `<span class="p-2 icon-feed" style="background:green; color:#fff; height: 20px;border-radius: 50%;" ></span>`;
            let iconOdemand = `<span class="p-2 icon-play2" style="background:red; color:#fff; height: 20px;border-radius: 50%;" ></span>`;
            let iconEstadoDanger = `<span class="bg-danger" id="iconEstado" style=" margin-right:12px; width: 20px;position: absolute; height: 20px;border-radius: 50%;" ></span>`;
            let icono;
            let botonEditar;
            let numAlumnos = 0;

            botonEditar = `<span class="btn btn-info" rel="modal:open"><span class="fas fa-edit"></span></span>`;

            // boton = `<span class="btnVerPagoCuota btn btn-danger" rel="modal:open"><span class="fas fa-edit"></span></span>`;

            let i = 1;
            datos.forEach((element) => {
                element.NumAlumnos.forEach((el) => {
                    numAlumnos = `<div class="btnNumAlumnos d-block btn d-inline-flex align-items-center justify-content-center" style="font-size: 14px; background:#7B3090; padding: 5px; color:#ffffff; width:35px; height:35px; border-radius:50%; " ><span >${el.NumAlumnos}</span></div>`;
                });
                icono = element.modalidad == "Live" ? iconLive : iconOdemand;
                DatosEventos += ` 
                    <tr capIdEvento="${element.idEvento} " capCodEvento="${element.codEvento}" capFechIni="${element.FechaIni}" capFechFin="${element.FechaFinal}" capCodEstado="${element.codEstado}" class='celBusquedaCliente' id='celBusquedaCliente'>
                        <td class="tdNumero" style="width: 1px;">${i}</td>
                        <td class="w-25">${element.NombreCurso}</td>
                        <td>${element.Docente}</td>
                        <td class="d-flex justify-content-between"><div>${element.modalidad}</div> <div>${icono}</div></td>                   
                        <td class="text-center">${element.FechaReg_ini}</td>                   
                        <td class="text-center">${element.FechaReg_fin}</td>                                                  
                        <td class="text-center">${numAlumnos}</td>                   
                        <td>${element.EstadoEvento}</td>                   
                        <td class=" p-1 d-flex  justify-content-between">
                          <a href="#formularioDatosDeClase" class="btnEditarCurso" rel="modal:open">${fnBotonEditar()}</a>
                          <a href="details?codeenvent=${btoa(element.codEvento)}" >
                            <span title="Ver detalle de Venta" class="d-block btn btn-info d-inline-flex align-items-center;" rel="modal:open">
                              <span class="icon-newspaper" style="font-size: 20px;"> </span>
                            </span>
                          </a>
                        </td>                   
                       
                    </tr>`;

                i++;
            });
            fnBorrarExportaciones();

            $(`#tbListarEventos`).html(DatosEventos);

            fnMostrarExportaciones();
        },
        error: function() {
            alert("error al cargar ventas");
        },
    });
}

$(document).on("click", ".btnEditarCurso", function() {
    let elActualizar = $(this)[0].parentElement.parentElement;
    let capIdEvento = $(elActualizar).attr("capIdEvento");
    let CodEvento = $(elActualizar).attr("capCodEvento");
    // let FechaIni = $(elActualizar).attr("capFechIni");
    // let FechaFin = $(elActualizar).attr("capFechFin");
    let CodEstado = $(elActualizar).attr("capCodEstado");
    $("#txtCodAlumnoMod").val(capIdEvento);
    $("#txtCodVentaMod").val(CodEvento);
    $("#formularioDatosDeClase h5").html("Actualizar datos de curso");
    $("#btnGuardarVenta").val("Actualizar datos");
    $("#formularioDatosDeClase div.bg-warning span").html("¡ Actualizar correctamente las fechas y progreso del curso !");
    $("#dtFechaInicio").val($(elActualizar).attr("capFechIni"));
    $("#dtFechaFin").val($(elActualizar).attr("capFechFin"));
    $("#cboProgresoClase").val("'" + $(elActualizar).attr("capCodEstado") + "'");

});

$(document).on("click", "#btnGuardarVenta ", function(e) {
    e.preventDefault();
    if ($("#btnGuardarVenta").val() == "Actualizar datos") {
        let CodEvento = $("#txtCodVentaMod").val();
        let IdEvento = $("#txtCodAlumnoMod").val();
        // alert("CodigoEvento "+CodEvento+" idEvento"+IdEvento);
        fnRegistrarActualizacionClase(CodEvento, IdEvento);
    }
});

function fnRegistrarActualizacionClase(CodEvento, IdEvento) {
    fnCargarLoader("block");
    let ActualizarFechasEvento = "ok";
    let dFechaIni = $("#dtFechaInicio").val();
    let dFechaFin = $("#dtFechaFin").val();
    let cboProgreso = $("#cboProgresoClase").val();

    $.ajax({
        data: { CodEvento, IdEvento, ActualizarFechasEvento, dFechaIni, dFechaFin, cboProgreso },
        url: urlProyect + "controller/ejecutar_procedimientos.php",
        type: "POST",
        dataType: "json",
        beforeSend: function() {},
        success: function(resp) {
            if (resp.ok != undefined) {
                msgAlertas("msjs", "alert-success", "alert-danger", resp.ok);
                fnBuscarCursos();
                setTimeout(function() {
                    $(".cerrarModal").click();
                }, 10);
            } else {
                msgAlertas("msjs", "alert-danger", "alert-success", resp.error);
            }
            fnCargarLoader("none");
        },
        error: function(e) {
            console.log(e);
            alert("error En la venta" + e);
        },
    });

}

$(document).on("click", ".btnNumAlumnos", function() {
    let element = $(this)[0].parentElement.parentElement;
    let codEvento = $(element).attr("capCodEvento");
    let idEvento = $(element).attr("capIdEvento");
    let url = "../alumnos/";
    var form = $(
        '<form action="' + url + '" method="post">' +
        '<input type="hidden" name="postCodClase"  value="' + codEvento + '" />' +
        '<input type="hidden" name="postidEvento"  value="' + idEvento + '" />' +
        "</form>"
    );
    $("body").append(form);
    form.submit();
});
// codigo para subir el template de certificado
$(document).on("dblclick", "#btn-subirTemplateFron", function() {
    $("#txtTemplateCertificadoFron").click();
});
$(document).on("dblclick", "#btn-subirTemplatePost", function() {
    $("#txtTemplateCertificadoPost").click();
});

// previsualizar template de certificado
$(document).on("change", "#txtTemplateCertificadoFron", function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#formularioNuevoEvento + img").remove();
            $("#imgTemplateCertificadofron").attr("src", e.target.result);
        };

        reader.readAsDataURL(this.files[0]);
    }
});
$(document).on("change", "#txtTemplateCertificadoPost", function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#formularioNuevoEvento + img").remove();
            $("#imgTemplateCertificadoPost").attr("src", e.target.result);
        };

        reader.readAsDataURL(this.files[0]);
    }
});












// codigo para mostrar los botones de exportaciones junto con la tabla
function fnBorrarExportaciones() {
    var table = $("#tbEventos").DataTable();
    table.destroy();
}

function fnMostrarExportaciones() {
    $("#tbEventos").DataTable({
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
        buttons: [{
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