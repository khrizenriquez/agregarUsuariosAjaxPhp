<?php
require_once 'conexion.php';//necesito hacer referencia a la bd

class InstruccionesGenerales
{
    private $nombreHost;//si es local se usa localhost sino la direccion donde esta el archivo
    private $usuario;
    private $clave;
    private $nombreBD;
    private $datos;
    
    function __construct()
    {
        $this->nombreHost = "localhost";
        $this->usuario = "root";
        $this->clave = "";
        $this->nombreBD = "bdcargafoto";
        $this->datos = array();
    }
    
    //--------------------------------------------------------------------------metodo que se encargara de regresarnos un valor de algun select
    function mostrandoValores($querySelect)
    {
        //con la variable $mostrando le cargo la conexion y ejecuto el query select
        $mostrando = ConexionPDO::conexion($this->nombreHost, $this->usuario, $this->clave, $this->nombreBD)->query($querySelect);
        
        if($mostrando ->rowCount() > 0)//si cuando hace el query obtiene un resultado los desplegara
        {
            foreach($mostrando as $lista)
            {
                $this->datos[] = $lista;
            }
            return $this->datos;
            $mostrando = null;//dejamos con un valor nulo la conexion
        }else
        {
            print "No existen datos";
        }
    }
    function insertandoValores($queryInsertar)
    {
        $insertando = ConexionPDO::conexion($this->nombreHost, $this->usuario, $this->clave, $this->nombreBD)->prepare($queryInsertar);
        
        $insertando->execute();//para ejecutar nuestro query
        $insertando = null;//dejamos con un valor nulo la conexion
    }
//    function insertandoTransaccionDatosPersonales($queryInsertar)
    function insertandoTransaccionDatosPersonales()
    {
        //establesco con $insertandoTransaccion la conexion
        $insertandoTransaccion = ConexionPDO::conexion($this->nombreHost, $this->usuario, $this->clave, $this->nombreBD);
//        $stmt = $insertandoTransaccion->prepare('INSERT INTO my_table(my_id, my_value) VALUES(?, ?)');
//        $stmt = $insertandoTransaccion->prepare($queryInsertar);
//        $stmtDireccion = $insertandoTransaccion->prepare("INSERT INTO direccion VALUES('null', 'zona 18', 'Col Santa Elena 3', '1');");//insertando en la tabla direccion
//        $stmtDPersonales = $insertandoTransaccion->prepare("INSERT INTO datospersonales VALUES ('null', '".$_POST["txtNombreDatosPersonales"]."', '".$_POST["txtApellidosDatosPersonales"]."', '".$_POST["selectAnioDatosPersonales"]."-".$_POST["selectMesDatosPersonales"]."-".$_POST["selectDiaDatosPersonales"]."', '".$_POST["selectEstadoCivilDatosPersonales"]."', '".$_POST["radioGeneroDatosPersonales"]."', '".$_POST["txtCedulaDatosPersonales"]."', '".$_POST["txtDpiDatosPersonales"]."', '".$_POST["txtIGSSDatosPersonales"]."', '".$_POST["txtNITDatosPersonales"]."', '".$_POST["txtEmailDatosPersonales"]."', '1', '1', '1', '".$_POST["selectNacionalidadDatosPersonales"]."', '1', '2');");
//        $stmtDPersonales = $insertandoTransaccion->prepare("INSERT INTO datospersonales VALUES ('null', 'khriztofer', 'enriquez', '1993-04-02', '3', 'masculino', '1234646', '1234564', '13212313', '74153927', 'christoferen7@live.com', '1', '1', '1', '1', '1', '99');");
//        $stmtECivil = $insertandoTransaccion->prepare("INSERT INTO estadocivil VALUES('null', '3');");
//        $stmt = $insertandoTransaccion->prepare("SELECT datospersonales.idDatosPersonales, datospersonales.Nombres FROM datospersonales ORDER BY idDatosPersonales DESC LIMIT 1");
        try
        {
            $insertandoTransaccion->beginTransaction();
//                    $stmt->bindValue(1, $i, PDO::PARAM_INT);
//                    $stmt->bindValue(2, 'TEST', PDO::PARAM_STR);
            $insertandoDireccion = $insertandoTransaccion->prepare("INSERT INTO direccion VALUES('null', '".$_POST['txtZonaDatosPersonales']."', '".$_POST['txtColDatosPersonales']."', '".$_POST['selectMunicipioDatosPersonales']."');");//insertando en la tabla direccion
            $insertandoDireccion->execute();//ejecuto la insercion hacia direccion
//            print "query direccion: INSERT INTO direccion VALUES('null', '".$_POST['txtZonaDatosPersonales']."', '".$_POST['txtColDatosPersonales']."', '".$_POST['selectMunicipioDatosPersonales']."');";
            
            $idDireccion = $insertandoTransaccion->lastInsertId();//le cargo el ultimo id que inserte para poder
               
            if($idDireccion == '0')
            {
                print "<br />id Direccion: ".$idDireccion."<br />";
            }
            //a una variable le cargo la fecha
            $fechaConcatenada = $_POST["selectAnioDatosPersonales"]."-".$_POST["selectMesDatosPersonales"]."-".$_POST["selectDiaDatosPersonales"];
            //a una variable le cargo la fecha
//            print "fecha: " . $fechaConcatenada . "<br />";
//                    $stmtDPersonales = $insertandoTransaccion->prepare("INSERT INTO datospersonales VALUES ('null', 'Khriz Alberto', 'Enríquez Guzmán', '1993-02-04', '3', 'masculino', '1234646', '1234564', '13212313', '74153927', 'christoferen7@yahoo.com', '1', '1', '1', '1', '$idDireccion', '2');");
            $insertandoDG = $insertandoTransaccion->prepare("INSERT INTO datospersonales VALUES ('null', '".$_POST["txtNombreDatosPersonales"]."', '".$_POST["txtApellidosDatosPersonales"]."', '". $fechaConcatenada ."', '".$_POST["selectEstadoCivilDatosPersonales"]."', '".$_POST["selectGeneroDatosPersonales"]."', '".$_POST["txtCedulaDatosPersonales"]."', '".$_POST["txtDpiDatosPersonales"]."', '".$_POST["txtIGSSDatosPersonales"]."', '".$_POST["txtNITDatosPersonales"]."', '".$_POST["txtEmailDatosPersonales"]."', '1', '1', '1', '".$_POST["selectNacionalidadDatosPersonales"]."', '$idDireccion', '".$_POST['txtCantidadHijosDatosPersonales']."');");
            $insertandoDG->execute();//ejecuto la insercion hacia direccion
            $idDP = $insertandoTransaccion->lastInsertId();//le cargo el ultimo id que inserte para poder
            
            if($idDP == '0')
            {
                print "id DP: ".$idDP."<br />";
            }
            $this->id = $idDP;
            return $this->id;
//            print "INSERT INTO datospersonales VALUES ('null', '".$_POST["txtNombreDatosPersonales"]."', '".$_POST["txtApellidosDatosPersonales"]."', '".$fechaConcatenada."', '".$_POST["selectEstadoCivilDatosPersonales"] . "', '".$_POST["selectGeneroDatosPersonales"]."', '".$_POST["txtCedulaDatosPersonales"]."', '".$_POST["txtDpiDatosPersonales"]."', '".$_POST["txtIGSSDatosPersonales"]."', '".$_POST["txtNITDatosPersonales"]."', '".$_POST["txtEmailDatosPersonales"]."', '1', '1', '1', '" .$_POST["selectNacionalidadDatosPersonales"]. "', '$idDireccion', '2');";
            //----------------------------------------------------------me sirve para obtener el ultimo id ingresado 
//                    $mostrandoMunicipios = new InstruccionesGenerales();//creo la instancia para poder usar el metodo mostrandoValores
//                    $listaMunicipios = $mostrandoMunicipios->mostrandoValores("SELECT (logeo.idLogeo + 1) as 'login' FROM logeo ORDER BY idLogeo DESC LIMIT 1");
//                    print_r($listaMunicipios);//imprimo el valor en forma de arreglo lo ingresado
            //----------------------------------------------------------me sirve para obtener el ultimo id ingresado 
//                    $stmt->execute();
//                    $stmt->execute();
            $insertandoTransaccion->commit();
        }catch(PDOException $e)
        {
//                if(stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false)
//                {
//                    // This should be specific to SQLite, sleep for 0.25 seconds
//                    // and try again.  We do have to commit the open transaction first though
//                    $insertandoTransaccion->commit();
//                    usleep(250000);
//                }else
//                {
            $insertandoTransaccion->rollBack();
            throw $e;
//                }
            $insertandoTransaccion = null;//dejamos con un valor nulo la conexion
        }
    }
    function actualizarDatosGenerales()
    {
        $actualizandoTransaccion = ConexionPDO::conexion($this->nombreHost, $this->usuario, $this->clave, $this->nombreBD);
        $stmtActualizacion = $actualizandoTransaccion->prepare("");//
        try
        {
            $actualizandoTransaccion->beginTransaction();
            $stmtActualizacion->execute();//ejecuto la insercion hacia direccion
            $idDireccion = $actualizandoTransaccion->lastInsertId();//le cargo el ultimo id que inserte para poder
            print "id Direccion: ".$idDireccion."<br />";

            //a una variable le cargo la fecha
            $fechaConcatenada = $_POST["selectAnioDatosPersonales"]."-".$_POST["selectMesDatosPersonales"]."-".$_POST["selectDiaDatosPersonales"];
            //a una variable le cargo la fecha
            print "fecha: " . $fechaConcatenada . "<br />";
//                    $stmtDPersonales = $insertandoTransaccion->prepare("INSERT INTO datospersonales VALUES ('null', 'Khriz Alberto', 'Enríquez Guzmán', '1993-02-04', '3', 'masculino', '1234646', '1234564', '13212313', '74153927', 'christoferen7@yahoo.com', '1', '1', '1', '1', '$idDireccion', '2');");
            $stmtDPersonales = $actualizandoTransaccion->prepare("INSERT INTO datospersonales VALUES ('null', '".$_POST["txtNombreDatosPersonales"]."', '".$_POST["txtApellidosDatosPersonales"]."', '". $fechaConcatenada ."', '".$_POST["selectEstadoCivilDatosPersonales"]."', '".$_POST["selectGeneroDatosPersonales"]."', '".$_POST["txtCedulaDatosPersonales"]."', '".$_POST["txtDpiDatosPersonales"]."', '".$_POST["txtIGSSDatosPersonales"]."', '".$_POST["txtNITDatosPersonales"]."', '".$_POST["txtEmailDatosPersonales"]."', '1', '1', '1', '".$_POST["selectNacionalidadDatosPersonales"]."', '$idDireccion', '2');");
            $stmtDPersonales->execute();//ejecuto la insercion hacia direccion
            $idDP = $actualizandoTransaccion->lastInsertId();//le cargo el ultimo id que inserte para poder
            print "id DP: ".$idDP."<br />";
            print "INSERT INTO datospersonales VALUES ('null', '".$_POST["txtNombreDatosPersonales"]."', '".$_POST["txtApellidosDatosPersonales"]."', '".$fechaConcatenada."', '".$_POST["selectEstadoCivilDatosPersonales"] . "', '".$_POST["selectGeneroDatosPersonales"]."', '".$_POST["txtCedulaDatosPersonales"]."', '".$_POST["txtDpiDatosPersonales"]."', '".$_POST["txtIGSSDatosPersonales"]."', '".$_POST["txtNITDatosPersonales"]."', '".$_POST["txtEmailDatosPersonales"]."', '1', '1', '1', '" .$_POST["selectNacionalidadDatosPersonales"]. "', '$idDireccion', '2');";
            //----------------------------------------------------------me sirve para obtener el ultimo id ingresado 
//                    $mostrandoMunicipios = new InstruccionesGenerales();//creo la instancia para poder usar el metodo mostrandoValores
//                    $listaMunicipios = $mostrandoMunicipios->mostrandoValores("SELECT (logeo.idLogeo + 1) as 'login' FROM logeo ORDER BY idLogeo DESC LIMIT 1");
//                    print_r($listaMunicipios);//imprimo el valor en forma de arreglo lo ingresado
            //----------------------------------------------------------me sirve para obtener el ultimo id ingresado 
//                    $stmt->execute();
//                    $stmt->execute();

            $actualizandoTransaccion->commit();
        }catch(PDOException $e)
        {
//                if(stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false)
//                {
//                    // This should be specific to SQLite, sleep for 0.25 seconds
//                    // and try again.  We do have to commit the open transaction first though
//                    $insertandoTransaccion->commit();
//                    usleep(250000);
//                }else
//                {
            $actualizandoTransaccion->rollBack();
            throw $e;
//                }
            $actualizandoTransaccion = null;//dejamos con un valor nulo la conexion
        }
    }
}
?>