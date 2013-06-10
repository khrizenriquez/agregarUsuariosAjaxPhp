<?php
require_once("./instruccionesBD.php");
/*//echo "$j-";
		//echo $a."<br>";
		if ($a==$_GET["pos"])
		{
			$style='style="font-weight:bold"';
		}else
		{
			$style="";
		}
 */

$contando = new InstruccionesGenerales();
$total = $contando->selectCount("SELECT COUNT(*) as 'contador' FROM tbusuarios");
        
$mostrandoTabla = new InstruccionesGenerales();
$mostrandoDatos = $mostrandoTabla->mostrandoValores("SELECT tbdatosusuario.direccionarchivos as 'direccionFoto', tbdatosusuario.nombreusuario as 'nombreUsuario', tbdatosusuario.usuario as 'nickUsuario', tbusuarios.correlativo FROM tbdatosusuario INNER JOIN tbusuarios ON tbdatosusuario.usuario = tbusuarios.usuario ORDER BY nombreusuario");

$num = $total[0]['contador'] / 10;
$resto = $total[0]['contador'] % 10;
$ultimo = $total[0]['contador'] - $resto;

$paginacion = $mostrandoTabla->imprimiendoColumnas($_GET["pos"]);

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