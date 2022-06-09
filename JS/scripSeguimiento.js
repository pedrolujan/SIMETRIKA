import { urlProyect } from "./urlProyecto.js?wjhhe";
import { msgAlertas } from "./urlProyecto.js?777";
import { fnCargarLoader } from "./urlProyecto.js?hjhj";

fnBuscarProspectos();
fnBuscarSeguimiento()
$(document).ready(function(){
    // setTimeout(function () {
        // fnCargarLoader("block");
    //     alert($("#txtIdProspecto").val());
    // }, 3200);
})

$(document).on("click", "#btnEditarNotas", function () {
    if($("#btnEditarNotas").val()=="Editar Datos"){
  
      $(".txtinputs").addClass("d-block");
      $(".txtinputs").removeClass("d-none");
  
      $(".spanDatos").addClass("d-none");
      $(".spanDatos").removeClass("d-block");
  
      $("#btnEditarNotas").val("Guardar Cambios");
    }else if($("#btnEditarNotas").val()=="Guardar Cambios"){
        fnCargarLoader("block");
      
        let formActualizarProspectos = $("#formularioActualizarProspectos").serialize();
        $.ajax({
          data: formActualizarProspectos,
          url: urlProyect + "controller/registro_accionPersonal.php",
          type: "post",
          dataType: "json",
          // async: true,
          success: function (resp) {
            resp.ok!=undefined?msgAlertas("msjs","alert-success","alert-danger",resp.ok):msgAlertas("msjs","alert-danger","alert-success",resp.error);
            if(resp.ok != undefined){
              setTimeout(function () {
                location.reload();
            }, 1000);
          }
          },
          
        });
    }
    
  });

  
$(document).on("click", "#btnGuardarRegistro", function (e) {
    e.preventDefault();
    fnCargarLoader("block");
    let datos = $("#FormularioAccionSupervisor").serialize();
    $.ajax({
      data: datos,
      url: urlProyect + "controller/registro_accionPersonal.php",
      type: "post",
      dataType: "json",
    //   async: true,
      success: function (resp) {
        resp.exito!=undefined?msgAlertas("msjs","alert-success","alert-danger",resp.exito):msgAlertas("msjs","alert-danger","alert-success",resp.error);
        if(resp.exito!=undefined){
            setTimeout(function () {
                location.reload();
            }, 1000);
        }
        
      },
    });
  });
  
function fnBuscarProspectos() {
    fnCargarLoader("block");
    var mensaje = {};
    let idProspecto = $("#txtIdProspecto").val();
    let idPersonal = $("#txtidUsuarioPersonal").val();
    let BuscarParaSeguimineto="ok";
    $.ajax({
        data: {
            idProspecto ,
            idPersonal ,
            BuscarParaSeguimineto
           },
        url: urlProyect + "controller/buscar_prospectos.php",
        type: "post",
        beforeSend: function () {},
        success: function (resp) {
            console.log(resp);
            let datos = JSON.parse(resp.toString());
          datos.forEach((element) => {
            $("#spanNombres").html(`${element.nombres}`);
            $("#txtNombres").val(`${element.nombres}`);
            $("#spanApellios").html(`${element.apellidos}`);
            $("#txtApellidos").val(`${element.apellidos}`);
            $("#spanCorreo").html(`${element.Correo}`);
            $("#txtCorreo").val(`${element.Correo}`);
            $("#spanTelefono").html(`${element.telefono}`);
            $("#txttelefono").val(`${element.telefono}`);
            $("#spanPais").html(`${element.pais}`);
            $("#cboPais").val(`${element.codPais}`);
            $("#aLinkWP").attr("href",
            `https://api.whatsapp.com/send?phone=${element.telefono}&text=Hola  ${element.nombres}`);
          });
          fnCargarLoader("none");
        },
        error: function () {
          alert("error al buscar prospecto");
        },
      });

  }
  
  
// / codigo para buscar seguimiento
function fnBuscarSeguimiento() {
    let idProspecto = $("#txtIdProspecto").val();
    let idPersonal = $("#txtidUsuarioPersonal").val();
  
    $.ajax({
      data: {
        idProspecto,
        idPersonal,
      },
      url: urlProyect + "controller/buscar_prospectos.php",
      type: "post",
      // dataType: "JSON",
      // async: true,
      success: function (response) {
        let datos = JSON.parse(response);
        let seguimiento = "";
        let i = 1;
        datos.forEach((element) => {
          seguimiento += ` <tr class='celProspecto' id='celProspecto'>
                  <td>${element.fecha}</td>
                  <td>${element.accion}</td>
                  <td>${element.descripcion}</td>               
                 
              </tr>`;
          i++;
        });
        $(`#tbDatosSeguimiento`).html(seguimiento);
      },
  
      error: function () {},
    });
  }
  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}