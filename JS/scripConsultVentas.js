import { urlProyect } from "./urlProyecto.js?jmk";
import { fnAlertTotalVentas } from "./urlProyecto.js?jmk";
import { fnIconosModalidadClase } from "./urlProyecto.js?jmk";

fnAlertTotalVentas();

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

// abrir ventana para buscar imagen
fnBuscarClienteEspecificoConCuotas($("#txtGetIdCliente").val(), $("#txtGetCodVenta").val());

$(document).on("dblclick", ".divBotonPagoCuota", function() {
    $("#imgBoucherPagoCuota").click();
});

$(document).on("change", "#imgBoucherPagoCuota", function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#formulariosGuardarPagoCuota + img").remove();
            $("#imagenBoucherCuota").attr("src", e.target.result);
        };

        reader.readAsDataURL(this.files[0]);
    }
});

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

$(document).on("keypress", "#txtBuscarClientedCuotas", function(e) {
    var code = e.keyCode ? e.keyCode : e.which;
    if (code == 13) {
        e.preventDefault();
        let pcBuscar = $("#txtBuscarClienteModal").val();
        let Campania = $("#cboCampaniaModal").val();
        let FechaInicio = $("#fecha_inicio").val();
        let FechaFinal = $("#fecha_final").val();
        let tipoBusqueda = "Cuota";

        $.ajax({
            data: {
                tipoBusqueda,
                pcBuscar,
                Campania,
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
                    Prospectos += ` <tr captIdCliente="${element.id}" captCodVenta="${element.codVenta}" class='celBusquedaClienteCuotas' id='celBusquedaClienteCuotas'>
                    <td class="tdNumero" style="width: 1px;">${i}</td>
                    <td>${element.campania}</td>
                    <td>${element.codVenta}</td>
                    <td>${element.fechaVenta}</td>                   
                    <td>${element.totalVenta}</td>                   
                    <td>${element.numCuotas}</td>                   
                   
                </tr>`;
                    i++;
                });
                $(`#tbodyBuscarClientesCuotas`).html(Prospectos);
                $("div.holder").jPages({
                    containerID: "tbodyBuscarClientesCuotas",
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

$(document).on("dblclick", ".celBusquedaClienteCuotas", function() {
    let element = $(this)[0];
    let idCliente = $(element).attr("captIdCliente");
    let CodVenta = $(element).attr("captCodVenta");
    $("#txtIdClientefrmConsultas").val(idCliente);
    $("#txtCodventafrmConsultas").val(CodVenta);
    // alert(idCliente+" venta "+CodVenta);
    // let RadioButon = $("input:radio[name=rbtipoBusqueda]:checked").val();
    fnBuscarClienteEspecificoConCuotas(idCliente, CodVenta);
    $(".cerrarModal").click();
});

// var mivariable="variable general";
// alert(mivariable);
// codigo para buscar las  ventas especificas
function fnBuscarClienteEspecificoConCuotas(idCliente, CodVenta) {
    // alert("idCliente "+idCliente+" codigo venta "+CodVenta);
    $.ajax({
        data: {
            idCliente,
            CodVenta,
        },
        url: "../../controller/DevolverDatos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            console.log(resp);
            let datos = JSON.parse(resp);
            console.log(datos);
            let tabla = "";
            let i = 1;
            let estadoPago = "";
            let iconEstadoSuccsess = `<span class="bg-success" id="iconEstado" style=" width: 20px;position: absolute;height: 20px;border-radius: 50%;" ></span>`;
            let iconEstadoAlert = `<span class="bg-warning" id="iconEstado" style=" width: 20px;position: absolute;height: 20px;border-radius: 50%;" ></span>`;
            let iconEstadoDanger = `<span class="bg-danger" id="iconEstado" style=" width: 20px;position: absolute;height: 20px;border-radius: 50%;" ></span>`;
            let icono;
            let boton;
            let DatosCursos = "";
            let DatosDocente = "";
            let FechasVenta = "";

            datos.forEach((element) => {
                // $("#txtidcliente").val(`${element.id}`);
                $("#txt-CampaniaDV").val(`${element.campania}`);
                $("#txt-CodVentaDV").val(`${element.codVenta}`);
                $("#txt-FechaVentaDV").val(`${element.fechaVentaGeneral}`);
                $("#txt-importeTotal_DV").val(`${element.totalVenta}`);

                $("#txt-NombresDV").val(`${element.nombres}`);
                $("#txt-ApellidosDV").val(`${element.apellios}`);
                $("#txt-CorreoDV").val(`${element.email}`);
                $("#txt-telefonoDV").val(`${element.telefono}`);


                element.DatosCuota.forEach((el) => {
                    if (`${el.estadoPago}` == "ESTC0001") {
                        icono = iconEstadoSuccsess;
                        boton = `<a href="#formulariosDetallePago" class="btnVerDetallePago btn btn-success d-inline-flex align-items-center;" rel="modal:open"><span class="icon-eye" style="font-size: 20px;"></span></a>`;
                    } else if (`${el.estadoPago}` == "ESTC0002") {
                        icono = iconEstadoAlert;
                        boton = `<a href="#formulariosGuardarPagoCuota" class="btnVerPagoCuota btn btn-warning" rel="modal:open"><span class="fas fa-edit"></span></a>`;
                    } else if (`${el.estadoPago}` == "ESTC0003") {
                        icono = iconEstadoDanger;
                        boton = `<a href="#formulariosGuardarPagoCuota" class="btnVerPagoCuota btn btn-danger" rel="modal:open"><span class="fas fa-edit"></span></a>`;
                    }

                    tabla += ` 
        <tr captIdCuota="${el.idCuota}" captCodCuota="${el.CodCuota}" class='celBusquedaClienteCuotas' id='celBusquedaClienteCuotas'>
          <td class="tdNumero" style="width: 1px;">${i}</td>
          <td>${el.fechaVenta}</td>
          <td>${el.fechaPago}</td>
          <td>${el.fechaVencimiento}</td>                   
          <td class="">${el.importeCuota}</td>
          <td class="">${el.cNomEstadoPago}</td>
          <td class="">${icono}</td>
          <td class="text-center">${boton}</td>
        </tr>`;
                });
                element.DatosCursos.forEach((ele) => {
                    DatosCursos += `<div class="co-12 d-flex">
                          <span class="col-7 p-2">${ele.nombreCurso}</span>
                          <span class="col-3 p-2">${ele.modalidadCurso}</span>
                          <span class="col-2 p-2">${fnIconosModalidadClase(ele.codModalidadCurso)}</span>
                        </div>
                        `;
                    FechasVenta += `
                      <div class="m-0 p-1 d-lg-flex justify-content-between">
                        <div class="p-0">
                          <p>Inicio </p>
                          <input type="text" value="${ele.fechaInicioAlumno}">
                        </div>
                        <div>
                          <p>Fin </p>
                          <input type="text" value="${ele.fechaFinalAlumno}">
                        </div>
                      </div>`;

                    DatosDocente += `<div>
                          <span>${ele.nombreDocente}</span>
                        </div>
                        `;
                });

                i++;
            });
            $(`#tbCuotasXCliente`).html(tabla);
            $(`#gbCargarCursos`).html(DatosCursos);
            $(`#gbCargarFechasVenta`).html(FechasVenta);
            $(`#gbCargarDocentes`).html(DatosDocente);
            // $(`#ContenCursosConsultas`).html(Cursos);
            // $(`#Contenedor_Loader`).hide();
        },
        error: function() {
            alert("error al cargar entidad bancaria");
        },
    });
}
// codigo para  accion de los botones de detalle de pago
$(document).on("click", ".btnVerDetallePago", function() {
    let element = $(this)[0].parentElement.parentElement;
    let idCuota = $(element).attr("captIdCuota");
    // alert(idCuota);
    let tipoBusqueda = "DetallePago";
    if (idCuota != undefined) {
        $("#txtIdCuota").val(idCuota);
        fnMostrar_detalle_Cuotas(idCuota, tipoBusqueda);
        // $(this)[0].attr("rel", "modal:open");
    }

    // $(".cerrarModal").click();
});

$(document).on("click", ".btnVerPagoCuota", function() {
    let element = $(this)[0].parentElement.parentElement;
    let idCuota = $(element).attr("captIdCuota");

    let tipoBusqueda = "PagarCuota";

    if (idCuota != undefined) {
        $("#txtIdCuota").val(idCuota);
        // alert(idCuota);
        fnMostrar_detalle_Cuotas(idCuota, tipoBusqueda);
        $(this)[0].attr("rel", "modal:open");
    }

    $(".cerrarModal").click();
});

function fnMostrar_detalle_Cuotas(idCuota, tipoBusqueda) {
    // alert(tipoBusqueda);
    $.ajax({
        data: {
            tipoBusqueda,
            idCuota,
        },
        url: "../../controller/DevolverDatos.php",
        type: "post",
        beforeSend: function() {},
        success: function(resp) {
            console.log(resp);
            let datos = JSON.parse(resp);
            let tabla = "";

            datos.forEach((element) => {
                if (tipoBusqueda == "DetallePago") {
                    // $("#txtidcliente").val(`${element.id}`);
                    $("#txtIdDetallePago").val(`${element.idDetallePago}`);
                    $("#txt-campania_VC").val(`${element.nomCampania}`);
                    $("#txt-codVenta_VC").val(`${element.codVenta}`);
                    $("#txt-FechaDeVenta_VC").val(`${element.fechaVenta}`);
                    $("#txt-importeTotal_VC").val(`${element.importeTotal}`);
                    $("#txt-codCuota_CC").val(`${element.CodCuota}`);
                    $("#txt-fechaPago_CC").val(`${element.fechaPago}`);
                    $("#txt-importCuota_CC").val(`${element.importeCuota}`);
                    $("#txt-tipoPago_CC").val(`${element.tipoPago}`);
                    $("#txt-entidadPago_CC").val(`${element.entidadPago}`);
                    // $("#imgBoucherDetallePagoConsulta").attr("src",`data:${element.tipoImagen};base64,${element.imgBoucher}`);
                    $("#imgBoucherDetallePagoConsulta").attr("src", `${urlProyect+element.imgBoucher}`);
                    // alert(element.imgBoucher);
                } else {
                    $("#txtIdClientePagoCuota").val(`${element.idCliente}`);
                    $("#txt-campania_VPC").val(`${element.nomCampania}`);
                    $("#txt-codVenta_VPC").val(`${element.codVenta}`);
                    $("#txt-FechaDeVenta_VPC").val(`${element.fechaVenta}`);
                    $("#txt-importeTotal_VPC").val(`${element.importeTotal}`);
                    $(".lblSimboloMonedaCuota").html(`${element.simboloMoneda}`);
                    $("#txtTipoMonedaCuota").val(`${element.idTipoMoneda}`);
                    $("#txt-importeRestante_VPC").val(`${element.imporRestante}`);
                    $("#txt-TotalCuotas_VPC").val(`${element.totalCuotas}`);
                    $("#txt-CuotasPagadas_VPC").val(`${element.totalCuotasPagadas}`);
                    $("#txt-restaDeCuotas_VPC").val(
                        parseInt(`${element.totalCuotas}` - `${element.totalCuotasPagadas}`)
                    );

                    $("#txt-idCuota_CPC").val(`${element.idCuota}`);
                    $("#txt-codCuota_CPC").val(`${element.CodCuota}`);
                    $("#txt-fechaPago_CPC").val(`${element.fechaPago}`);
                    // $("#txt-importCuota_CPC").val(`${element.importeTotal}`);
                }
            });
            // $(`#Contenedor_Loader`).hide();
        },
        error: function() {
            alert("error al cargar entidad bancaria");
        },
    });
}

// codigo para cargar entidad de pago

$(document).on("change", "#CboTipoPagoCuota", function() {
    let idtipoPago = $("#CboTipoPagoCuota").val();
    if (idtipoPago != 0) {
        $.ajax({
            data: {
                idtipoPago,
            },
            url: "../../controller/DevolverDatos.php",
            type: "post",
            beforeSend: function() {},
            success: function(resp) {
                $("#CboEntidadPagoCuota").html(resp);
            },
            error: function() {
                alert("error al cargar entidad bancaria");
            },
        });
    } else {
        $("#CboEntidadPago").html(0);
    }
});

$(document).on("click", "#btnGuardarPagoDeCuota", function(e) {
    e.preventDefault();
    // let aregloCursosParaVenta = new Array();
    let result = fnValidarCampos();
    if (result == true) {
        // alert("okok");
        let resCuotas = $("#txt-restaDeCuotas_VPC").val();
        let inPorteRestante = parseInt($("#txt-importeRestante_VPC").val());
        let inPorteAPagar = $("#txt-importCuota_CPC").val();
        // alert("iMPORTE RESTANTE "+inPorteRestante+" IMPORTE A PAGAR "+ inPorteAPagar);

        if (resCuotas == 1) {
            if (inPorteRestante == inPorteAPagar) {
                fnGuardarPagoDeCuotas();
            } else {
                msgAlertas(
                    "msjs",
                    "alert-danger",
                    "alert-success",
                    "Porfavor Ingrese Importe Completo"
                );
            }
        } else {
            // return;
            fnGuardarPagoDeCuotas();
        }
    }
});

function fnGuardarPagoDeCuotas() {
    // alert("oko");
    let datosFormulatio = new FormData($("#formulariosGuardarPagoCuota")[0]);
    console.log(datosFormulatio);
    // return;
    $.ajax({
        data: datosFormulatio,
        url: "../../controller/guardar_pagoCuotas.php",
        type: "post",
        dataType: "json",
        contentType: false,
        processData: false,
        beforeSend: function() {},
        success: function(resp) {

            console.log(resp);
            // return;
            if (resp.ok != undefined) {
                msgAlertas("msjs", "alert-success", "alert-danger", resp.ok);
                let idCliente = $("#txtIdClientefrmConsultas").val();
                let codCamoania = $("#txtCodventafrmConsultas").val();
                fnBuscarClienteEspecificoConCuotas(idCliente, codCamoania);
                fnAlertTotalVentas();
                $(".cerrarModal").click();
            } else {
                msgAlertas("msjs", "alert-danger", "alert-success", resp.error);
            }

            $(`#Contenedor_Loader`).hide();
        },
        error: function() {
            alert("error en el pago de cuota");
        },
    });
}

function fnValidarCampos() {
    if (
        $("#txt-importCuota_CPC").val() == "" ||
        $("#txt-importCuota_CPC").val() == 0
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Ingrese Inporte de Cuota"
        );
        $("#txt-importCuota_CPC").focus();
        return false;
    } else if (
        $("#CboTipoPagoCuota").val() == 0 ||
        $("#CboTipoPagoCuota").val() == "0"
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione Modo de Pago"
        );
        return false;
    } else if (
        $("#CboEntidadPagoCuota").val() == 0 ||
        $("#CboEntidadPagoCuota").val() == ""
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Seleccione Entidad de Pago"
        );
        return false;
    } else if (
        $("#imagenBoucherCuota").attr("src") == "" ||
        $("#imagenBoucherCuota").attr("src") == null
    ) {
        msgAlertas(
            "msjs",
            "alert-danger",
            "alert-success",
            "Elija Boucher de Pago"
        );
        return false;
    } else {
        return true;
    }
}

function msgAlertas(id, claseAdd, claseRemove, msg) {
    let iconoMensage = "";
    if (claseAdd == "alert-danger") {
        iconoMensage = "<span class='fas fa-exclamation-triangle mr-2'></span>";
    } else {
        iconoMensage = "<span class='fas fa-check-circle mr-2'></span>";
    }
    $("#" + id).addClass(claseAdd).html(iconoMensage + "   " + msg).show(300).delay(3000).hide(300);

    $("#" + id).removeClass(claseRemove);
}