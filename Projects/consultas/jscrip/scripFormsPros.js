import {urlProyect} from "../../../JS/urlProyecto.js?321";
import {funcionMensaje} from "../../../JS/urlProyecto.js?321";

/* codigo para cargar combox de pais*/
var estadoCorreo = false;
$(document).on("change", "#CboPais", function () {
    let idPais = $("#CboPais").val();
    fnCargarDepartamento(idPais,"CboDepartamento");
    $.ajax({
        data: {
            idPais
        },
        url: urlProyect + "controller/DevolverDatos.php",
        type: "post",
        beforeSend: function () {},
        success: function (response) {
            let datos = JSON.parse(response);
            let codigo = "";
            datos.forEach((element) => {
                $("#CodigoPais").html(`${
                    element.codigo
                }`);
                $(".CodigoPais").val(`${
                    element.codigo
                }`);

            });
        },
        error: function () {
            alert("error al cargar codigo");
        }
    });
});

fnCargarDepartamento("PE","CboDepartamento");
$(document).on("change", "#CboDepartamento", function () {
    let idDepartamento = $("#CboDepartamento").val();
    fnCargarDepartamento(idDepartamento,"CboProvincia");
    
});
$(document).on("change", "#CboProvincia", function () {
    let idProvincia = $("#CboProvincia").val();
    fnCargarDepartamento(idProvincia,"CboDistrito");
    
});

function fnCargarDepartamento(codABuscar,combo) {

        let buscarUbigeo = "ok";
        $.ajax({
            data: {
                buscarUbigeo,
                codABuscar,
                combo
            },
            url: urlProyect + "controller/DevolverDatos.php",
            type: "post",
            beforeSend: function () {},
            success: function (response) {
                $(`#${combo}`).html(response);
            },
            error: function () {
                alert("error al cargar codigo");
            }
        });
}
// document.getElementById("Contenedor_Loader").classList.add("d-block");


const formulario = document.getElementById("contenedor_formulario");
const inputs = document.querySelectorAll("#contenedor_formulario input");
const combos = document.querySelectorAll("#contenedor_formulario select");
const textAreas = document.querySelectorAll("#contenedor_formulario textarea");
const radios = document.querySelectorAll("#contenedor_formulario .cheks");

const expresiones = {
    usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
    nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    descripciones: /^[a-zA-ZÀ-ÿ0-9\_\-\.\,\"\'\s]{1,500}$/, // Letras y espacios, pueden llevar acentos.
    password: /^.{4,12}$/, // 4 a 12 digitos.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    telefono: /^\d{7,14}$/, // 7 a 14 numeros.
    dni: /^\d{8,8}$/, // 7 a 14 numeros.
    edad: /^\d{2,2}$/
};

var numPreguntas = 0;
var preguntas = new Array();
var respuestas = new Array();
/* TraerCursos(); */

const campos = {
    txtEmail: false,
    txtApellidos: false,
    txtnombres: false,
    txtNumCelular: false,
    txtEdad: false,
    txtOcupacion: false,
    txtDescripcion: false,
    txtDireccion: false,
    CboPais: false,
    CboTipoProyecto: false,
    CboDepartamento: false,
    CboProvincia: false,
    CboDistrito: false,
    respuesta6: false,
    respuesta7: false
};
$("#btn_guardar").click(function (e) {
    e.preventDefault();
    document.getElementById(`Contenedor_Loader`).classList.remove("d-none");
    document.getElementById(`Contenedor_Loader`).classList.add("d-block");
    // const terminos = document.getElementById("terminos");
    // return;
    // if (estadoCorreo == true) {
    //     $(`#txtEmail`).val("");
    //     $(`#txtEmail`).val("");
    //     $(`#txtApellidos`).val("");
    //     $(`#txtnombres`).val("");
    //     $(`#txtNumCelular`).val("");
    //     setTimeout("location.href='gracias/'", 10);
    // } else {

    if ($(`input:checkbox[id=chkTerminosCondiciones]:checked`).val()) {
        if (campos.txtEmail == true && campos.txtApellidos == true && campos.txtnombres == true 
            && campos.txtNumCelular == true && campos.CboPais == true && campos.txtOcupacion == true 
            && campos.txtDescripcion == true && campos.txtDireccion == true && campos.CboDepartamento==true
           && campos.CboProvincia==true && campos.CboDistrito==true) {
            let datos = $("#contenedor_formulario").serialize();
            $.ajax({
                data: datos,
                url: urlProyect + "controller/registro_prospectoProyectos.php?dfd",
                type: "post",
                dataType: "json",
                success: function (resp) {
                    console.log(resp);
                    // console.log(resp);
                    funcionMensaje(resp, "formulario__mensaje");
                    document.getElementById(`Contenedor_Loader`).classList.remove("d-block");
                    document.getElementById(`Contenedor_Loader`).classList.add("d-none");
                    if (resp.exito != undefined) {
                        $(`#txtEmail`).val("");
                        $(`#txtApellidos`).val("");
                        $(`#txtnombres`).val("");
                        $(`#txtNumCelular`).val("");
                        $(`#txtOcupacion`).val("");
                        $(`#txtDescripcion`).val("");
                        $(`#txtDireccion`).val("");
                        $(`#CboTipoProyecto`).val(0);
                        setTimeout("location.href='gracias/'", 3000);
                    }
                }
            });
        } else {
            $(".formulario__mensaje").addClass(".formulario__mensaje-activo").html(`<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>`).show(300).delay(4000).hide(300);
            document.getElementById(`Contenedor_Loader`).classList.remove("d-block");
            document.getElementById(`Contenedor_Loader`).classList.add("d-none");
        }
    } else {
        $(".formulario__mensaje").addClass(".formulario__mensaje-activo").html(`<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor acepte los terminos y condiciones. </p>`).show(300).delay(4000).hide(300);
        document.getElementById(`Contenedor_Loader`).classList.remove("d-block");
        document.getElementById(`Contenedor_Loader`).classList.add("d-none");
    }
    // }
});


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


// $(`#txtEmail`).keyup(function () {
//     if (expresiones.correo.test(txtEmail.value)) {
//         let buscCorreo = $(`#txtEmail`).val();
//         let idCurso = $("#txtIdCurso").val();
//         let idCampania = $("#txtIdCampania").val();
//         // alert(buscCorreo,idCurso,idCampania);
//         $.ajax({
//             data: {
//                 buscCorreo,
//                 idCurso,
//                 idCampania
//             },
//             url: urlProyect + "controller/validacionesSql.php",
//             type: "post",
//             dataType: "json",
//             // async: true,
//             beforeSend: function () {},
//             success: function (resp) {
//                 console.log(resp);
//                 if (resp.error != undefined) {
//                     estadoCorreo = true;
//                     fnValidarDatosExistentes(false, "txtEmail", resp.error);
//                     // $(".divCajaDinamic").classList.add("d-none");
//                     fnMostrarContenedores(estadoCorreo);
//                 } else {
//                     estadoCorreo = false;
//                     fnValidarDatosExistentes(estadoCorreo, "txtEmail", "");
//                     fnMostrarContenedores(estadoCorreo);
//                 }
//             },
//             error: function () {
//                 alert("error");
//             }
//         });
//     }
// })

function fnMostrarContenedores(estadoCorreo) {
    if (estadoCorreo == true) {
        document.getElementById(`divCajaDinamic`).classList.remove("d-block");
        document.getElementById(`divCajaDinamic1`).classList.remove("d-block");
        // document.getElementById(`divCajaDinamic2`).classList.remove("d-block");

        document.getElementById(`divCajaDinamic`).classList.add("d-none");
        document.getElementById(`divCajaDinamic1`).classList.add("d-none");
        // document.getElementById(`divCajaDinamic2`).classList.add("d-none");
    } else {
        document.getElementById(`divCajaDinamic`).classList.remove("d-none");
        document.getElementById(`divCajaDinamic1`).classList.remove("d-none");
        // document.getElementById(`divCajaDinamic2`).classList.remove("d-none");

        document.getElementById(`divCajaDinamic`).classList.add("d-block");
        document.getElementById(`divCajaDinamic1`).classList.add("d-block");
        // document.getElementById(`divCajaDinamic2`).classList.add("d-block");

    }
}
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
        case "txtEmail": validarCampo(expresiones.correo, e.target, "txtEmail", "Ingrese fromato corecto Ej: micorreo12@gmail.com");
            break;
        case "txtApellidos": validarCampo(expresiones.nombre, e.target, "txtApellidos", "Ingrese correctamente apellidos");
            break;

        case "txtnombres": validarCampo(expresiones.nombre, e.target, "txtnombres", "Ingrese correctamente sus nombres");

            break;
        case "txtEdad": validarCampo(expresiones.edad, e.target, "txtEdad", "Ingrese correctamente su edad");

            break;

        case "txtNumCelular": validarCampo(expresiones.telefono, e.target, "txtNumCelular", "Ingrese corectamente numero de telefono");
            break;
        case "txtOcupacion": validarCampo(expresiones.descripciones, e.target, "txtOcupacion", "Describa corectamente su Ocupación");
            break;
        case "txtDescripcion": validarCampo(expresiones.descripciones, e.target, "txtDescripcion", "Ingrese corectamente la descripcion del proyecto");
            break;
        case "txtDireccion": validarCampo(expresiones.descripciones, e.target, "txtDireccion", "Ingrese corectamente la direccion del proyecto");
            break;
    }
};

const validarCampo = (expresion, input, campo, msj) => {
    let mincarcteres = 0;
    if (expresion.test(input.value)) {
        switch (input.name) {
            case "txtnombres": mincarcteres = 3
                break;
            case "txtApellidos": mincarcteres = 3
                break;
            case "txtOcupacion": mincarcteres = 5
                break;
            case "txtDescripcion": mincarcteres = 10
                break;
            case "txtDireccion": mincarcteres = 10
                break;

        }

        if ($(`#${campo}`).val().length >= mincarcteres) {

            document.getElementById(`${campo}`).classList.add("inputExito");
            document.getElementById(`${campo}`).classList.remove("inputErrpor");
            document.getElementById(`grupo__${campo}`).classList.remove("datosIncorrectos");
            document.getElementById(`grupo__${campo}`).classList.add("datoscorrecto");
            document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add("fa-check-circle");
            document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove("fa-times-circle");

            document.querySelector(`#grupo__${campo} .mensaje`).classList.remove("mensaje-error");
            campos[campo] = true;
        } else {
            document.getElementById(`${campo}`).classList.add("inputErrpor");
            document.getElementById(`${campo}`).classList.remove("inputExito");
            document.getElementById(`grupo__${campo}`).classList.add("datosIncorrectos");
            document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add("fa-times-circle");
            document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove("fa-check-circle");
            document.querySelector(`#grupo__${campo} .mensaje`).classList.add("mensaje-error");
            document.querySelector(`#grupo__${campo} .mensaje`).classList.remove("mensaje-exito");
            document.querySelector(`#grupo__${campo} .mensaje`).innerHTML = msj;
            campos[campo] = false;
        }
    } else {
        document.getElementById(`${campo}`).classList.add("inputErrpor");
        document.getElementById(`${campo}`).classList.remove("inputExito");
        document.getElementById(`grupo__${campo}`).classList.add("datosIncorrectos");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add("fa-times-circle");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove("fa-check-circle");
        document.querySelector(`#grupo__${campo} .mensaje`).classList.add("mensaje-error");
        document.querySelector(`#grupo__${campo} .mensaje`).classList.remove("mensaje-exito");
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
textAreas.forEach((are) => {
    are.addEventListener("keyup", validarFormulario);
    are.addEventListener("blur", validarFormulario);

    /* fnValidarDatosExistentes(estadoCorreo,"txtEmail",resp.error);
fnValidarDatosExistentes(estadoTelefono,"txtNumCelular",resp.error); */
});
combos.forEach((select) => {
    select.addEventListener("change", validarCombobox);
    select.addEventListener("blur", validarCombobox);
});

function validarCombobox() {
    validarCampoTexbox("CboPais", "Seleccione pais");
    validarCampoTexbox("CboTipoProyecto", "Seleccione tipo de proyecto");
    // validarCampoTexbox("CboProyecto", "Seleccione proyecto");
    validarCampoTexbox("CboDepartamento", "Seleccione departamento");
    validarCampoTexbox("CboProvincia", "Seleccione provincia");
    validarCampoTexbox("CboDistrito", "Seleccione distrito");
}
const validarCampoTexbox = (campo, msj) => {
    if ($(`#${campo}`).val() == 0 || $(`#${campo}`).val() == null) {
        document.getElementById(`grupo__${campo}`).classList.remove("datoscorrecto");
        document.getElementById(`grupo__${campo}`).classList.add("datosIncorrectos");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove("fa-check-circle");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add("fa-times-circle");
        document.querySelector(`#grupo__${campo} .mensaje`).classList.add("mensaje-error");
        /*  document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add('fa-check-circle');
    document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove('fa-times-circle');

    document.querySelector(`#grupo__${campo} .mensaje`).classList.remove('mensaje-error'); */
        campos[campo] = false;
    } else {
        document.getElementById(`grupo__${campo}`).classList.remove("datosIncorrectos");
        document.getElementById(`grupo__${campo}`).classList.add("datoscorrecto");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove("fa-times-circle");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add("fa-check-circle");
        document.querySelector(`#grupo__${campo} .mensaje`).classList.remove("mensaje-error");

        campos[campo] = true;
    }
};

// validacion de radiobutons de las preguntas
function validarRadios(idPregunta, idrespuesta) {
    if ($(`input:radio[id=${idrespuesta}]:checked`).val() == undefined) {
        document.getElementById(`grupo__${idPregunta}`).classList.remove("datoscorrecto");
        document.getElementById(`grupo__${idPregunta}`).classList.add("datosIncorrectos");
        document.querySelector(`#grupo__${idPregunta} #${
            element.id
        }`).classList.remove("fa-check-circle");
        document.querySelector(`#grupo__${idPregunta} #${
            element.id
        }`).classList.add("fa-times-circle");
        document.querySelector(`#grupo__${idPregunta} idPregunta`).classList.add("mensaje-error");

        campos[`respuesta${idPregunta}`] = false;
    } else {
        if ($(`#eqtiquetaRadio${idrespuesta}`).text() == "Otro") {
            document.getElementById(`txtOtraRespuesta${idPregunta}`).classList.add("inputErrpor");
            document.getElementById(`txtOtraRespuesta${idPregunta}`).classList.remove("inputExito");

            document.getElementById(`grupo__${idPregunta}`).classList.remove("datoscorrecto");
            document.getElementById(`grupo__${idPregunta}`).classList.add("datosIncorrectos");
            document.querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`).classList.remove("fa-check-circle");
            document.querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`).classList.add("fa-times-circle");
            document.getElementById(`txtOtraRespuesta${idPregunta}`).classList.add("OtraRespuesta-activo");
            document.querySelector(`#grupo__${idPregunta} #msj${idPregunta}`).classList.add("mensaje-error");

            campos[`respuesta${idPregunta}`] = false;

            $(`#txtOtraRespuesta${idPregunta}`).keyup(function () {
                if ($(`#txtOtraRespuesta${idPregunta}`).val().length > 4) {
                    document.getElementById(`txtOtraRespuesta${idPregunta}`).classList.remove("inputErrpor");
                    document.getElementById(`txtOtraRespuesta${idPregunta}`).classList.add("inputExito");

                    document.getElementById(`grupo__${idPregunta}`).classList.remove("datosIncorrectos");
                    document.getElementById(`grupo__${idPregunta}`).classList.add("datoscorrecto");
                    document.querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`).classList.remove("fa-times-circle");
                    document.querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`).classList.add("fa-check-circle");
                    document.querySelector(`#grupo__${idPregunta} #msj${idPregunta}`).classList.remove("mensaje-error");

                    campos[`respuesta${idPregunta}`] = true;
                } else {
                    document.getElementById(`txtOtraRespuesta${idPregunta}`).classList.add("inputErrpor");
                    document.getElementById(`txtOtraRespuesta${idPregunta}`).classList.remove("inputExito");

                    document.getElementById(`grupo__${idPregunta}`).classList.remove("datoscorrecto");
                    document.getElementById(`grupo__${idPregunta}`).classList.add("datosIncorrectos");
                    document.querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`).classList.remove("fa-check-circle");
                    document.querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`).classList.add("fa-times-circle");
                    document.querySelector(`#grupo__${idPregunta} #msj${idPregunta}`).classList.add("mensaje-error");

                    campos[`respuesta${idPregunta}`] = false;
                }
            });
        } else {
            document.getElementById(`grupo__${idPregunta}`).classList.remove("datosIncorrectos");
            document.getElementById(`grupo__${idPregunta}`).classList.add("datoscorrecto");
            document.querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`).classList.remove("fa-times-circle");
            document.querySelector(`#grupo__${idPregunta} #Icono${idPregunta}`).classList.add("fa-check-circle");
            document.querySelector(`#grupo__${idPregunta} .mensaje`).classList.remove("mensaje-error");
            document.getElementById(`txtOtraRespuesta${idPregunta}`).classList.remove("OtraRespuesta-activo");

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

        document.getElementById("formulario__mensaje-exito").classList.add("formulario__mensaje-exito-activo");
        setTimeout(() => {
            document.getElementById("formulario__mensaje-exito").classList.remove("formulario__mensaje-exito-activo");
        }, 5000);

        document.querySelectorAll(".formulario__grupo-correcto").forEach((icono) => {
            icono.classList.remove("formulario__grupo-correcto");
        });
    } else {
        document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    }
});

function fnValidarDatosExistentes(estado, campo, msj) {
    if (estado == true) {
        document.getElementById(`${campo}`).classList.add("inputErrpor");
        document.getElementById(`${campo}`).classList.remove("inputExito");
        document.getElementById(`grupo__${campo}`).classList.add("datosIncorrectos");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add("fa-times-circle");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove("fa-check-circle");
        document.querySelector(`#grupo__${campo} .mensaje`).classList.add("mensaje-error");
        document.querySelector(`#grupo__${campo} .mensaje`).classList.remove("mensaje-exito");
        document.querySelector(`#grupo__${campo} .mensaje`).innerHTML = msj;

        campos[campo] = false;
    } else {
        document.getElementById(`${campo}`).classList.remove("inputErrpor");
        document.getElementById(`${campo}`).classList.add("inputExito");
        document.getElementById(`grupo__${campo}`).classList.remove("datosIncorrectos");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.remove("fa-times-circle");
        document.querySelector(`#grupo__${campo} .formulario__grupo-input i`).classList.add("fa-check-circle");
        document.querySelector(`#grupo__${campo} .mensaje`).classList.remove("mensaje-error");
        document.querySelector(`#grupo__${campo} .mensaje`).classList.add("mensaje-exitoCorreo");
        document.querySelector(`#grupo__${campo} .mensaje`).innerHTML = msj;

        campos[campo] = true;
    }
}
$(document).ready(function () {
    $('#CboPais > option[value="PE"]').attr("selected", "selected");
    $("#CodigoPais").html("+51");
    $(".CodigoPais").val("+51");
    campos.CboPais = true;
    validarCombobox();
});
