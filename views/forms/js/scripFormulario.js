import { urlProyect } from "../../../JS/url.js";
import { funcionMensaje } from "../../../JS/url.js";

const formulario = document.getElementById("contenedor_formulario");
const inputs = document.querySelectorAll("#contenedor_formulario input");
const combos = document.querySelectorAll("#contenedor_formulario select");
const radios = document.querySelectorAll("#contenedor_formulario .cheks");

const expresiones = {
  usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
  nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
  password: /^.{4,12}$/, // 4 a 12 digitos.
  correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
  telefono: /^\d{7,14}$/, // 7 a 14 numeros.
  edad: /^\d{2,2}$/,
};

var numPreguntas = 0;
var preguntas = new Array();
var respuestas = new Array();
/* TraerCursos(); */

const campos = {
  txtEmail: false,
  txtApePaterno: false,
  txtApeMaterno: false,
  txtnombres: false,
  txtNumCelular: false,
  txtEdad: false,
  CboPais: false,
  respuesta6: false,
  respuesta7: false,
};
$("#btn_guardar").click(function (e) {
  e.preventDefault();
  $(`#Contenedor_Loader`).show();
  const terminos = document.getElementById("terminos");

  if ($(`input:checkbox[id=chkTerminosCondiciones]:checked`).val()) {
    if (
      campos.txtEmail == true &&
      campos.txtApePaterno == true &&
      campos.txtApeMaterno == true &&
      campos.txtnombres == true &&
      campos.txtNumCelular == true &&
      campos.CboPais ==
        true /* && campos.respuesta6==true && campos.respuesta7 */
    ) {
      let datos = $("#contenedor_formulario").serialize();
      $.ajax({
        data: datos,
        url: urlProyect + "controller/registro_prospecto.php",
        type: "post",
        dataType: "json",
        async: true,
        success: function (resp) {
          funcionMensaje(resp, "formulario__mensaje");
          $(`#Contenedor_Loader`).hide();
          if (resp.exito != undefined) {
            setTimeout("location.href='gracias/'", 3000);
          }
        },
      });
    } else {
      $(".formulario__mensaje")
        .addClass(".formulario__mensaje-activo")
        .html(
          `<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>`
        )
        .show(300)
        .delay(4000)
        .hide(300);
      $(`#Contenedor_Loader`).hide();
    }
  } else {
    $(".formulario__mensaje")
      .addClass(".formulario__mensaje-activo")
      .html(
        `<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor acepte los terminos y condiciones. </p>`
      )
      .show(300)
      .delay(4000)
      .hide(300);
    $(`#Contenedor_Loader`).hide();
  }
});

/* codigo para cargar combox de pais*/

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
      alert("error");
    },
  });
});

$(document).on("change", "#CboCateIntitucion", function () {
  let idCateInstitucion = $("#CboCateIntitucion").val();
  $.ajax({
    data: {
      idCateInstitucion,
    },
    url: urlProyect + "controller/DevolverDatos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      $("#CboInstitucion").html(resp);
    },
    error: function () {
      alert("error");
    },
  });
});

/* 
//codigo para cargar ocupacion actualmente sustituido por preguntas
$(document).on("change", "#cboOcupacion", function () {
  let idOcupacion = $("#cboOcupacion").val();

  if (idOcupacion == 5) {
    $("#txtOcupacion").addClass("d-block");
    $("#msjTxtOcupacion").addClass("d-block");
    $("#txtOcupacion").removeClass("d-none");
    $("#msjTxtOcupacion").removeClass("d-none");
  } else {
    $("#txtOcupacion").addClass("d-none");
    $("#msjTxtOcupacion").addClass("d-none");
    $("#txtOcupacion").removeClass("d-block");
    $("#msjTxtOcupacion").removeClass("d-block");
  }
});
 */

// TraerCursos();
function TraerCursos() {
  let CURSOS = "CURSOS";
  $.ajax({
    data: {
      CURSOS,
    },
    url: urlProyect + "controller/DevolverDatos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      let datos = JSON.parse(resp);
      let Cursos = "";
      datos.forEach((element) => {
        Cursos += `
        <div class="contenChecks">
          <input type="radio" name="rbOcupacion" class="cheks" name="" id="${element.id}" value="${element.id}">
          <label for="${element.id}">${element.nombre}</label>
          </div></br>`;
      });
      $(".cargarDatos").html(Cursos);
    },
    error: function () {
      alert("error");
    },
  });
}
var idRespuestaGlob = 0;
var idPreguntaGlob = 0;

TraerPreguntas();
function TraerPreguntas() {
  let PREGUNTAS = "PREGUNTAS";
  $.ajax({
    data: {
      PREGUNTAS,
    },
    url: urlProyect + "controller/DevolverDatos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
      let datos = JSON.parse(resp);
      numPreguntas = datos.length;
      let Cursos = "";
      let i = 0;
      datos.forEach((element) => {
        i += 1;
        Cursos += `              
        <div id="grupo__${element.id}" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">
          <label class="d-flex align-items-center" >
            <span class="mr-2" id="idContador" >${i}:</span>${element.pregunta} (*)
            <i id="Icono${element.id}" class="ml-3 icon-estado fas fa-times-circle"></i>
          </label> 
          <input type="hidden" name="txtIdPregunta${i}" id="txtIdPregunta${element.id}" value="${element.id}">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="ContenLLevoCursos" class="ContenRadios  datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6  align-items-center">`;
        element.respuestas.forEach((ele) => {
          Cursos += `<div class="contenChecks" capIdPregunta="${element.id}" capIDRespuesta="${ele.idResp}">
                   <input type="checkbox" name="Respuesta${i}" class="cheks" id="${ele.idResp}" value="${ele.idResp}" required> 
                   <label for="${ele.idResp}" id="eqtiquetaRadio${ele.idResp}" class="eqtiquetaRadio${i}">${ele.nombreResp}</label>
                  </div></br>`;
        });
        Cursos += `
             </div>
             <input type="text" class="OtraRespuesta txtOtraRespuesta${i}" name="txtOtraRespuesta${i}" id="txtOtraRespuesta${element.id}" placeholder="Escriba su respuesta" value="">
          </div>
        <label class="mensaje mt-2" id="msj${element.id}">Ingrese su respuesta correctamente</label>

    </div>`;
      });
      $(".cargarDatos").html(Cursos);
      $("#txtNumeroPreguntas").val(numPreguntas);
      $(".subContenBoton").attr("capIdPregunta1", idPreguntaUno);
      $("#txtIdPrimeraPregunta").val(idPreguntaUno);
      $("#txtIdFinalPregunta").val(idPreguntaFinal);
    },
    error: function () {
      alert("error");
    },
  });
}

// accedemos a las acciones que hayan en los radio buttons

$(document).on("change", ".cheks", function () {
  let element = $(this)[0].parentElement;
  let idrespuesta = $(element).attr("capIDRespuesta");
  idRespuestaGlob = idrespuesta;
  let idPregunta = $(element).attr("capIdPregunta");
  idPreguntaGlob = idPregunta;
  validarRadios(idPregunta, idrespuesta);
});

// //valido si el correo ya existe en la base de datos
/* 
var estadoCorreo=false;
$(`#txtEmail`).keyup(function () {
  if (expresiones.correo.test(txtEmail.value)) {
  
    let buscCorreo=$(`#txtEmail`).val();
    $.ajax({
      data: {buscCorreo},
      url: urlProyect + "controller/validacionesSql.php",
      type: "post",
      dataType: "json",
      async: true,
      beforeSend: function () {},
      success: function (resp) {
        if(resp.error!=undefined){
          estadoCorreo=true;
          fnValidarDatosExistentes(estadoCorreo,"txtEmail",resp.error);
        }else{
          estadoCorreo=false;
          fnValidarDatosExistentes(estadoCorreo,"txtEmail","");
        }   
      },
      error: function () {
        alert("error");
      },
    });
  }
})
 */

// valido si el telefono ya existe en la base de datos
/* var estadoTelefono=false;
$(`#txtNumCelular`).keyup(function () {
  if ($(`#txtNumCelular`).val().length>6){
    let buscTelefono=$(`#txtNumCelular`).val();
    $.ajax({
      data: {buscTelefono},
      url: urlProyect + "controller/validacionesSql.php",

      type: "post",
      dataType: "json",
      async: true,
      beforeSend: function () {},
      success: function (resp) {
        if(resp.error!=undefined){
          estadoTelefono=true;
          fnValidarDatosExistentes(estadoTelefono,"txtNumCelular",resp.error);
        }else{
          estadoTelefono=false;
          fnValidarDatosExistentes(estadoTelefono,"txtNumCelular",resp.error);
        }   
      },
      error: function () {
        alert("error");
      },
    });
  }
})
 */

// validaciones del formulario

$(document).on("click", "#txtNumCelular", function () {
  if ($("#CboPais").val() == 0) {
    alert("Porfavor seleccione pais");
    document.getElementById("txtNumCelular").disabled = true;
  } else {
    document.getElementById("txtNumCelular").disabled = false;
  }
});

const validarFormulario = (e) => {
  switch (e.target.name) {
    case "txtEmail":
      validarCampo(
        expresiones.correo,
        e.target,
        "txtEmail",
        "Ingrese fromato corecto Ej: micorreo12@gmail.com"
      );
      break;
    case "txtApePaterno":
      validarCampo(
        expresiones.nombre,
        e.target,
        "txtApePaterno",
        "Ingrese correctamente apellido paterno"
      );
      break;
    case "txtApeMaterno":
      validarCampo(
        expresiones.nombre,
        e.target,
        "txtApeMaterno",
        "Ingrese correctamente apellido materno"
      );
      break;
    case "txtnombres":
      validarCampo(
        expresiones.nombre,
        e.target,
        "txtnombres",
        "Ingrese correctamente sus nombres"
      );

      break;
    case "txtEdad":
      validarCampo(
        expresiones.edad,
        e.target,
        "txtEdad",
        "Ingrese correctamente su edad"
      );

      break;

    case "txtNumCelular":
      validarCampo(
        expresiones.telefono,
        e.target,
        "txtNumCelular",
        "Ingrese corectamente numero de telefono"
      );
      break;
  }
};

const validarCampo = (expresion, input, campo, msj) => {
  if (expresion.test(input.value)) {
    document.getElementById(`${campo}`).classList.add("inputExito");
    document.getElementById(`${campo}`).classList.remove("inputErrpor");
    document
      .getElementById(`grupo__${campo}`)
      .classList.remove("datosIncorrectos");
    document.getElementById(`grupo__${campo}`).classList.add("datoscorrecto");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.add("fa-check-circle");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.remove("fa-times-circle");

    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.remove("mensaje-error");
    campos[campo] = true;
  } else {
    document.getElementById(`${campo}`).classList.add("inputErrpor");
    document.getElementById(`${campo}`).classList.remove("inputExito");
    document
      .getElementById(`grupo__${campo}`)
      .classList.add("datosIncorrectos");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.add("fa-times-circle");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.remove("fa-check-circle");
    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.add("mensaje-error");
    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.remove("mensaje-exito");
    if ($("#CboPais").val() != 0) {
      document.querySelector(`#grupo__${campo} .mensaje`).innerHTML = msj;
    }
    campos[campo] = false;
  }
};

/* const validarPassword2 = () => {
  const inputPassword1 = document.getElementById('password');
  const inputPassword2 = document.getElementById('password2');

  if(inputPassword1.value !== inputPassword2.value){
    document.getElementById(`grupo__password2`).classList.add('formulario__grupo-incorrecto');
    document.getElementById(`grupo__password2`).classList.remove('formulario__grupo-correcto');
    document.querySelector(`#grupo__password2 i`).classList.add('fa-times-circle');
    document.querySelector(`#grupo__password2 i`).classList.remove('fa-check-circle');
    document.querySelector(`#grupo__password2 .formulario__input-error`).classList.add('formulario__input-error-activo');
    campos['password'] = false;
  } else {
    document.getElementById(`grupo__password2`).classList.remove('formulario__grupo-incorrecto');
    document.getElementById(`grupo__password2`).classList.add('formulario__grupo-correcto');
    document.querySelector(`#grupo__password2 i`).classList.remove('fa-times-circle');
    document.querySelector(`#grupo__password2 i`).classList.add('fa-check-circle');
    document.querySelector(`#grupo__password2 .formulario__input-error`).classList.remove('formulario__input-error-activo');
    campos['password'] = true;
  }
} */

inputs.forEach((input) => {
  input.addEventListener("keyup", validarFormulario);
  input.addEventListener("blur", validarFormulario);

  /* fnValidarDatosExistentes(estadoCorreo,"txtEmail",resp.error);
fnValidarDatosExistentes(estadoTelefono,"txtNumCelular",resp.error); */
});
combos.forEach((select) => {
  select.addEventListener("change", validarCombobox);
  select.addEventListener("blur", validarCombobox);
});

function validarCombobox() {
  validarCampoTexbox("CboPais", "Seleccione pais");
}

const validarCampoTexbox = (campo, msj) => {
  if ($("#CboPais").val() == 0) {
    document
      .getElementById(`grupo__${campo}`)
      .classList.remove("datoscorrecto");
    document
      .getElementById(`grupo__${campo}`)
      .classList.add("datosIncorrectos");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.remove("fa-check-circle");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.add("fa-times-circle");
    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.add("mensaje-error");
    /*  document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add('fa-check-circle');
    document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove('fa-times-circle');

    document.querySelector(`#grupo__${campo} .mensaje`).classList.remove('mensaje-error'); */
    campos[campo] = false;
  } else {
    document
      .getElementById(`grupo__${campo}`)
      .classList.remove("datosIncorrectos");
    document.getElementById(`grupo__${campo}`).classList.add("datoscorrecto");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.remove("fa-times-circle");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.add("fa-check-circle");
    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.remove("mensaje-error");

    campos[campo] = true;
  }
};

// validacion de radiobutons de las preguntas
function validarRadios(idPregunta, idrespuesta) {
  if ($(`input:radio[id=${idrespuesta}]:checked`).val() == undefined) {
    document
      .getElementById(`grupo__${idPregunta}`)
      .classList.remove("datoscorrecto");
    document
      .getElementById(`grupo__${idPregunta}`)
      .classList.add("datosIncorrectos");
    document
      .querySelector(`#grupo__${idPregunta} #${element.id}`)
      .classList.remove("fa-check-circle");
    document
      .querySelector(`#grupo__${idPregunta} #${element.id}`)
      .classList.add("fa-times-circle");
    document
      .querySelector(`#grupo__${idPregunta} idPregunta`)
      .classList.add("mensaje-error");

    campos[`respuesta${idPregunta}`] = false;
  } else {
    if ($(`#eqtiquetaRadio${idrespuesta}`).text() == "Otro") {
      document
        .getElementById(`txtOtraRespuesta${idPregunta}`)
        .classList.add("inputErrpor");
      document
        .getElementById(`txtOtraRespuesta${idPregunta}`)
        .classList.remove("inputExito");

      document
        .getElementById(`grupo__${idPregunta}`)
        .classList.remove("datoscorrecto");
      document
        .getElementById(`grupo__${idPregunta}`)
        .classList.add("datosIncorrectos");
      document
        .querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`)
        .classList.remove("fa-check-circle");
      document
        .querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`)
        .classList.add("fa-times-circle");
      document
        .getElementById(`txtOtraRespuesta${idPregunta}`)
        .classList.add("OtraRespuesta-activo");
      document
        .querySelector(`#grupo__${idPregunta} #msj${idPregunta}`)
        .classList.add("mensaje-error");

      campos[`respuesta${idPregunta}`] = false;

      $(`#txtOtraRespuesta${idPregunta}`).keyup(function () {
        if ($(`#txtOtraRespuesta${idPregunta}`).val().length > 4) {
          document
            .getElementById(`txtOtraRespuesta${idPregunta}`)
            .classList.remove("inputErrpor");
          document
            .getElementById(`txtOtraRespuesta${idPregunta}`)
            .classList.add("inputExito");

          document
            .getElementById(`grupo__${idPregunta}`)
            .classList.remove("datosIncorrectos");
          document
            .getElementById(`grupo__${idPregunta}`)
            .classList.add("datoscorrecto");
          document
            .querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`)
            .classList.remove("fa-times-circle");
          document
            .querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`)
            .classList.add("fa-check-circle");
          document
            .querySelector(`#grupo__${idPregunta} #msj${idPregunta}`)
            .classList.remove("mensaje-error");

          campos[`respuesta${idPregunta}`] = true;
        } else {
          document
            .getElementById(`txtOtraRespuesta${idPregunta}`)
            .classList.add("inputErrpor");
          document
            .getElementById(`txtOtraRespuesta${idPregunta}`)
            .classList.remove("inputExito");

          document
            .getElementById(`grupo__${idPregunta}`)
            .classList.remove("datoscorrecto");
          document
            .getElementById(`grupo__${idPregunta}`)
            .classList.add("datosIncorrectos");
          document
            .querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`)
            .classList.remove("fa-check-circle");
          document
            .querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`)
            .classList.add("fa-times-circle");
          document
            .querySelector(`#grupo__${idPregunta} #msj${idPregunta}`)
            .classList.add("mensaje-error");

          campos[`respuesta${idPregunta}`] = false;
        }
      });
    } else {
      document
        .getElementById(`grupo__${idPregunta}`)
        .classList.remove("datosIncorrectos");
      document
        .getElementById(`grupo__${idPregunta}`)
        .classList.add("datoscorrecto");
      document
        .querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`)
        .classList.remove("fa-times-circle");
      document
        .querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`)
        .classList.add("fa-check-circle");
      document
        .querySelector(`#grupo__${idPregunta} .mensaje`)
        .classList.remove("mensaje-error");
      document
        .getElementById(`txtOtraRespuesta${idPregunta}`)
        .classList.remove("OtraRespuesta-activo");

      campos[`respuesta${idPregunta}`] = true;
    }
  }
}

$(document).on("change", "#CboPais", function () {
  if ($("#CboPais").val() != 0) {
    document.getElementById("txtNumCelular").disabled = false;
    $("#msjTelefono").html("");
  } else {
    document.getElementById("txtNumCelular").disabled = true;
    $("#msjTelefono").html("Porfavor seleccione pais");
  }
});

formulario.addEventListener("submit", (e) => {
  e.preventDefault();
  alert("seeee");
  const terminos = document.getElementById("terminos");
  if (campos.txtApePaterno == true) {
    formulario.reset();

    document
      .getElementById("formulario__mensaje-exito")
      .classList.add("formulario__mensaje-exito-activo");
    setTimeout(() => {
      document
        .getElementById("formulario__mensaje-exito")
        .classList.remove("formulario__mensaje-exito-activo");
    }, 5000);

    document
      .querySelectorAll(".formulario__grupo-correcto")
      .forEach((icono) => {
        icono.classList.remove("formulario__grupo-correcto");
      });
  } else {
    document
      .getElementById("formulario__mensaje")
      .classList.add("formulario__mensaje-activo");
  }
});

function fnValidarDatosExistentes(estado, campo, msj) {
  if (estado == true) {
    document.getElementById(`${campo}`).classList.add("inputErrpor");
    document.getElementById(`${campo}`).classList.remove("inputExito");
    document
      .getElementById(`grupo__${campo}`)
      .classList.add("datosIncorrectos");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.add("fa-times-circle");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.remove("fa-check-circle");
    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.add("mensaje-error");
    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.remove("mensaje-exito");
    document.querySelector(`#grupo__${campo} .mensaje`).innerHTML = msj;

    campos[campo] = false;
  } else {
    document.getElementById(`${campo}`).classList.remove("inputErrpor");
    document.getElementById(`${campo}`).classList.add("inputExito");
    document
      .getElementById(`grupo__${campo}`)
      .classList.remove("datosIncorrectos");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.remove("fa-times-circle");
    document
      .querySelector(`#grupo__${campo} .formulario__grupo-input i`)
      .classList.add("fa-check-circle");
    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.remove("mensaje-error");
    document
      .querySelector(`#grupo__${campo} .mensaje`)
      .classList.add("mensaje-exito");
    document.querySelector(`#grupo__${campo} .mensaje`).innerHTML = msj;

    campos[campo] = true;
  }
}
$(document).ready(function () {
  $('#CboPais > option[value="PE"]').attr("selected", "selected");
  $("#CodigoPais").html("+51");
  $(".CodigoPais").val("+51");
});
