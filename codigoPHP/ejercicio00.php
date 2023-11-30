<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../webroot/css/style.css">
        <title>DWES</title>
    </head>
    <body>
        <header>
            <h1>1. (ProyectoTema4) Conexión a la base de datos con la cuenta usuario y tratamiento de errores.</h1>
        </header>
        <main>
            <h2>Ejemplo de conexión exitosa:</h2>
            <?php
                /**
                * Author:  Erika Martínez Pérez
                * Created: 06/11/2023
                */
                
                require_once '../config/confDB.php';
                
                $attributesPDO = array(
                    'AUTOCOMMIT', 'ERRMODE', 
                    'CASE', 'CLIENT_VERSION', 
                    'CONNECTION_STATUS', 'ORACLE_NULLS', 
                    'PERSISTENT', 'SERVER_INFO', 
                    'SERVER_VERSION'
                );
                
                try {
                    // Establecemos la conexión con la base de datos
                    $miDB = new PDO(dsn,usuario,password);
                    echo ("CONEXIÓN EXITOSA <br>");
                    
                    echo ("<h2>DATOS DE LA CONEXION: </h2>");
                    foreach ($attributesPDO as $valor) {
                        echo('PDO::ATTR_'.$valor.' => <strong>'.$miDB->getAttribute(constant("PDO::ATTR_$valor"))."</strong><br>");
                    }
                } catch (PDOException $pdoEx) { // Mostrado dell mensaje seguido del error correspondiente debido a la excepción
                    echo ("ERROR DE CONEXIÓN ".$pdoEx->getMessage());
                } finally {
                    unset($miDB);
                }
            ?>
            <br>
            <h2>Ejemplo de conexión fallida:</h2>
            <?php
            
                /*  Realizacion de la misma conexion anteriormente realizada con un fallo en la IP
                 *  para comprobar que el try funciona correctamente.
                 */
                try {
                    $miDB = new PDO(dsn,usuario,'paso1'); // Establecemos la conexión con la base de datos
                    echo ("CONEXIÓN EXITOSA"); 
                } catch (PDOException $pdoEx) { // Mostrado dell mensaje seguido del error correspondiente debido a la excepción
                    echo ("ERROR DE CONEXIÓN <br><br>".$pdoEx->getMessage());
                } finally {
                    unset($miDB);
                }
            ?>
        </main>
        <footer>
            <p>2023-2024 © Todos los derechos reservados. <a href="../indexProyectoTema4.php">Erika Martínez Pérez</a></p>
        </footer>
    </body>
</html>