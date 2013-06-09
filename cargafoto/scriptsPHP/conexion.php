<?php
abstract class ConexionPDO
{
    static function conexion($nombreHost, $usuario, $clave, $nombreBD)
    {
        try
        {
            $conectandome = new PDO("mysql:host=".$nombreHost.";dbname=". $nombreBD, $usuario, $clave);//para la conexion necesito 4 valores, clave, usuario
            $conectandome->query("SET NAMES 'utf8'");//para que los datos que entran a la bd admitan caracteres especiales
//            $conectandome->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
            return($conectandome);
            // y el nombre del host donde estara la bd, aparte del nombre de la bd
//            $conectandome->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }catch(PDOException $e) 
        { 
            echo "Error en la conexión: " . $e->getMessage();
            print "<p>Error: No puede conectarse con la base de datos.</p>\n";
            exit();
        }
    }
}
?>