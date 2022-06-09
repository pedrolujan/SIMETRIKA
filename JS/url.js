export const urlP="https://simetrika.ga/";

export function funcionM(dato1,id) {
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
  
