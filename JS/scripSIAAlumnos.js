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
    select.addEventListener("change", fnBuscarAlumnosXCurso);
});

fechas.forEach((select) => {
    select.addEventListener("change", fnBuscarAlumnosXCurso);
});

let urlActual = `${urlProyect}views/sia/alumnos/`;
if (location.href === urlActual) {
    fnBuscarAlumnosXCurso();
}

function fnBuscarAlumnosXCurso() {
    fnCargarLoader("block");
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
    let codCurso = $("#txtCodigoCurso").val();
    let idCurso = $("#txtidCurso").val();
    // alert(idCurso);
    let BusquedaAlumnosXCursos = "ok";
    $.ajax({
        data: {
            idDocente,
            modalidad,
            estadoEvento,
            idCampania,
            dFechaInicio,
            dFechaFin,
            Habilitarfechas,
            BusquedaAlumnosXCursos,
            codCurso,
            idCurso,
        },
        url: urlProyect + "controller/ejecutar_procedimientos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            fnBorrarExportaciones("tbAlumnosXCurso");
            console.log(resp);
            // return;
            let datos = JSON.parse(resp);
            let datosAlumnos = "";
            let cursosEspecificos = "";
            let check = "";
            let i = 0;
            datos.forEach((element) => {
                cursosEspecificos += `
                        <div class="pt-2 pb-2 pl-0 pr-0 d-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 align-items-center" style="border-bottom:solid 1px #ccc; background: #ccc;">
                            <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 ">
                              <h6 style="font-weight: bold;">${
                                element.nombreCurso
                              }</h6>
                            </div>
                            <div class="col-3 p-2 d-flex align-items-center">
                              <div class="col-8 d-none d-lg-block">${
                                element.cModalidad
                              }</div>
                              <div class="col-4">${fnIconosModalidadClase(
                                element.codModalidad
                              )}</div>
                            </div>  
                        </div>
                        <div class="mt-2 text-center d-md-flex justify-content-around">
                          <input type="submit" name="btnEditarNotas" id="btnEditarNotas" class="btn mb-3 mb-md-0 pl-5 pr-5 btn-outline-smtk" value="Editar Notas">
                          <input type="submit" name="btnGuardarAlumnosSenblue" id="btnGuardarAlumnosSenblue" class="btn p-2 btn-outline-smtk" value="Guardar Alumnos a Sendinblue">
                        </div>`;

                $("#txtCodEvento").val(`${element.CodEvento}`);
                $("#txtidCurso").val(`${element.IdCurso}`);
                $("#txtidListaSend").val(`${element.idListaSendBl}`);

                element.Alumnos.forEach((ele) => {
                    check = ele.estadCertificacion == 1 ? "checked" : "";
                    datosAlumnos += ` 
                <tr capIdAlumno="${ele.idCliente} " capCodAlumno="${ele.codCliente}" capCodEvento="${element.CodEvento}" capIdCurso="${element.IdCurso }" class="trAlumnos">   
                  <td class="tdNumero" style="width: 10px;" width="10px">
                  <input type="checkbox"   class="cheks ${i} ${ele.idCliente} p-0 text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" name="chkCertificado${i}" id="${ele.idCliente}" value="${ele.codCliente}" ${check}>
                    <input type="hidden" name="txtCodAlumno${i}" id="txtCodAlumno${i}" value="${ele.codCliente}">
                    <input type="hidden" name="txtCodClaseR${i}" id="txtCodClaseR${i}" value="${ele.codClase}">
                  </td>
                   
                  <td class="tdCliente col-3">${ele.Cliente}</td>
                  <td class="col-2 text-center">${ele.progresoClase}</td>
                  <td class="col-1 text-center">
                    <span class="spnNotas">${ele.nota1 ?? 0}</span>
                    <input type="number" name="txtNota1${i}" id="txtNota1${i}" class="d-none clsNotas${i} txtInputNotas form-control col-10 text-center" value="${ele.nota1 ?? 0}">
                  </td>
                    <td class="col-1 text-center">
                      <span class="spnNotas">${ele.nota2 ?? 0}</span>
                      <input type="number" name="txtNota2${i}" id="txtNota2${i}" class="d-none clsNotas${i} txtInputNotas form-control col-10 text-center" value="${
            ele.nota2 ?? 0
          }">
                    </td>
                    <td class="col-1 text-center">
                      <span class="spnNotas">${ele.nota3 ?? 0}</span>
                      <input type="number" name="txtNota3${i}" id="txtNota3${i}" class="d-none clsNotas${i} txtInputNotas form-control col-10 text-center" value="${
            ele.nota3 ?? 0
          }">
                    </td>
                    <td class="col-1 text-center">
                      <span class="spnNotas">${ele.promedio ?? 0}</span>
                      <input type="text" name="promedio${i}" id="promedio${i}" class="d-none txtInputNotas form-control col-10 text-center" value="${
            ele.promedio ?? 0
          }" readonly>
                    </td>
                    <td class="colLinkCertificado col-2" id="tdLink${i}">
                      <a href="${fnAcortarUrl(
                        ele.codCliente,
                        i
                      )}" target="_blank">${fnAcortarUrl(ele.codCliente, i)}</a>
                      <input type="hidden" name="txtLinkCertificado${i}" id="txtLinkCertificado${i}" class="form-control col-10 text-center" value="${fnAcortarUrl(
            ele.codCliente,
            i
          )}">
                    </td>
                </tr>`;
                    i++;
                });
            });

            $("#txtTotalAlumnos").val(i);

            $(".contenedorDatosCurso").html(cursosEspecificos);
            $("#tbLAlumnosXcursos").html(datosAlumnos);
            fnMostrarExportaciones("tbAlumnosXCurso", "Buscar alumnos", "fBrtilp");
            fnCargarLoader("none");
        },
        error: function() {
            alert("error al cargar ventas");
        },
    });
}

function fnActivarEdicionNotas($valor) {
    if ($valor == "Editar Notas") {
        $("#btnEditarNotas").val("Guardar Cambios");
        $(".txtInputNotas").addClass("d-block");
        $(".txtInputNotas").removeClass("d-none");
        $(".spnNotas").removeClass("d-block");
        $(".spnNotas").addClass("d-none");
    } else if ($valor == "Guardar Cambios") {
        $("#btnEditarNotas").val("Editar Notas");
        $(".txtInputNotas").removeClass("d-block");
        $(".txtInputNotas").addClass("d-none");
        $(".spnNotas").addClass("d-block");
        $(".spnNotas").removeClass("d-none");
    }
}
// codigo para habilitar el llenado de notas
$(document).on("click", "#btnEditarNotas", function() {
    fnCargarLoader("block");
    var notass = new Array();
    var codigos = new Array();
    var ArregloAlumnos = {};
    var notasAlumnos = {};
    let codAlumno = "";
    if ($("#btnEditarNotas").val() == "Guardar Cambios") {
        let datosFormulario = $("#FormularioNotas").serialize();
        $.ajax({
            data: datosFormulario,
            url: urlProyect + "controller/guardar_notas.php",
            type: "post",
            dataType: "json",
            beforeSend: function() {},
            success: function(resp) {
                resp.ok != undefined ?
                    msgAlertas("msjs", "alert-success", "alert-danger", resp.ok) :
                    msgAlertas("msjs", "alert-danger", "alert-success", resp.error);
                fnBuscarAlumnosXCurso();
            },
            error: function() {
                alert("error al guardar notas");
            },
        });
    } else {
        fnActivarEdicionNotas($("#btnEditarNotas").val());
        fnCargarLoader("none");
    }
    // if($("#btnEditarNotas").val()=="Editar Notas"){
});
// codigo para habilitar el llenado de notas
$(document).on("click", "#btnGuardarAlumnosSenblue", function() {
    fnCargarLoader("block");
    let datosFormulario = $("#FormularioNotas").serialize();
    $.ajax({
        data: datosFormulario,
        url: urlProyect + "controller/guardar_certificacion.php",
        type: "post",
        dataType: "json",
        beforeSend: function() {},
        success: function(resp) {
            // alert(resp.ok + " OO " + resp.error);
            resp.ok != undefined ?
                msgAlertas("msjs", "alert-success", "alert-danger", resp.ok) :
                msgAlertas("msjs", "alert-danger", "alert-success", resp.error);
            fnBuscarAlumnosXCurso();
            fnCargarLoader("none");
        },
        error: function(e) {
            console.log("error al guardar A sendingBlue " + e);
        },
    });

    // if($("#btnEditarNotas").val()=="Editar Notas"){
});

// codigo para validar el llenado de notas
$(document).on("keyup", ".txtInputNotas", function() {
    let totalAlumnos = $("#txtTotalAlumnos").val();
    let notasLlenas = 0;
    let sumaNotas = 0;
    let promedio = 0;
    let contar = 0;
    if ($(this).val() > 20 || $(this).val() < 0) {
        $(this).val(0);
    }
    for (let i = 0; i < totalAlumnos; i++) {
        if ($(`#txtNota1${i}`).val() != 0) {
            contar += 1;
        }
        if ($(`#txtNota2${i}`).val() != 0) {
            contar += 1;
        }
        if ($(`#txtNota3${i}`).val() != 0) {
            contar += 1;
        }
        sumaNotas =
            parseFloat(
                $(`#txtNota1${i}`).val() == "" ? 0 : $(`#txtNota1${i}`).val()
            ) +
            parseFloat(
                $(`#txtNota2${i}`).val() == "" ? 0 : $(`#txtNota2${i}`).val()
            ) +
            parseFloat($(`#txtNota3${i}`).val() == "" ? 0 : $(`#txtNota3${i}`).val());
        $(`#promedio${i}`).val(Math.round(sumaNotas == 0 ? 0 : sumaNotas / contar));

        contar = 0;
    }
});

var codVentas = {};
var TipOpcion = {};
var divPos = {};
var offset = $("#tbAlumnosXCurso").offset();

$(document).mousemove(function(e) {
    divPos = {
        left: e.pageX - offset.left,
        top: e.pageY - offset.top,
    };
    // console.log(divPos);
});
$(document).on("contextmenu", ".trAlumnos", function(event) {
    event.preventDefault();
    fnTipoOpcionContextmenu("context-menu", divPos);
    let element = $(this)[0];
    let CodAlumno = $(element).attr("capCodAlumno");
    let CodEvento = $(element).attr("capCodEvento");
    let idCurso = $(element).attr("capIdCurso");

    codVentas = {
        codAlumno: CodAlumno,
        codEvento: CodEvento,
        Idcurso: idCurso,
    };
});

window.addEventListener("click", function() {
    document.getElementById("context-menu").classList.remove("active");
});
// $(document).on("click", "#acaAbrir", function () {
$(document).on("click", ".item", function(event) {
    event.preventDefault();
    if ($(this).attr("id") == "Cerificados") {
        let url = "../certificates/";
        var form = $(
            '<form action="' +
            url +
            '" method="get">' +
            '<input type="hidden" name="identifiercustomer"  value="' +
            btoa(codVentas.codAlumno) +
            '" />' +
            '<input type="hidden" name="identifierevent"  value="' +
            btoa(codVentas.codEvento) +
            '" />' +
            '<input type="hidden" name="identifiercourse"  value="' +
            btoa(codVentas.Idcurso) +
            '" />' +
            "</form>"
        );
        $("body").append(form);
        form.submit();
    }
    if ($(this).attr("id") == "historial") {
        let url = "history/";
        var form1 = $(
            '<form action="' + url + '" method="get">' +
            '<input type="hidden" name="identifiercustomer"  value="' +
            btoa(codVentas.codAlumno) +
            '" />' +
            "</form>"
        );
        $("body").append(form1);
        form1.submit();
    }
});

$(document).on("click", "#btn-SIA_A-busCursos", function() {
    TraerEventos();
    $("#btnCapturarEventosClase").removeClass("d-block");
    $("#btnCapturarEventosClase").addClass("d-none");
});

$(document).on("dblclick", ".rowcursosos", function() {
    let element = $(this)[0];
    let CodEvento = $(element).attr("capCodEvnt");
    $("#txtCodigoCurso").val(CodEvento);
    // alert(CodEvento);
    fnBuscarAlumnosXCurso();
    $("#btnCerrarModal").click();
});
// codigo para buscar cursos

function TraerEventos() {
    let EventosClase = "EventosClase";
    $.ajax({
        data: {
            EventosClase,
        },
        url: urlProyect + "controller/DevolverDatos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            let datos = JSON.parse(resp);
            let Cursos = "";
            let iconLive = `<span class="p-2 icon-feed" style="background:green; color:#fff; height: 20px;border-radius: 50%;" ></span>`;
            let iconOdemand = `<span class="p-2 icon-play2" style="background:red; color:#fff; height: 20px;border-radius: 50%;" ></span>`;
            let icono = "";
            datos.forEach((element) => {
                Cursos += `
            <div class="rowcursosos pt-2 pl-2 col-12 d-flex overflow-auto" capCodEvnt="${
              element.codEvento
            }" style="background: #ccc; margin-top:2px; cursor:pointer;">
              <div class="col-6">            
               
                <label for="${element.id}">${element.nombre}</label>
              </div>
              <div class="col-3d-lg-flex">            
              <span class="col-6">S/.${element.precioLocal}</span>
              <span class="col-6">$/.${element.precioCambio}</span>
            </div>
              <div class="col-3 p-1 d-flex align-items-center">
                <div class="col-8 d-none d-lg-block">${element.modalidad}</div>
                <div class="col-4">${fnIconosModalidadClase(
                  element.modalidad
                )}</div>
              </div>
            </div>`;
            });
            $(".contenedorCargarEventos").html(Cursos);
            $("div.holder").jPages({
                containerID: "contenedorCargarEventos",
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

// funcion para acortar url
function fnAcortarUrl(codAlumno, i) {
    let urlCertificados = urlProyect + "views/sia/certificates/?";
    let codEvento = $("#txtCodigoCurso").val();
    let idCurso = $("#txtidCurso").val();
    // let urlAAcortar=urlCertificados+"identifiercustomer="+btoa(codAlumno)+"&identifierevent="+btoa(codEvento)+"&identifiercourse="+btoa(idCurso)
    let urlAAcortar = "https://simetrika.online/views/login/";
    let valorRetorno = "";
    $.ajax({
        data: {
            urlAAcortar,
        },
        url: urlProyect + "controller/AcortarUrl.php",
        type: "post",
        cache: false,
        async: false,
        beforeSend: function() {},
        success: function(resp) {
            valorRetorno = resp;
            // $(`#tdLink${i}`).html(codAlumno);
        },
        error: function() {
            alert("error al guardar notas");
        },
    });
    return valorRetorno;
}