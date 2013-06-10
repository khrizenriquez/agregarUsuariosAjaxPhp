<!-- 
    creado por Khriz Enríquez (tw) @khrizenriquez (fb) /khrizenriquez
-->
<?php
require_once './scriptsPHP/elementosRepetidos.php';//script que me sirve para los elementos repetidos que pueden aparecer en mi formulario
require_once './scriptsPHP/instruccionesBD.php';

if (isset($_GET["pos"]))
{
    $inicio=$_GET["pos"];
}else
{
    $inicio=0;
}
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
<!--                        <fieldset id="ocultos">
                            <input type="hidden" id="accion" name="accion" class="{required:true}" value="addUser"/>
                            <input type="hidden" id="id_user" name="id_user" class="{required:true}" value="0"/>
	    		</fieldset>-->
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
                    <br />
                    <button class="btn btn-success" title="Quiero registrarme en tu página" id="btnRegistrarme" type="submit" role='button'><i class="icon-ok icon-white"></i>Registrarme</button>
                </form>
                <div id="divImgCargando">
                    <img src="img/loaders/ajax-loaderPackmanNegro.gif" alt="Cargando" />
                    <label for="subiendo" class="">Cargando...</label>
                </div>
            </article>
        </section>
        <?php
        $contando = new InstruccionesGenerales();
        $total = $contando->selectCount("SELECT COUNT(*) as 'contador' FROM tbusuarios");
        ?>
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
                        </tr>
                    </thead>
                    <tbody id="listaUsuarios">
                        <?php
                        $mostrandoTabla = new InstruccionesGenerales();
                        $mostrandoDatos = $mostrandoTabla->mostrandoValores("SELECT tbdatosusuario.direccionarchivos as 'direccionFoto', tbdatosusuario.nombreusuario as 'nombreUsuario', tbdatosusuario.usuario as 'nickUsuario', tbusuarios.correlativo FROM tbdatosusuario INNER JOIN tbusuarios ON tbdatosusuario.usuario = tbusuarios.usuario ORDER BY nombreusuario");
                        
                        $num = $total[0]['contador'] / 10;
                        $resto = $total[0]['contador'] % 10;
                        $ultimo = $total[0]['contador'] - $resto;
                        
                        $paginacion = $mostrandoTabla->imprimiendoColumnas($inicio);
                        
                        if(count($paginacion) > 0)//si cuando hace el query obtiene un resultado los desplegara
                        {
                            for($i = 0; $i < count($paginacion); $i++)
                            {
                                print $salida = "<tr>
                                                <td class='tdEspacioPequenio'><img class='img-circle imgTablaIndex' src='".$paginacion[$i]['direccionFoto']."' alt='Soy ".$paginacion[$i]['nombreUsuario']."' /></td>
                                                <td>".$paginacion[$i]['nombreUsuario']."</td>
                                                <td>".$paginacion[$i]['nickUsuario']."</td>
                                                <td class='tdEspacioPequenio'><a href='".$paginacion[$i]['correlativo']."' id='".$paginacion[$i]['correlativo']."' title='Quiero editar los datos de ".$paginacion[$i]['nombreUsuario']."' class='btn btn-warning'><i class='icon-edit icon-white'></i>Editar</a></td>
                                            </tr>";
                            }
                        }else
                        {
                            print $salida = '
                                    <tr id="sinDatos">
                                            <td colspan="5" class="centerTXT">NO HAY REGISTROS EN LA BASE DE DATOS</td>
                                    </tr>
                            ';
                        }
                        ?>
                    </tbody>
                    <?php
                    //cargamos los números de páginas
                    $a = 0;
                    for ($j = 1;$j <= $total[0]['contador']; $j++)
                    {
                        if ($j <= $num)
                        {
                                //echo "$j-";
                        ?>
                        
                    
                        <a href="javascript:void(0);" class="btn btn-small" title="P&aacute;gina <?php echo $j;?>" onclick="from('<?php echo $a?>')"><?php echo $j;?></a>
                        <?php
                        }
                        $a=$a+10;
                    }
                    if (count($paginacion)==10)
                    {
                        ?>
                        <a href="javascript:void(0);" class="btn btn-small" title="P&aacute;gina <?php echo number_format($num)+1;?>" onclick="from('<?php echo $ultimo;?>')"><?php echo number_format($num)+1;?></a>
                        <?php
                    }else
                    {
                        echo number_format($num) + 1;
                    }
                    ?>
                </table>
            </div>
        </section>
        
        <!-- ventana editar usuarios -->
        
        <div class="hide" id="agregarUser" Title="Agregar Usuario">
            <form action="" method="post" id="formUsers" name="formUsers">
                <fieldset id="ocultos">
                        <input type="hidden" id="accion" name="accion" class="{required:true}"/>
                        <input type="hidden" id="id_user" name="id_user" class="{required:true}" value="0"/>
                </fieldset>
                        <fieldset id="datosUser">
                                <p>Nombre</p>
                                <span></span>
                                <input type="text" id="txtNombreRegistroEditar" name="usr_nombre" placeholder="Nombre Completo" class="{required:true,maxlength:120} span3"/>
                                <p>Usuario</p>
                                <span></span>
                                <input type="text" id="txtUsuarioRegistroEditar" name="usr_puesto" placeholder="puesto que desempeña" class="{required:true,maxlength:80} span3"/>
                        <fieldset id="btnAgregar" style="text-align:center;">
                                <input type="submit" id="continuar" value="Continuar" />
                        </fieldset>

                        <fieldset id="ajaxLoader" class="ajaxLoader hide">
                                <img src="images/default-loader.gif">
                                <p>Espere un momento...</p>
                        </fieldset>
                </form>
        </div>
        
<!--        <div class="hide" id="divEditarUsuariosIndex" title="Editar usuarios">
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
        </div>-->
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
        <script src="js/js/funciones.js"></script>
        <!-- area de scripts -->
        
    </body>
</html>