
/* codigo para cargar combox de pais*/


import {urlProyect} from "../../../JS/urlProyecto.js?321";
import {funcionMensaje} from "../../../JS/urlProyecto.js?321";

var numPreguntas = 0;
var preguntas = new Array();
var respuestas = new Array();
/* TraerCursos(); */
window.onload=function(){
    let wj_lead_email= $("#wj_lead_email").val();
    let wj_lead_first_name= $("#wj_lead_first_name").val();
    let wj_lead_last_name= $("#wj_lead_last_name").val();
    let wj_lead_phone_number= $("#wj_lead_phone_number").val();
    let wj_lead_phone_country_code= $("#wj_lead_phone_country_code").val();
    let txtIdCurso= $("#txtIdCurso").val();
    let wj_lead_id_List= $("#wj_lead_id_List").val();
    let txtIdCampania= $("#txtIdCampania").val();
     
console.log(wj_lead_email+" "+wj_lead_first_name+" "+wj_lead_last_name+" "+wj_lead_phone_number+" "+wj_lead_phone_country_code+" "+txtIdCurso+" "+wj_lead_id_List+" "+txtIdCampania);
            $.ajax({
                data: {wj_lead_email,wj_lead_first_name,wj_lead_last_name,wj_lead_phone_number,wj_lead_phone_country_code,txtIdCurso,wj_lead_id_List,txtIdCampania},
                url: urlProyect + "controller/registro_prospectoTemporal.php",
                type: "post",
                dataType: "json",
                async: true,
                success: function (resp) {
                  
                    if (resp.exito != undefined) {
                        // alert(resp.exito);
                        //setTimeout("location.href='gracias/'", 3000);
                    }else{
                        // alert(resp.error);
                    }
                }
            });
    
}
   

            