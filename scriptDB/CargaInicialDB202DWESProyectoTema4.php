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
    $conn = new PDO(dsn,usuario,password);

    // Inserto los datos iniciales en la tabla Departamento
    $query1 = "INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES
    ('DAW', 'Desarrollo de aplicaciones web', NOW(), 10.50, NULL),
    ('DAM', 'Desarrollo de aplicaciones multiplataforma', NOW(), 5.50, NULL),
    ('ASI', 'Administracion de sistemas informaticos en red', NOW(), 6.7, NULL),
    ('SMR', 'Sistemas microinformarticos y redes', NOW(), 1.3, NULL),
    ('DTI', 'Dibujo tecnico industrial', NOW(), 13.2, NULL)";
   
    // Ejecutar consultas SQL
    $sql_queries = [$query1];

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



