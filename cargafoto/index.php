<!-- 
    creado por Khriz Enríquez (tw) @khrizenriquez (fb) /khrizenriquez
-->
<?php
require_once './scriptsPHP/elementosRepetidos.php';//script que me sirve para los elementos repetidos que pueden aparecer en mi formulario
require_once './scriptsPHP/instruccionesBD.php';
?>
<!DOCTYPE html>
<html lang="es-mx">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /><!-- meta para no agrandar la pantalla desde un movil -->
        
        <title>Registrate con nosotros</title>
        <!-- soporte para los scripts -->
        <!--[if lt IE 9]>
            <script src=”http://HTML5shim.googlecode.com/svn/trunk/HTML5.js”>
            </script>
        <![endif]-->
        <!-- soporte para los scripts -->
        <!-- soporte para ie 9 en css -->
        <!--[if gte IE 9]>
          <style type="text/css">
            .gradient {
               filter: none;
            }
          </style>
        <![endif]-->
        <!-- soporte para los scripts -->
        <link rel="stylesheet" href="css/normalize.css" />
        <link rel="stylesheet" href="css/jqueryUI/smoothness/jquery-ui-1.10.3.custom.css" />
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/bootstrap-responsive.css" />
        <link rel="stylesheet" href="css/propios/estiloIndex.css" />
        
    </head>
    <body>
        
        <section id="secContenedor">
            <!-- articulo que contiene el formulario de ingreso de datos -->
            <article id="artIngresoDatosUsuario">
                <form action="" method="POST" id="formIngresoDatos" class="form-inline">
                    <fieldset id="fieldsetDatosUsuario">
                        <h3><i class="icon-book icon-white"></i>Registrate</h3>
                        <hr />
                        <span></span>
                        <input maxlength="40" type="text" title="Ingresa tu nombre" placeholder="Nombre" class="input-block-level" id="txtNombreRegistro" name="txtNombreRegistro" /><span id="mensaje"><i class="icon-ok-sign"></i></span>
                        <span></span>
                        <input maxlength="90" type="text" title="Ingresa tus apellidos" placeholder="Apellidos" class="input-block-level" id="txtApellidosRegistro" name="txtApellidosRegistro" /><span id="mensaje"><i class="icon-ok-sign"></i></span>
                        <span></span>
                        <input maxlength="40" type="text" title="Ingresa el nombre de usuario que quieres tener" placeholder="Usuario" class="input-block-level" id="txtUsuarioRegistro" name="txtUsuarioRegistro" /><span id="mensaje"><i class="icon-ok-sign"></i></span>
                        <span></span>
                        <input maxlength="20" type="password" title="Ingresa tu contraseña" placeholder="Contraseña" class="input-block-level" id="txtClaveRegistro" name="txtClaveRegistro" /><span id="mensaje"><i class="icon-ok-sign"></i></span>
                        
                    </fieldset>
                    
                    <fieldset id="fieldsetImagenUsuario">
                        <div id="divContenedorImagen">
                            <figure id="figureContenedorImagenUsuario">
                                <img class="img-circle" src="img/imgIconos/userMale128.png" alt="Sube tu foto" title="Puedes subir tu foto" id="imgFotoIndex" />
                            </figure>
                            <input type="hidden" value="" name="txtEscondido" id="txtEscondido" />
                        </div>
                        <button class="btn btn-primary" title="Quiero subir mi foto" id="btnGuardarDatos" type="submit" role='button'><i class="icon-camera icon-white"></i>Cargar foto</button>
                    
                    </fieldset>
                    
                    <br />
                    <button class="btn btn-success" title="Quiero registrarme en tu página" id="btnRegistrarme" type="submit" role='button'><i class="icon-ok icon-white"></i>Registrarme</button>
                </form>
                <div id="divImgCargando">
                    <img src="img/loaders/ajax-loaderPackmanNegro.gif" alt="Cargando" />
                    <label for="subiendo" class="">Cargando...</label>
                </div>
            </article>
        </section>
        
        <section id="secTablaDatos">
            <h3>Usuarios creados</h3>
            <div id="divContenedorTablaUsuarios">
                <table class="table table-condensed table-hover" id="tbUsuariosIngresadosIndex">
                    <thead>
                        <tr>
                            <td>Foto</td>
                            <td>Nombre</td>
                            <td>usuario</td>
                            <td>Editar</td>
                            <td>Eliminar</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $mostrandoTabla = new InstruccionesGenerales();
                        $mostrandoDatos = $mostrandoTabla->mostrandoValores("SELECT tbdatosusuario.direccionarchivos as 'direccionFoto', tbdatosusuario.nombreusuario as 'nombreUsuario', tbdatosusuario.usuario as 'nickUsuario' FROM tbdatosusuario INNER JOIN tbusuarios ON tbdatosusuario.usuario = tbusuarios.usuario ORDER BY nombreusuario");

                        if(count($mostrandoDatos) > 0)//si cuando hace el query obtiene un resultado los desplegara
                        {
                            for($i = 0; $i < count($mostrandoDatos); $i++)
                            {
                                print $salida = "<tr>
                                                <td class='tdEspacioPequenio'><img class='img-circle imgTablaIndex' src='img/imgSubidasTemporal/".$mostrandoDatos[$i]['direccionFoto']."' alt='Soy ' /></td>
                                                <td>".$mostrandoDatos[$i]['nombreUsuario']."</td>
                                                <td>".$mostrandoDatos[$i]['nickUsuario']."</td>
                                                <td class='tdEspacioPequenio'><button id='btnEditarIndex' title='Quiero editar este registro' class='btn btn-warning'><i class='icon-edit icon-white'></i>Editar</button></td>
                                                <td class='tdEspacioPequenio'><button id='btnEliminarIndex' title='Quiero eliminar este registro' class='btn btn-danger'><i class='icon-remove icon-white'></i>Eliminar</button></td>
                                            </tr>";
                            }
                        }else
                        {
                            $salida = '
                                    <tr id="sinDatos">
                                            <td colspan="5" class="centerTXT">NO HAY REGISTROS EN LA BASE DE DATOS</td>
                                    </tr>
                            ';
                        }
                        ?>
<!--                        <tr>
                            <td class="tdEspacioPequenio"><img class="img-circle imgTablaIndex" src="img/imgSubidasTemporal/foto_08-06-2013_1370724498.jpg" alt="Tu foto" /></td>
                            <td>Khriz</td>
                            <td>khrizenriquez</td>
                            <td class="tdEspacioPequenio"><button id="btnEditarIndex" title="Quiero editar este registro" class="btn btn-warning"><i class="icon-edit icon-white"></i>Editar</button></td>
                            <td class="tdEspacioPequenio"><button id="btnEliminarIndex" title="Quiero eliminar este registro" class="btn btn-danger"><i class="icon-remove icon-white"></i>Eliminar</button></td>
                        </tr>-->
                    </tbody>
                </table>
            </div>
        </section>
        
        <!-- ventana editar usuarios -->
        <div class="hide" id="divEditarUsuariosIndex" title="Editar usuarios">
            <form action="" method="POST" id="formEditarUsuarios">
                <fieldset id="datosUsuario">
                    <p>Nombre: </p>
                    <span></span>
                    <input required type="text" placeholder="Nombre" class="{required:true}, maxlength:40" />
                    <p>Apellidos: </p>
                    <span></span>
                    <input required type="text" placeholder="Apellidos" class="{required:true}, maxlength:90" />
                    <p>Usuario: </p>
                    <span></span>
                    <input required type="text" placeholder="usuario" class="{required:true}, maxlength:40" />
                    <button id="btnEditarDatos" class="btn btn-warning"><i class="icon-pencil"></i>Editar</button>
                </fieldset>
            </form>
        </div>
        <!-- ventana editar usuarios -->
        
        <?php
        $pie = new ElementosRepetidos();
        $pie->piePagina('black', '&COPY;Khriz Enríquez ');
        ?>
        
        <!-- area de scripts -->
        <script src="js/js/quitandoWebKit.js"></script>
        <script src="js/jQuery/jqueryMin.js"></script>
        <script src="js/jqueryUI/jquery-ui.js"></script>
        <script src="js/Modernizr/modernizr.custom.33838.js"></script>
        <script src="js/jQuery/valoresIniciales.js"></script>
        <script src="js/ajaxUpload/ajaxUpload2.0.js"></script>
        <script src="js/jquery-validation-1.9.0/jquery.validate.min.js"></script>
        <script src="js/jquery-validation-1.9.0/lib/jquery.metadata.js"></script>
        <script src="js/jquery-validation-1.9.0/localization/messages_es.js"></script>
        <script src="js/jsBootstrap/bootstrap.js"></script>
        <!-- area de scripts -->
        
    </body>
</html>