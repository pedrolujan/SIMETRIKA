export const urlProyect = "http://localhost/SIMETRIKA/";

export function funcionMensaje(dato1, id) {
    if (dato1.error !== undefined) {
        $(`#${id}`).addClass("respuestaError").text(dato1.error).show(300).delay(4000).hide(300);
        $(`#${id}`).removeClass("respuestaOk");
        return false;
    }
    if (dato1.exito !== undefined) {
        $(`#${id}`).addClass("respuestaOk").text(dato1.exito).show(300).delay(4000).hide(300);
        $(`#${id}`).removeClass("respuestaError");
    }

}

export function fnCargarLoader($estado) {
    $("#Contenedor_Loader").css("display", $estado);
}

export function msgAlertas(id, claseAdd, claseRemove, msg) {
    let iconoMensage = "";
    if (claseAdd == "alert-danger") {
        iconoMensage = "<span class='fas fa-exclamation-triangle mr-2'></span>";
    } else {
        iconoMensage = "<span class='fas fa-check-circle mr-2'></span>";
    }
    $("#" + id).addClass(claseAdd).html(iconoMensage + "   " + msg).show(300).delay(3000).hide(300);
    $("#" + id).removeClass(claseRemove);
    $(`#Contenedor_Loader`).delay(1000).hide(100);
}
export function fnIconosModalidadClase(modalidad) {
    let iconLive = `<span class="p-2 icon-feed" style="background:green; color:#fff; height: 20px;border-radius: 50%;" ></span>`;
    let iconOdemand = `<span class="p-2 icon-play2" style="background:red; color:#fff; height: 20px;border-radius: 50%;" ></span>`;
    let icono = (modalidad == "Live" || modalidad == "MODV0001") ? iconLive : iconOdemand;
    return icono;
}


export function fnBotonEdicionXEstadoVenta(CodEstadoventa) {
    let boton = "";
    if (`${CodEstadoventa}` == "ESTV0002") {
        boton = `<span title="Ver detalle de Venta" class="btnVerDetalleVenta d-block btn btn-success d-inline-flex align-items-center;" rel="modal:open"><span class="icon-eye" style="font-size: 20px;"></span></span>`;
    } else if (`${CodEstadoventa}` == "ESTV0001") {
        boton = `<span title="Ver y/o Pagar Cuotas" class="btnVerPagoCuota btn btn-warning" rel="modal:open"><span class="fas fa-edit"></span></span>`;
    } else if (`${CodEstadoventa}` == "ESTV0003") {
        boton = `<span class="btnVerPagoCuota btn btn-danger" rel="modal:open"><span class="fas fa-edit"></span></span>`;
    }
    return boton;
}
export function fnBotonEditar() {
    let boton = "";

    boton = `<span title="Editar" class="btnEditar btn btn-primary" rel="modal:open"><span class="fas fa-edit"></span></span>`;

    return boton;
}
export function fnIconosEdicionXEstadoVenta(CodEstadoventa) {
    let icono = "";
    let iconEstadoSuccsess = `<span class="bg-success"  id="iconEstado" style=" margin-right:12px; width: 20px;position: absolute; height: 20px;border-radius: 50%;" ></span>`;
    let iconEstadoAlert = `<span class="bg-warning" id="iconEstado" style=" margin-right:12px; width: 20px;position: absolute; height: 20px;border-radius: 50%;" ></span>`;
    let iconEstadoDanger = `<span class="bg-danger" id="iconEstado" style=" margin-right:12px; width: 20px;position: absolute; height: 20px;border-radius: 50%;" ></span>`;
    if (`${CodEstadoventa}` == "ESTV0002") {
        icono = iconEstadoSuccsess;
    } else if (`${CodEstadoventa}` == "ESTV0001") {
        icono = iconEstadoAlert;
    } else if (`${CodEstadoventa}` == "ESTV0003") {
        icono = iconEstadoDanger;
    }
    return icono;
}
export function fnAlertTotalVentas() {
    let AlertTotalVentas = 0;
    let CntUnidades = 0;
    $.ajax({
        url: urlProyect + "controller/DevolverDatos.php",
        type: "post",
        data: {
            AlertTotalVentas
        },
        // dataType: "json",
        success: function (resp) {
            console.log(resp);
            let datos = JSON.parse(resp);
            console.log(datos[0].numeroVentas + datos[1].numeroVentasDolar);
            CntUnidades = parseInt(`${
                datos[0].numeroVentas
            }`) + parseInt(`${
                datos[1].numeroVentasDolar
            }`);
            $("#alert-contador-ventas").html(`${CntUnidades}`);
            $(".contadorVentasSoles").html(`${
                datos[0].numeroVentas
            }`);
            $(".totalDineroVentasSoles").html(`${
                datos[0].sumaVentas
            }`);
            $(".ContadorVentasDolar").html(`${
                datos[1].numeroVentasDolar
            }`);
            $(".totalDineroDolar").html(`${
                datos[1].sumaVentasDolar
            }`);
        }
    });
}

// var TipOpcion = {};
export function fnTipoOpcionContextmenu(idContext,divPos) {
  var contextElement = document.getElementById(idContext);
  contextElement.style.top = ((divPos.top+180)-$(window).scrollTop()) + "px";
  contextElement.style.left = divPos.left+100 + "px";
  contextElement.classList.add("active");
  
}


export function number_format(amount, decimals) {
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

  export function fnBorrarExportaciones(id) {
    var table = $(`#${id}`).DataTable();
    table.destroy();
  }
  export function fnMostrarExportaciones(id,textoBuscar,botones) {
    $(`#${id}`).DataTable({
      language: {
        lengthMenu: "Mostrar _MENU_ registros",
        zeroRecords: "No se encontraron resultados",
        info: "Registros del _START_ al _END_ de _TOTAL_ registros",
        infoEmpty: "No se encontro resultados",
        infoFiltered: "(filtrado de un total de _MAX_ registros)",
        sSearch: `${textoBuscar}:</br>`,
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
    //   dom: "fBrtilp",
      dom: `${botones}`,
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