import { fnAlertTotalVentas } from "./urlProyecto.js?hjhj";
import { fnIconosModalidadClase } from "./urlProyecto.js?jmk";
import { fnBorrarExportaciones } from "./urlProyecto.js?hjhj";
import { fnMostrarExportaciones } from "./urlProyecto.js?hjhj";

fnAlertTotalVentas();
var SubTotalVenta = 0;

function number_format(amount, decimals) {
    amount += ""; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, "")); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0;
    // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = "" + amount.toFixed(decimals);

    var amount_parts = amount.split("."),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, "$1" + "," + "$2");

    return amount_parts.join(".");
}

$(document).on("change", "#CboTipoMoneda", function() {
    let ValorMoneda = $("#CboTipoMoneda").val();
    let Simbolo = "";
    if (ValorMoneda == 0) {
        $("#btnBuscarEventoClase").removeClass("d-block");
        $("#btnBuscarEventoClase").addClass("d-none");
    } else {
        $("#btnBuscarEventoClase").removeClass("d-none");
        $("#btnBuscarEventoClase").addClass("d-block");
        if (ValorMoneda == 1) {
            Simbolo = "S/";
        } else if (ValorMoneda == 2) {
            Simbolo = "$/";
        }
        $(".lblSimboloMoneda").html(Simbolo);
        $("#txtTipoMoneda").val(ValorMoneda);
    }
});
$(document).on("change", "#cboPais", function() {
    let idPais = $("#cboPais").val();
    $.ajax({
        data: {
            idPais
        },
        url: "../../controller/DevolverDatos.php",
        type: "post",
        beforeSend: function() {},
        success: function(response) {
            let datos = JSON.parse(response);
            let codigo = "";
            datos.forEach((element) => {
                $("#txtCodigoPais").val(`${
                element.codigo
            }`);
            });

        },
        error: function() {
            alert("error al cargar codigo");
        }
    });
});


// abrir ventana para buscar imagen

$(document).on("dblclick", ".divBoton", function() {
    $("#imgBoucherPago").click();
});

// previsualizar imagen de boucher
$(document).on("change", "#imgBoucherPago", function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#formulario-ventas + img").remove();
            $("#imgBoucher").attr("src", e.target.result);
        };

        reader.readAsDataURL(this.files[0]);
    }
});

$(document).on("change", "#CboTipoPago", function() {
    let idtipoPago = $("#CboTipoPago").val();
    if (idtipoPago != 0) {
        $.ajax({
            data: {
                idtipoPago,
            },
            url: "../../controller/DevolverDatos.php",
            type: "post",
            beforeSend: function() {},
            success: function(resp) {
                $("#CboEntidadPago").html(resp);
            },
            error: function() {
                alert("error al cargar entidad bancaria");
            },
        });
    } else {
        $("#CboEntidadPago").html(0);
    }
});

// codigo para buscar cursos

$(document).on("click", "#btnBuscarEventoClase", function() {
    TraerEventos();
});

function TraerEventos() {
    let EventosClase = "EventosClase";
    $.ajax({
        data: {
            EventosClase,
        },
        url: "../../controller/DevolverDatos.php",
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
            <div class="contenChecks pt-2 pl-2 col-12 d-flex overflow-auto">
              <div class="col-6">            
                <input type="checkbox"  class="cheksEventos" name="" id="${
                  element.id
                }" value="${element.id}">
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

$(document).on("change", ".cheks", function() {
    /* var selected = new Array();
      $(document).ready(function() {
        $(&quot;input:checkbox:checked&quot;).each(function() {
           selected.push($(this).val());
        });
    }); */
    /* let ids= $(`input:checkbox[class=cheks]:checked`).val();
      alert(ids); */
});

// codigo para capturar los cursos especificos
$(document).on("click", "#btnCapturarEventosClase", function() {
    $(".contenedorLLanarEventosClase").html("");
    let aregloEventos = new Array();
    let seleccionados = $("input:checkbox[class=cheksEventos]:checked");
    // let DatosCursos=$("#formulariosBuscarCurso").serialize();
    let idMoneda = $("#CboTipoMoneda").val();
    $(seleccionados).each(function() {
        aregloEventos.push($(this).val());
    });
    // alert(JSON.stringify(aregloEventos));
    $.ajax({
        data: {
            // arregloCursos: JSON.stringify(aregloCursos),
            arregloEventosClase: JSON.stringify(aregloEventos),
            idMoneda,
        },
        url: "../../controller/DevolverDatos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            console.log(resp);
            let cursosEspecificos = "";
            let precioTotal = 0;
            let iconLive = `<span class="p-2 icon-feed" style="background:green; color:#fff; height: 20px;border-radius: 50%;" ></span>`;
            let iconOdemand = `<span class="p-2 icon-play2" style="background:red; color:#fff; height: 20px;border-radius: 50%;" ></span>`;
            let icono = "";
            let i = 0;
            let simbMoneda = idMoneda == 1 ? "S/." : "$/.";
            let datos = JSON.parse(resp);
            datos.forEach((element) => {
                icono = element.modalidad == "Live" ? iconLive : iconOdemand;
                precioTotal += parseFloat(element.precio);
                cursosEspecificos += `
            <div class="contenCursosClasesEspecificos pt-2 pb-2 pl-0 pr-0 d-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom:solid 1px #ccc;">
                <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                  <input type="checkbox"  class="cheks m-0" name="checksBoxClases${i}" id="${element.id}" value="${element.id}" checked>
                  <label for="">${element.nombre}</label>
                </div>
                <div class="col-3 p-2 d-flex align-items-center">
                  <div class="col-8 d-none d-lg-block">${element.modalidad}</div>
                  <div class="col-4">${icono}</div>
                </div>  
            </div>`;
                // precioSubTotal += parseFloat(element.precio);
                i++;
                $("#dtFechaInicio").val(element.dFechaInicio);
                $("#dtFechaFin").val(`${element.dFechaFinal}`);
                $("#txtFechaInicio").val(element.dFechaInicio);
                $("#txtFechaFin").val(`${element.dFechaFinal}`);
                $("#CboCampaniaVenta").val(element.idCampania);
            });
            aregloEventos = [];
            console.log(aregloEventos);
            SubTotalVenta = precioTotal;
            $("#txtNumeroCursos").val(i);
            $("#txtTotalPagar").val(number_format(SubTotalVenta, 2));
            $("#txtPagoPrimeraCuota").val(number_format(SubTotalVenta, 2));
            $("#txtMontoRestante").val(number_format("000", 2));
            $("#txtDescuento").val(number_format(0));
            $(".contenedorLLanarEventosClase").show();
            $(".contenedorLLanarEventosClase").html(cursosEspecificos);

            // $(`#Contenedor_Loader`).hide();
            $(`#cerrarModal`).click();
        },
        error: function() {
            alert("error al cargar entidad bancaria");
        },
    });
});

$(document).on("change", "#cboEventoModal", function() {
    let idEvento = $("#cboEventoModal").val();
    if (idEvento != 0) {
        $.ajax({
            data: {
                idEvento,
            },
            url: "../../controller/DevolverDatos.php",
            type: "post",
            beforeSend: function() {},
            success: function(resp) {
                $("#cboCursosXevento").html(resp);
            },
            error: function() {
                alert("error al cargar entidad bancaria");
            },
        });
    } else {
        $("#CboEntidadPago").html(0);
    }
});

// codigo para buscar  cliente para venta
$(document).on("click", "#rbCliente", function() {
    // alert("click");
    $(".divdinamicosBusqueda").addClass("d-none");
    $(".divdinamicosBusqueda").removeClass("d-block");
    $(".contenCampaniaBusq").addClass("col-lg-10");
    $(".contenCampaniaBusq").removeClass("col-lg-4");
    $("#headerNombresAlumno").html("Cliente");
});
$(document).on("click", "#rbProspecto", function() {
    // alert("click");
    $(".contenCampaniaBusq").addClass("col-lg-4");
    $(".contenCampaniaBusq").removeClass("col-lg-10");
    $(".divdinamicosBusqueda").removeClass("d-none");
    $(".divdinamicosBusqueda").addClass("d-block");
    $("#headerNombresAlumno").html("Prospecto");
});

$(document).on("keypress", "#txtBuscarClienteModal", function(e) {
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

        /*  alert("Radio "+RadioButon+" Campania "+Campania+" Evento "+Evento
            +" Curso "+CursoXevento+" fecha inicio "+FechaInicio+" fecha final "+FechaFinal); */
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
            url: "../../controller/DevolverDatos.php",
            type: "post",
            beforeSend: function() {},
            success: function(resp) {
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
            error: function() {
                alert("error al cargar entidad bancaria");
            },
        });
    }
});

$(document).on("dblclick", ".celBusquedaCliente", function() {
    let element = $(this)[0];
    let idCliente = $(element).attr("captIdCliente");
    let codCliente = $(element).attr("captCodCliente");
    let RadioButon = $("input:radio[name=rbtipoBusqueda]:checked").val();
    fnBuscarClienteEspecifico(idCliente, codCliente, RadioButon);
    $("#cerrarModal").click();
});

function fnBuscarClienteEspecifico(idCliente, codCliente, RadioButon) {
    $.ajax({
        data: {
            idCliente,
            codCliente,
            RadioButon,
        },
        url: "../../controller/DevolverDatos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            console.log(resp);
            let datos = JSON.parse(resp);
            datos.forEach((element) => {
                $("#txtidcliente").val(`${element.id}`);
                $("#txtCodCliente").val(`${element.codCliente}`);
                $("#lblNombresV").val(`${element.nombres}`);
                $("#txtNombresCliOrig").val(`${element.nombres}`);
                $("#lblApellidosV").val(`${element.apellidos}`);
                $("#lblCorreoV").val(`${element.email}`);
                $("#txtCorreoCliOrig").val(`${element.email}`);
                $("#lblTelefonoV").val(`${element.telefono}`);

                $("#txtCodigoPais").val(`${element.codigoTelPais}`);

                // $("#lblPaisV").val(`${element.pais}`);
                $("#cboPais").val(`${element.codPais}`);
            });
            // $(`#Contenedor_Loader`).hide();
        },
        error: function() {
            alert("error al cargar entidad bancaria");
        },
    });
}

// codigo transaccional

// codigo para habiilitar radio de descuento

$(document).on("change", "#CboPagoEstablecido", function() {
    let pcUsoPrecioAcual = $("#CboPagoEstablecido").val();
    if (pcUsoPrecioAcual == 2) {
        $("#rbDescuento").addClass("d-block");
        $("#rbDescuento").removeClass("d-none");

        $("#rbDUo").addClass("d-block");
        $("#rbDUo").removeClass("d-none");

        $("#txtOtroMonto").prop("disabled", false);
        $("#txtOtroMonto").focus();
    } else {
        $("#rbDescuento").removeClass("d-block");
        $("#rbDescuento").addClass("d-none");

        $("#rbDUo").removeClass("d-block");
        $("#rbDUo").addClass("d-none");

        $("#txtOtroMonto").prop("disabled", true);
        $("#txtOtroMonto").val(0);
        fnCalcularDescuento();
    }
});

// codigo para sumar el campo descuento al total
$(document).on("keyup", "#txtDescuento", function() {
    // alert("ok");
    $("#CboPagoPorCuotas").val(0);
    fnCalcularDescuento();

    if ($("#txtNumeroCuotas").val() > 1) {
        fnCalcularMontoRestantePorCuota();
    } else {
        $("#txtPagoPrimeraCuota").val(number_format($("#txtTotalPagar").val(), 2));
        $("#txtMontoRestante").val(number_format("000", 2));
    }
});

function fnCalcularDescuento() {
    let pOtroMonto = $("#txtDescuento").val();
    let pTotalAPagar = 0;
    if (pOtroMonto == "") {
        pOtroMonto = 0;
    } else {
        pOtroMonto = parseFloat($("#txtDescuento").val());
        pTotalAPagar = parseFloat(SubTotalVenta - pOtroMonto);
        $("#txtTotalPagar").val(number_format(pTotalAPagar, 2));
        $("#txtPagoPrimeraCuota").val(number_format(pTotalAPagar, 2));
    }
}

function fnCalcularAumento() {
    let pOtroMonto = $("#txtOtroMonto").val();
    let CSubtotal = parseFloat($("#txtSubtotal").val());
    let pTotalAPagar = 0;
    if (pOtroMonto == "") {
        pOtroMonto = 0;
    } else {
        pOtroMonto = parseFloat($("#txtOtroMonto").val());
        pTotalAPagar = parseFloat(pOtroMonto + CSubtotal);
        $("#txtTotalPagar").val(pTotalAPagar);
    }
}

$(document).on("change", "#CboPagoPorCuotas", function() {
    let datoCuotas = $("#CboPagoPorCuotas").val();
    if (datoCuotas == 2) {
        $("#txtNumeroCuotas").prop("readonly", false);
        $("#txtNumeroCuotas").css("background-color", "white");
        $("#txtNumeroCuotas").focus();
        $("#txtNumeroCuotas").val("2");
        $("#txtPagoPrimeraCuota").prop("readonly", false);
        $("#txtPagoPrimeraCuota").val("");
        $("#txtPagoPrimeraCuota").css("background-color", "white");

        fnCalcularFechaXNumeroDeCuotas();
        // $("#conten-txt-cuotas").removeClass("d-none");
    } else {
        // $("#conten-txt-cuotas").removeClass("d-lg-flex");
        $("#txtNumeroCuotas").css("background-color", "#F5F5F5");
        $("#txtPagoPrimeraCuota").css("background-color", "#F5F5F5");

        $("#txtNumeroCuotas").prop("readonly", true);
        $("#txtNumeroCuotas").val("1");
        $("#txtPagoPrimeraCuota").prop("readonly", true);
        $("#txtPagoPrimeraCuota").val(number_format($("#txtTotalPagar").val(), 2));
        $("#txtMontoRestante").val(number_format("000", 2));
        fnCalcularFechaXNumeroDeCuotas();
        // $("#conten-txt-cuotas").addClass("d-none");
    }
});

$(document).on("keyup", "#txtPagoPrimeraCuota", function() {
    fnCalcularMontoRestantePorCuota();
});

$(document).on("keyup", "#txtNumeroCuotas", function() {
    fnCalcularFechaXNumeroDeCuotas();
});

function fnCalcularFechaXNumeroDeCuotas() {
    let numeroCuotas = $("#txtNumeroCuotas").val();
    // alert(numeroCuotas);
    let datetimes = "";
    if (numeroCuotas > 1) {
        for (let index = 0; index < numeroCuotas - 1; index++) {
            datetimes += `<div class="p-0 mt-3 d-block col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 mt-lg-0">
      <label for="txtNumeroCuotas" class="p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">Fecha de pago cuota N°${
        index + 2
      }</label>
      <input type="date" name="dtt${index}" id="dtt${index}" class="dtt-fechaPago col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" >
      </div>`;
            arayFechas.push(index);
        }
        $("#conten-dttme-cuotas").html(datetimes);
    } else {
        $("#conten-dttme-cuotas").html("");
    }
}

function fnCargarLoader($estado) {
    $("#Contenedor_Loader").css("display", $estado);
}

function fnCalcularMontoRestantePorCuota() {
    let primeraCuota = $("#txtPagoPrimeraCuota").val();
    let TotalAPagar = $("#txtTotalPagar").val();
    let Montorestante = parseFloat(TotalAPagar - primeraCuota);
    $("#txtMontoRestante").val(number_format(Montorestante, 2));
}
// codigo para enviar datos del modal al formulario de ventas
$(document).on("change", "#cboModalidad", function() {
    $("#txtModalidadCurso").val($("#cboModalidad").val());
});
$(document).on("change", "#dtFechaInicio", function() {
    $("#txtFechaInicio").val($("#dtFechaInicio").val());
});
$(document).on("change", "#dtFechaFin", function() {
    $("#txtFechaFin").val($("#dtFechaFin").val());
});
$(document).on("change", "#cboProgresoClase", function() {
    $("#txtProgresoClase").val($("#cboProgresoClase").val());
});

// codigo para guardar venta
var arayFechas = new Array();
$(document).on("click", "#btnGuardarVenta", function(e) {
    e.preventDefault();
    fnCargarLoader("block");
    // return;
    // let aregloCursosParaVenta = new Array();
    // alert($("#CboEstadoVenta").val()+" cuotas "+$("#txtNumeroCuotas").val());
    let result = fnValidarCampos();
    if (result == true) {
        var tamanoImagen = document.getElementById("imgBoucherPago").files[0].size;
        // let result = true;
        // if (tamanoImagen < 1048576) {
        if (
            $("#CboEstadoVenta").val() == "'ESTV0002'" &&
            $("#txtNumeroCuotas").val() != 1
        ) {
            msgAlertas(
                "msjs",
                "alert-danger",
                "alert-success",
                "No puedes cerrar esta venta porque falta pago de cuotas"
            );
        } else if (
            $("#txtNumeroCuotas").val() == 1 &&
            $("#CboEstadoVenta").val() != "'ESTV0002'"
        ) {
            msgAlertas(
                "msjs",
                "alert-danger",
                "alert-success",
                "Si la cuota es unica es nesesario cerrar la venta"
            );
        } else {
            let datosFormulatio = new FormData($("#formulario-ventas")[0]);
            // let datosFormulatio = $("#formulario-ventas").serialize();
            $.ajax({
                data: datosFormulatio,
                url: "../../controller/guardar_venta.php",
                type: "POST",
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: function(resp) {
                    console.log(resp);
                    if (resp.ok != undefined) {
                        msgAlertas("msjs", "alert-success", "alert-danger", resp.ok);
                        fnAlertTotalVentas();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
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
        // } else {
        //     msgAlertas("msjs", "alert-danger", "alert-success", "La imagen que Intentas Subir Es demaciado grande");
        //     $(`#Contenedor_Loader`).delay(1000).hide(200);
        // }
    } else {
        $(`#Contenedor_Loader`).delay(1000).hide(200);
    }
});

function msgAlertas(id, claseAdd, claseRemove, msg) {
    let iconoMensage = "";
    if (claseAdd == "alert-danger") {
        iconoMensage = "<span class='fas fa-exclamation-triangle mr-2'></span>";
    } else {
        iconoMensage = "<span class='fas fa-check-circle mr-2'></span>";
    }
    $("#" + id)
        .addClass(claseAdd)
        .html(iconoMensage + "   " + msg)
        .show(300)
        .delay(3000)
        .hide(300);

    $("#" + id).removeClass(claseRemove);
    $(`#Contenedor_Loader`).delay(1000).hide(100);
}

// $("#lblTelefonoV").addClass("bg-danger");
function fnValidarCampos() {
    let msg = "";

    if ($("#txtidcliente").val() == "" || $("#txtidcliente").val() == 0) {
        msgAlertas("msjs", "alert-danger", "alert-success", "Elijá cliente");
        return false;
    } else if (
        $("#CboTipoMoneda").val() == "0" ||
        $("#CboTipoMoneda").val() == 0
    ) {
        msgAlertas("msjs", "alert-danger", "alert-success", "Elijá Tipo de Moneda");
        $("#CboTipoMoneda").focus();
        return false;
    } else if ($("#CboCampaniaVenta").val() == 0) {
        msgAlertas("msjs", "alert-danger", "alert-success", "Seleccione Campaña");
        return false;
    } else if (
        $("#txtNumeroCursos").val() == "" ||
        $("#txtNumeroCursos").val() == 0
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione el/los cursos"
        );
        return false;
    } else if (
        $("#txtTotalPagar").val() == "" ||
        $("#txtTotalPagar").val() == null
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Ingrese Total a Pagar"
        );
        $("#txtTotalPagar").focus();
        return false;
    } else if ($("#CboPagoPorCuotas").val() == 0) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione Tipo de Pago (Unico ó en cuotas)"
        );
        $("#CboPagoPorCuotas").focus();
        return false;
    } else if ($("#CboTipoPago").val() == 0) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione Modo de pago"
        );

        return false;
    } else if (
        $("#CboEntidadPago").val() == 0 ||
        $("#CboEntidadPago").val() == ""
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione Entidad de Pago"
        );

        return false;
    } else if (
        $("#txtPagoPrimeraCuota").val() == "" ||
        $("#txtPagoPrimeraCuota").val() == 0
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Ingrese Monto de Primera Cuota"
        );
        return false;
    } else if (
        $("#CboEstadoVenta").val() == 0 ||
        $("#CboEstadoVenta").val() == "'0'"
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione Estado de Venta"
        );
        return false;
    } else if ($(".dtt-fechaPago").val() == "") {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione la/las Fechas de pago"
        );
        return false;
    } else if ($("#imgBoucherPago").val() == "") {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Porfavor elegir Boucher de pago"
        );
        return false;
    } else if ($("#txtFechaInicio").val() == "") {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione Fecha de Inicio del Curso de este alumno"
        );
        return false;
    } else if ($("#txtFechaFin").val() == "") {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione Fecha de Final del Curso de este alumno"
        );
        return false;
    } else if ($("#txtProgresoClase").val() == 0) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione estad de progreso del curso"
        );
        return false;
    } else {
        return true;
    }
}