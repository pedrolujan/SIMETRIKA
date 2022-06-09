<?php
include("../../../model/conexion.php");
include("../../../model/url.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción a eventos Simétrika</title>
    <!-- <link rel="stylesheet" href="css/estilos.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <!--<link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_formProspecto.css">-->
    <!--<link rel="stylesheet" href="css/estilos.css">-->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_formProspecto.css?098">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosLoader.css?kjf">

    <link rel="icon" href="<?php echo $urlProyecto ?>IMAGENES/faviconn.png" type="image/png" />
</head>

<body>
    <div class="contenedorProspecto col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">

        <div class="contenedorFormProspecto col-xs-12 col-sm-12 col-md-9 col-lg-6  m-auto">
            <form action="#" class="contenedor_formulario" id="contenedor_formulario" method="post">
                <div class="row">
                    <div class="col-xs-12  col-sm-12 col-md-12 col-lg-12 contenGeneralImg">
                        <div class="form-group contenImg">
                            <img src="<?php echo $urlProyecto ?>IMAGENES/banner.JPG" />
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contenGeneralInfo">
                    <div class="form-group contenInfoEvento">
                        <h2 class="titulo_evento" style="font-size: 23px;">🎉¡Clase Magistral Imperdible!🎉</h2>
                        <span class="DescripcionEvento">🎉Este año seguimos trabajando para entregarte la mejor educación 🙌🏻</span>

                        <span class="DescripcionEvento">Simétrika trae para ti la clase magistral de Concreto Prefabricado totalmente GRATUITO🏗</span>

                        <span class="DescripcionEvento">✅Martes 27 de abril 8:00 p.m. (hora de Perú, México, Colombia) con el Ing. Mario Rodríguez y la clase magistral de "El Concreto Prefabricado en Zonas de Alta Sismicidad" </span>

                        <span class="DescripcionEvento">
                            ¿Te los piensas perder?😳😱</span>
                    </div>
                </div>
                <input type="hidden" name="txtIdCurso" id="txtIdCurso" value="30">
                <input type="hidden" name="txtIdCampania" id="txtIdCampania" value="8">
                <input type="hidden" name="txtIdLista" id="txtIdLista" value="94">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja" id="grupo__txtEmail">
                    <input type="hidden" name="txtNumeroPreguntas" id="txtNumeroPreguntas">
                    <span class="titulo_preguntas">Correo electrónico (*)</span>
                    <div class="formulario__grupo-input">
                        <input type="email" name="txtEmail" id="txtEmail" class="" placeholder="Ej: nicorreo12@gmail.com" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <br><label class="mensaje" id="msj__txtEmail"></label>
                </div>
                <div class="contenedorItems">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">
                        <div class="col-xs-12 d-block col-sm-12 col-md-12 col-lg-12 d-md-flex">
                            <div id="grupo__txtnombres" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <span class="titulo_preguntas">Nombres (*)</span>
                                <div class="formulario__grupo-input">
                                    <input type="text" name="txtnombres" id="txtnombres" class="" placeholder="Ingrese nombres" required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <br><label class="formulario__input-error  mensaje" id="mensajeNombres">Ingrese correctamente sus nombres</label>
                            </div>
                            <div id="grupo__txtApellidos" class="datosPersonales col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <span class="titulo_preguntas">Apellidos (*)</span>
                                <div class="formulario__grupo-input">
                                    <input type="text" name="txtApellidos" id="txtApellidos" class="" placeholder="Ingrese apellidos" required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <br><label class="formulario__input-error  mensaje" id="mensajeEmail">Ingrese correctamente sus apellidos</label>
                            </div>
                        </div>
                    </div>
                    <div class="contenedorSInUso d-none">
                        <input type="text" name="txtdireccion" id="">
                        <!-- <select name="CboCateIntitucion" id="CboCateIntitucion"></select>
                        <select name="CboInstitucion" id="CboInstitucion"></select> -->
                    </div>
                    <!-- <div class="d-none col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 d-flex">
                            <div id="grupo__txtnombresff" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <span class="titulo_preguntas">Nombres (*)</span>
                                <div class="formulario__grupo-input">
                                    <input type="text" name="txtnombresff" id="txtnombresff" class="" placeholder="Ingrese nombres" required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <br><label class="formulario__input-error  mensaje" id="mensajeNombres">Ingrese correctamente sus nombres</label>
                            </div>
                            <div id="grupo__txtEdad" class="d-none datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <span class="titulo_preguntas">Edad (*)</span>
                                <div class="formulario__grupo-input">
                                    <input type="number" name="txtEdad" id="txtEdad" class="" placeholder="Ingrese edad" required>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <br><label class="formulario__input-error  mensaje" id="mensajeEdad">Ingrese correctamente su edad, debe tener exactamnte dos caracteres</label>
                            </div>

                        </div>
                    </div> -->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">
                        <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex">
                            <div id="grupo__CboPais" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <span class="titulo_preguntas">Pais(*)</span>
                                <div class="formulario__grupo-input">
                                    <select name="CboPais" id="CboPais">
                                        <option value="0">Seleccione pais</option>
                                        <?php
                                        $user = new ApptivaDB();
                                        $categorias = $user->buscarTodo("pais", "Nombre_pais");
                                        foreach ($categorias as $cat) :   ?>
                                            <option value="<?php echo $cat['Codigo'] ?>">
                                                <?php echo mb_convert_case($cat['Nombre_pais'], MB_CASE_TITLE, "UTF-8") ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <br><label class="mensaje" id="msj__txtEmail">Porfavor selecione pais</label>
                            </div>
                            <div id="grupo__txtNumCelular" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <span class="titulo_preguntas">Numero de telefono (*)</span>
                                <div class="formulario__grupo-input p-0">
                                    <label class="CodigoPais" name="CodigoPais" id="CodigoPais">+00</label>
                                    <input type="number" maxlength="12" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="txtNumCelular" id="txtNumCelular" class="" placeholder="Numero de celular" style="width: 70%;" required>
                                    <input type="hidden" name="txtCodigoPais" class="CodigoPais" id="txtCodigoPais">
                                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                                </div>
                                <br><label class="mensaje" id="msjTelefono">Ingrese correctamente su numero telefonico</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contenedorEventosWebinars d-none col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">
                    <div class="col-12 text-right mb-3 d-flex justify-content-between">
                        <span class="titulo_preguntas">Seleccione la(as) clases a incribirse:</span>
                        <a class="btnAnadirCursos" id="btnAnadirCursos">Adicionar</a>
                    </div>
                    <div class="contenedorcatgarWebinars p-0 col-xs-12 d-block col-sm-12 col-md-12 col-lg-12">

                    </div>
                </div>
                <!-- <input type="checkbox" name="" id=""> -->
                <input type="hidden" name="txtNumWebinars" id="txtNumWebinars">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">
                    <label for="chkTerminosCondiciones" style="font-size: 12px">
                        <input type="checkbox" name="chkTerminosCondiciones" id="chkTerminosCondiciones" checked>
                        Acepto los términos y condiciones sobre el uso de mis datos para estos eventos
                    </label>
                </div>

                <?php
                include("../../loader.php");
                ?>
                <div class="row divContenDentro contenBoton">

                    <div class="formulario__mensaje col-xs-12 col-sm-12 col-md-12 col-lg-12" id="formulario__mensaje">

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-5 subContenBoton">
                        <input type="submit" id="btn_guardar" class="" value="Registrar >">
                    </div>

                </div>
            </form>
        </div>
    </div>
    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script src="<?php echo $urlProyecto ?>fonts/azome/fontAsome.js"></script>
    <!-- <script src="<?php echo $urlProyecto ?>JS/validacionFormulario.js"></script>-->
    <script src="<?php echo $urlProyecto ?>JS/validacionFormulario.js?iy8" type="module"></script>
    <!-- <script src="<?php echo $urlProyecto ?>JS/validacionForm.js?iy8" type="module"></script> -->
</body>

</html>