<?php
require_once './instruccionesBD.php';
sleep(3);
// Inicializamos variables de mensajes y JSON
$respuestaOK = false;
$mensajeError = "No se puede ejecutar la aplicación";
$contenidoOK = "";

//
//$insertando = new InstruccionesGenerales();
//$insertando->insertandoValores($queryInsertar);

if(isset($_POST) && !empty($_POST)) 
{
    // Verificamos las variables de acción
    switch ($_POST['accion'])
    {
        case 'addUser':
            //establesco con $insertandoTransaccion la conexion
            $insertandoTransaccion = ConexionPDO::conexion($this->nombreHost, $this->usuario, $this->clave, $this->nombreBD);
            $stmt = $insertandoTransaccion->prepare("INSERT INTO tbusuarios VALUES('null', ?, ?);");
            try
            {
                $insertandoTransaccion->beginTransaction();

                $insertandoTransaccion->bindParam(1, $nom);
                $insertandoTransaccion->bindParam(2, $clave);

                $hash = hash('sha512', $_POST["txtClaveRegistro"]);// - creates 512 bit hash, 128 caracteres

                $clave = strip_tags($hash);
                $nom = strip_tags($_POST["txtUsuarioRegistro"]);
                //SIQUISIERAMOS QUE NUESTRAS CONSULTAS FUERAN SEGURAS PODEMOS USAR ESTAS VARIABLES CON EL QUERY DE ARRIBA (CON ?)

                $insertandoTransaccion->execute();//para ejecutar nuestro query

                $insertandoDP = $insertandoTransaccion->prepare("INSERT INTO tbdatosusuario VALUES(?, ?, ?, ?, 'null')");//insertando en la tabla direccion

                $insertandoTransaccion->bindParam(1, $nombreUsuario);
                $insertandoTransaccion->bindParam(2, $apellidosUsuario);
                $insertandoTransaccion->bindParam(3, $nickName);
                $insertandoTransaccion->bindParam(4, $direcFoto);

                $nombreUsuario = strip_tags($_POST['txtNombreRegistro']);
                $apellidosUsuario = strip_tags($_POST["txtApellidosRegistro"]);
                $nickName = strip_tags($nom);
                $direcFoto = strip_tags($_POST["txtEscondido"]);

                $insertandoDP->execute();//ejecuto la insercion hacia direccion
    //            print "query direccion: INSERT INTO direccion VALUES('null', '".$_POST['txtZonaDatosPersonales']."', '".$_POST['txtColDatosPersonales']."', '".$_POST['selectMunicipioDatosPersonales']."');";

                $idDP = $insertandoTransaccion->lastInsertId();//le cargo el ultimo id que inserte para poder
                
                if($idDP == '0')
                {
                    $insertandoTransaccion->rollBack();
                }else
                {
                    $insertandoTransaccion->commit();
                }
   
            }catch(PDOException $e)
            {
                $insertandoTransaccion->rollBack();
                throw $e;
                $insertandoTransaccion = null;//dejamos con un valor nulo la conexion
            }
            if($insertandoTransaccion == true)
            {
                $respuestaOK = true;
                $mensajeError = "Se ha agregado el registro correctamente";
                $contenidoOK = "
                        <tr>
                            <td class='tdEspacioPequenio'><img class='img-circle imgTablaIndex' src='img/imgSubidasTemporal/".$_POST['txtEscondido']."' alt='Soy ' /></td>
                                <td>".$_POST['txtNombreRegistro']."</td>
                                <td>".$_POST['txtUsuarioRegistro']."</td>
                                <td class='tdEspacioPequenio'><button id='btnEditarIndex' title='Quiero editar este registro' class='btn btn-warning'><i class='icon-edit icon-white'></i>Editar</button></td>
                                <td class='tdEspacioPequenio'><button id='btnEliminarIndex' title='Quiero eliminar este registro' class='btn btn-danger'><i class='icon-remove icon-white'></i>Eliminar</button></td>
                            </tr>";
            }
            else
            {
                $mensajeError = "No se puede guardar el registro en la base de datos";
            }

        break;

            case 'editUser':
                    // Armamos el query
                    $query = sprintf("UPDATE tbl_usuarios
                                                     SET usr_nombre='%s', usr_puesto='%s', usr_nick='%s', usr_status='%s'
                                                     WHERE id_user=%d LIMIT 1",
                                                     $_POST['usr_nombre'],$_POST['usr_puesto'],$_POST['usr_nick'],$_POST['usr_status'],$_POST['id_user']);

                    // Ejecutamos el query
                    $resultadoQuery = $mysqli -> query($query);

                    // Validamos que se haya actualizado el registro
                    if($mysqli -> affected_rows == 1){
                            $respuestaOK = true;
                            $mensajeError = 'Se ha actualizado el registro correctamente';

                            $contenidoOK = consultaUsers($mysqli);

                    }else{
                            $mensajeError = 'No se ha actualizado el registro';
                    }


            break;
            case 'eliminar':
                    // Armamos el query
                    $query = sprintf("DELETE FROM tbl_usuarios
                                                     WHERE id_user=%d LIMIT 1",
                                                     $_POST['id_user']);

                    // Ejecutamos el query
                    $resultadoQuery = $mysqli -> query($query);

                    // Validamos que se haya actualizado el registro
                    if($mysqli -> affected_rows == 1){
                            $respuestaOK = true;
                            $mensajeError = 'Se ha actualizado el registro correctamente';

                            $contenidoOK = consultaUsers($mysqli);

                    }else{
                            $mensajeError = 'No se ha eliminado el registro';
                    }
            break;

            default:
                    $mensajeError = 'Esta acción no se encuentra disponible';
            break;
    }
}
else{
    $mensajeError = 'No se puede ejecutar la aplicación';
}
// Incluimos el archivo de funciones y conexión a la base de datos

$statusTipoOK = array("Activo" => "btn-success",
					  "Suspendido" => "btn-warning");


// Validar conexión con la base de datos
//if($errorDbConexion == false){
//	// Validamos qe existan las variables post
//	if(isset($_POST) && !empty($_POST)){
//		// Verificamos las variables de acción
//		switch ($_POST['accion']) {
//			case 'addUser':
//				// Armamos el query
//				$query = sprintf("INSERT INTO tbl_usuarios
//								 SET usr_nombre='%s', usr_puesto='%s', usr_nick='%s', usr_status='%s'",
//								 $_POST['usr_nombre'],$_POST['usr_puesto'],$_POST['usr_nick'],$_POST['usr_status']);
//
//				// Ejecutamos el query
//				$resultadoQuery = $mysqli -> query($query);
//
//
//				// Obtenemos el id de user para edición
//				$id_userOK = $mysqli -> insert_id;
//
//				if($resultadoQuery == true){
//					$respuestaOK = true;
//					$mensajeError = "Se ha agregado el registro correctamente";
//					$contenidoOK = '
//						<tr>
//							<td>'.$_POST['usr_nombre'].'</td>
//							<td>'.$_POST['usr_puesto'].'</td>
//							<td>'.$_POST['usr_nick'].'</td>
//							<td class="centerTXT"><span class="btn btn-mini '.$statusTipoOK[$_POST['usr_status']].'">'.$_POST['usr_status'].'</span></td>
//							<td class="centerTXT"><a data-accion="editar" class="btn btn-mini" href="'.$id_userOK.'">Editar</a> <a data-accion="eliminar" class="btn btn-mini" href="'.$id_userOK.'">Eliminar</a></td>
//						<tr>
//					';
//
//				}
//				else{
//					$mensajeError = "No se puede guardar el registro en la base de datos";
//				}
//
//			break;
//			
//			case 'editUser':
//				// Armamos el query
//				$query = sprintf("UPDATE tbl_usuarios
//								 SET usr_nombre='%s', usr_puesto='%s', usr_nick='%s', usr_status='%s'
//								 WHERE id_user=%d LIMIT 1",
//								 $_POST['usr_nombre'],$_POST['usr_puesto'],$_POST['usr_nick'],$_POST['usr_status'],$_POST['id_user']);
//
//				// Ejecutamos el query
//				$resultadoQuery = $mysqli -> query($query);
//
//				// Validamos que se haya actualizado el registro
//				if($mysqli -> affected_rows == 1){
//					$respuestaOK = true;
//					$mensajeError = 'Se ha actualizado el registro correctamente';
//
//					$contenidoOK = consultaUsers($mysqli);
//
//				}else{
//					$mensajeError = 'No se ha actualizado el registro';
//				}
//
//
//			break;
//			case 'eliminar':
//				// Armamos el query
//				$query = sprintf("DELETE FROM tbl_usuarios
//								 WHERE id_user=%d LIMIT 1",
//								 $_POST['id_user']);
//
//				// Ejecutamos el query
//				$resultadoQuery = $mysqli -> query($query);
//
//				// Validamos que se haya actualizado el registro
//				if($mysqli -> affected_rows == 1){
//					$respuestaOK = true;
//					$mensajeError = 'Se ha actualizado el registro correctamente';
//
//					$contenidoOK = consultaUsers($mysqli);
//
//				}else{
//					$mensajeError = 'No se ha eliminado el registro';
//				}
//			break;
//
//			default:
//				$mensajeError = 'Esta acción no se encuentra disponible';
//			break;
//		}
//	}
//	else{
//		$mensajeError = 'No se puede ejecutar la aplicación';
//	}
//
//
//}
//else{
//	$mensajeError = 'No se puede establecer conexión con la base de datos';
//}
//
// Armamos array para convertir a JSON
$salidaJson = array("respuesta" => $respuestaOK, "mensaje" => $mensajeError, "contenido" => $contenidoOK);

echo json_encode($salidaJson);
?>