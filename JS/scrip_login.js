import { urlProyect } from "./urlProyecto.js?357";
import { funcionMensaje } from "./urlProyecto.js?357";

const inputs = document.querySelectorAll(".input");

function addcl() {
    let parent = this.parentNode.parentNode;
    parent.classList.add("focus");
}

function remcl() {
    let parent = this.parentNode.parentNode;
    if (this.value == "") {
        parent.classList.remove("focus");
    }
}
inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("blur", remcl);
});

/*codigo para logearse en el sistema */

$(document).on("click", "#btnAcceder", function(evt) {
    // alert("holalla");
    evt.preventDefault();
    let datos = $("#formularioLogeo").serialize();
    $.ajax({
        data: datos,
        url: urlProyect + "controller/validar_login.php",
        type: "post",
        dataType: "json",
        async: true,
    }).done(function correcto(resp) {
        funcionMensaje(resp, "msj");
        setTimeout("location.href='" + urlProyect + "'", 2000);

    });
});