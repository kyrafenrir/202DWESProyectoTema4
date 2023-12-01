<?php
/**
 * @author Carlos García Cachón
 * @version 1.0
 * @since 27/11/2023
 * @copyright Todos los derechos reservados Carlos García 
 * 
 * @Annotation Scrip de carga inicial de la base de datos en PHP
 * 
 */
// Configuración de conexión con la base de datos
define('dsn', 'mysql:host=192.168.20.19;dbname=DB202DWESProyectoTema4'); // Host 'IP' y nombre de la base de datos
define('usuario','user202DWESProyectoTema4'); // Nombre de usuario de la base de datos
define('password','paso'); // Contraseña de la base de datos

try {
    // Crear conexión
    $conn = new PDO(dsn, usuario, password);

    // Elimino el usuario de la base de datos
    $query2 = "DROP TABLE  T02_Departamento";

    // Ejecutar consultas SQL
    $sql_queries = [$query2];

    foreach ($sql_queries as $query) {
        if ($conn->query($query) === FALSE) {
            throw new Exception("Error al ejecutar la consulta: $query - " . $conn->error);
        }
        echo "Consulta ejecutada con éxito: $query<br>";
    }
} catch (PDOException $miExcepcionPDO) {
    $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
    $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

    echo "<span class='errorException'>Error: </span>" . $mensajeExcepcion . "<br>"; // Mostramos el mensaje de la excepción
    echo "<span class='errorException'>Código del error: </span>" . $errorExcepcion; // Mostramos el código de la excepción
    die($miExcepcionPDO);
} finally {
    // Cerrar la conexión
    if (isset($conn)) {
        $conn = null;
    }
}



