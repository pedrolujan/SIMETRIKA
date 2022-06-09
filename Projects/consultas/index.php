<?php
include("../../model/conexion.php");
include("../../model/url.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta proyectos Simétrika</title>
    <!-- <link rel="stylesheet" href="css/estilos.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <!--<link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_formProspecto.css">-->
    <link rel="stylesheet" href="css/estilos.css?OFU">
    <link rel="stylesheet" href="css/estilosFormulario.css?OOUD">
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
                            <img src="<?php echo $urlProyecto ?>IMAGENES/header_form.png" />
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contenGeneralInfo">
                    <div class="form-group contenInfoEvento">
                        <h2 class="titulo_evento" style="font-size: 23px;">¡Proyectos Simetrika!🎉</h2>

                        <span class="DescripcionEvento d-none">
                            ¿Te los piensas perder?😳😱</span>
                    </div>
                </div>
                <!-- <input type="hidden" name="txtIdCurso" id="txtIdCurso" value="45">
                <input type="hidden" name="txtIdCampania" id="txtIdCampania" value="7">
                <input type="hidden" name="txtIdLista" id="txtIdLista" value="139"> -->

                <div id="divCajaDinamic" class="pt-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja divCajaDinamic">

                    <div class="dvheader mt-0  border-bottom-info">
                        <p class=" p-1">Datos Personales</p>
                    </div>
                    <div class="col-xs-12 p-0 d-block col-sm-12 col-md-12 col-lg-12 d-md-flex">
                        <div id="grupo__txtnombres" class="datosPersonales col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <span class="titulo_preguntas m-0">Nombres *</span>
                            <div class="formulario__grupo-input">
                                <input type="text" name="txtnombres" id="txtnombres" class="" placeholder="Ingrese Nombres" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="formulario__input-error mt-1   mensaje" id="mensajeEmail">Ingrese correctamente sus Nombres</label>
                        </div>
                        <div id="grupo__txtApellidos" class="datosPersonales mt-3 mt-md-0 col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <span class="titulo_preguntas m-0">Apellidos *</span>
                            <div class="formulario__grupo-input">
                                <input type="text" name="txtApellidos" id="txtApellidos" class="" placeholder="Ingrese Apellidos" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="formulario__input-error mt-1  mensaje" id="mensajeEmail">Ingrese correctamente sus apellidos</label>
                        </div>

                    </div>

                    <div class="pr-0 col-xs-12 mt-3 col-sm-12 col-md-12 col-lg-12">
                        <div id="grupo__txtOcupacion" class="datosPersonales p-0 col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <span class="titulo_preguntas m-0">Ocupación *</span>
                            <div class="formulario__grupo-input inpLargo">
                                <input type="text" name="txtOcupacion" id="txtOcupacion" class="col-12" placeholder="Describa su Ocupación">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="formulario__input-error mt-1  mensaje" id="mensajeEmail">Ingrese correctamente su Dni</label>
                        </div>
                    </div>
                </div>
                <div id="divCajaDinamic" class="pt-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja divCajaDinamic">
                    <div class="dvheader mt-0  border-bottom-info">
                        <p class=" p-1">Datos de Contacto</p>
                    </div>
                    <div class="pr-0 col-xs-12 mt-3 col-sm-12 col-md-12 col-lg-12">
                        <div id="grupo__txtEmail" class="datosPersonales  p-0 col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <span class="titulo_preguntas m-0">Correo Electrónico *</span>
                            <div class="formulario__grupo-input inpLargo">
                                <input type="text" name="txtEmail" id="txtEmail" class="col-12" placeholder="Ejm: micorreo12@gmail.com">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="formulario__input-error mt-1  mensaje" id="mensajeEmail">Ingrese correctamente su Dni</label>
                        </div>
                    </div>

                    <div class="d-block p-0 col-xs-12 mt-4 col-sm-12 col-md-12 col-lg-12 d-md-flex">
                        <div id="grupo__CboPais" class="datosPersonales  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <span class="titulo_preguntas m-0">Pais *</span>
                            <div class="formulario__grupo-input">
                                <select name="CboPais" id="CboPais">
                                    <option value="0">Seleccione Pais</option>
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
                            <label class="mensaje mt-1" id="msj__txtEmail">Por favor selecione pais</label>
                        </div>
                        <div id="grupo__txtNumCelular" class="datosPersonales mt-3 mt-md-0 col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <span class="titulo_preguntas m-0">Numero de telefono *</span>
                            <div class="formulario__grupo-input p-0">
                                <label class="CodigoPais" name="CodigoPais" id="CodigoPais">+00</label>
                                <input type="number" maxlength="12" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="txtNumCelular" id="txtNumCelular" class="" placeholder="Numero de celular" style="width: 80%;" required>
                                <input type="hidden" name="txtCodigoPais" class="CodigoPais">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="mensaje mt-1" id="msjTelefono">Ingrese correctamente su numero telefonico</label>
                        </div>
                    </div>
                </div>
                <div id="divCajaDinamic1" class="pt-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja divCajaDinamic">
                    <div class="dvheader mt-0  border-bottom-info">
                        <p class=" p-1">Datos del Proyecto</p>
                    </div>
                    <div class="d-block col-xs-12 mt-md-2 col-sm-12 col-md-12 col-lg-12 d-md-flex">
                        <div id="grupo__CboTipoProyecto" class="p-0 datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <span class="titulo_preguntas m-0">Tipo de Proyecto *</span>
                            <div class="formulario__grupo-input">
                                <select name="CboTipoProyecto" id="CboTipoProyecto" class="">
                                    <option value="0">Elija Opcion</option>
                                    <?php
                                    $user = new ApptivaDB();
                                    $categorias = $user->buscarTodo("tipo_proyecto", "cNombre");
                                    foreach ($categorias as $cat) :   ?>
                                        <option value="<?php echo $cat['cCodTipoProyecto'] ?>">
                                            <?php echo mb_convert_case($cat['cNombre'], MB_CASE_TITLE, "UTF-8") ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="mensaje mt-1" id="msj__txtEmail">Por favor selecione una opción</label>
                        </div>

                    </div>
                    <div class="d-block p-0 col-xs-12 mt-md-2 col-sm-12 col-md-12 col-lg-12 d-md-flex">

                        <div id="grupo__txtDescripcion" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <span class="titulo_preguntas">Describa el proyecto (*)</span>
                            <div class="formulario__grupo-input d-flex p-0 align-items-center">
                                <textarea name="txtDescripcion" id="txtDescripcion" cols="10" rows="4" class="form-control col-11"></textarea>
                                <i class="col-1 formulario__validacion-estado  fas fa-times-circle"></i>
                            </div>
                            <label class="mensaje mt-1" id="msjTelefono">Ingrese correctamente su numero telefonico</label>
                        </div>
                    </div>

                </div>
                <div id="divCajaDinamic1" class="pt-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja divCajaDinamic">
                    <div class="dvheader mt-0  border-bottom-info">
                        <p class=" p-1">Dirreción del Proyecto</p>
                    </div>
                    <div class="d-block p-0 col-xs-12  col-sm-12 col-md-12 col-lg-12 d-md-flex">
                        <div id="grupo__CboDepartamento" class="datosPersonales  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <span class="titulo_preguntas m-0">Departamento *</span>
                            <div class="formulario__grupo-input">
                                <select name="CboDepartamento" id="CboDepartamento">

                                </select>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="mensaje mt-1" id="msj__txtEmail">Por favor selecione departamento</label>
                        </div>
                        <div id="grupo__CboProvincia" class="datosPersonales mt-1 col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <span class="titulo_preguntas m-0">Provincia *</span>
                            <div class="formulario__grupo-input">
                                <select name="CboProvincia" id="CboProvincia">

                                </select>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="mensaje mt-1" id="msj__txtEmail">Por favor selecione provincia</label>
                        </div>
                    </div>
                    <div class="d-block p-0 col-xs-12  col-sm-12 col-md-12 col-lg-12 d-md-flex">
                        
                        <div id="grupo__CboDistrito" class="datosPersonales  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <span class="titulo_preguntas m-0">Distrito *</span>
                            <div class="formulario__grupo-input">
                                <select name="CboDistrito" id="CboDistrito">

                                </select>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="mensaje mt-1" id="msj__txtEmail">Por favor selecione distrito</label>
                        </div>
                    </div>
                    <div class="d-block p-0 mt-1 col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="grupo__txtDireccion" class="datosPersonales mb-0 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <span class="titulo_preguntas">Describa la dirección del proyecto incluya referencias (*)</span>
                            <div class="formulario__grupo-input p-0 mb-0 d-flex p-0 align-items-center">
                                <textarea name="txtDireccion" id="txtDireccion" cols="10" rows="4" class="form-control col-11"></textarea>
                                <i class="col-1 formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <label class="mensaje mt-1" id="msjTelefono">Ingrese correctamente su numero telefonico</label>
                        </div>
                    </div>
                </div>

                <div class="cargarDatos">

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">
                    <label for="chkTerminosCondiciones" style="font-size: 11px">
                        <input type="checkbox" name="chkTerminosCondiciones" id="chkTerminosCondiciones" checked>
                        Acepto los términos y condiciones sobre el uso de mis datos para estos proyectos
                    </label>
                </div>

                <div class="Contenedor_Loader" id="Contenedor_Loader">
                    <div class="loader" id="loader"></div>
                </div>


                <div class="formulario__mensaje mt-2 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12" id="formulario__mensaje">

                </div>
                <div class="row divContenDentro contenBoton text-center divCaja p-0 mb-5">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 subContenBoton">
                        <input type="submit" id="btn_guardar" class="col-10 col-md-6" value="Registrar >">
                    </div>

                </div>
            </form>
        </div>
    </div>
    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js?HFD"></script>
    <script src="<?php echo $urlProyecto ?>fonts/azome/fontAsome.js"></script>
    <!-- <script src="<?php echo $urlProyecto ?>JS/validacionFormulario.js"></script> -->
    <script src="jscrip/scripFormsPros.js?jdhsy" type="module"></script>
</body>

</html>