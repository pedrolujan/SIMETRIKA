import { urlProyect } from "./urlProyecto.js?wjhhe";
import { fnIconosModalidadClase } from "./urlProyecto.js?wjhhe";

fnListarUltmasventas();
fnListarCursosConMayorAlumnado();
function fnListarUltmasventas() {
  let BuscarVentasRecientes = 0;
  $.ajax({
    data: {BuscarVentasRecientes},
    url: urlProyect + "controller/alertas_dashboard.php",
    type: "post",
    // dataType: "json",
    beforeSend: function () {},
    success: function (resp) {
      let datos=JSON.parse(resp);
      let rows="";
      datos.forEach(element => {
        rows+=`<div class="border pt-2 pb-2 p-1 col-12 mt-2 d-flex" style="background-color: #fff;">
                  <div class="text-left m-0 p-0 col-5 col-md-4"><span>${element.cliente}</div>
                  <div class="text-left m-0 p-0 col-md-1">${fnIconosModalidadClase(element.codModalidad)}</div>
                  <div class="text-center m-0 p-0 col-3 col-md-2">${element.estadoVenta}</div>
                  <div class="text-center d-none d-md-block m-0 p-0 col-3">${element.abrCursos}</div>
                  <div class="text-center m-0 p-0 col-3 col-md-2">${element.importe}</div>
              </div>`;
      });

      $("#cargarUltimasVentas").html(rows);
    },
    error: function (ex) {
      console.log(ex);
      alert("error al listar ultimas Ventas");
    },
  });
}
function fnListarCursosConMayorAlumnado() {
  let BuscarCursosConMasAlumnado = 0;
  $.ajax({
    data: {BuscarCursosConMasAlumnado},
    url: urlProyect + "controller/alertas_dashboard.php",
    type: "post",
    // dataType: "json",
    beforeSend: function () {},
    success: function (resp) {
      let datos=JSON.parse(resp);
      let rows="";
      datos.forEach(element => {
        rows+=`<div class="border pt-2 pb-2 p-1 col-12 mt-2 d-flex" style="background-color: #fff;">
                  <div class="text-left m-0 p-0 col-10 col-md-10"><span>${element.curso}</div>
                  <div class="text-center d-flex align-items-center justify-content-center" style="font-size: 12px ;height: 30px; width: 30px;border-radius: 50%;background-color: #7B3090; color:#ffffff ">
                    ${element.numAlumnos}
                  </div>
              </div>`;
      });

      $("#cargarCursosMayorAlumnado").html(rows);
    },
    error: function (ex) {
      console.log(ex);
      alert("error al listar ultimas Ventas");
    },
  });
}
