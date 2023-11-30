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
            <h1>6. Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada.</h1>
        </header>
        <main>
            <?php
                /**
                 * @author Carlos García Cachón
                 * Adaptado por @author Erika Martínez Pérez
                 * @version 1.1
                 * @since 15/11/2023
                 */
                // Incluyo la libreria de validación para comprobar los campos
                require_once '../core/231018libreriaValidacion.php';
                require_once '../config/confDB.php';

                // Defino una constante para la fecha y hora actual
                define('FECHA_ACTUAL', date('Y-m-d H:i:s'));

                // Declaro una variable de entrada para mostrar o no la tabla con los valores de la BD
                $bEntradaOK = true;

                try {
                    // CONEXION CON LA BD
                    // Establecemos la conexión por medio de PDO
                    $miDB = new PDO(dsn,usuario,password);
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configuramos las excepciones
                    // CONSULTAS Y TRANSACCION
                    $miDB->beginTransaction(); // Deshabilitamos el modo autocommit
                    // Consultas SQL de inserción 
                    $consultaInsercion = "INSERT Departamento(CodDepartamento, DescDepartamento, FechaCreacionDepartamento, VolumenNegocio, FechaBaja) "
                            . "VALUES (:CodDepartamento, :DescDepartamento, :FechaCreacionDepartamento, :VolumenNegocio, :FechaBaja)";

                    // Preparamos las consultas
                    $resultadoconsultaInsercion = $miDB->prepare($consultaInsercion);

                    // ARRAY CON REGISTROS
                    $aDepartamentosNuevos = [
                        ['CodDepartamento' => 'AAG', 'DescDepartamento' => 'Departamento de Montaje', 'FechaCreacionDepartamento' => FECHA_ACTUAL, 'VolumenNegocio' => 11.9, 'FechaBaja' => null],
                        ['CodDepartamento' => 'AAH', 'DescDepartamento' => 'Departamento de Desmontaje', 'FechaCreacionDepartamento' => FECHA_ACTUAL, 'VolumenNegocio' => 13.3, 'FechaBaja' => null]
                    ];

                    foreach ($aDepartamentosNuevos as $departamento) { //Recorremos los registros que vamos a insertar en la tabla
                        $aResgistros = [':CodDepartamento' => $departamento['CodDepartamento'],
                            ':DescDepartamento' => $departamento['DescDepartamento'],
                            ':FechaCreacionDepartamento' => $departamento['FechaCreacionDepartamento'],
                            ':VolumenNegocio' => $departamento['VolumenNegocio'],
                            ':FechaBaja' => $departamento['FechaBaja']];
                        if (!$resultadoconsultaInsercion->execute($aResgistros)) {
                            $bEntradaOK = false;
                            break;
                        }
                    }

                    // Ejecuto la consulta preparada y mostramos la tabla en caso 'true' o un mensaje de error en caso de 'false'.
                    // (La función 'execute()' devuelve un valor booleano que indica si la consulta se ejecutó correctamente o no.)
                    if ($bEntradaOK) {
                        $miDB->commit(); // Confirma los cambios y los consolida
                        echo ("<div class='respuestaCorrecta'>Los datos se han insertado correctamente en la tabla Departamento.</div><br>");

                        // Preparamos y ejecutamos la consulta SQL
                        $consulta = "SELECT * FROM Departamento";
                        $resultadoConsultaPreparada = $miDB->prepare($consulta);
                        $resultadoConsultaPreparada->execute();

                        echo('<table><tr><th>Código</th><th>Descripción</th><th>Fecha de creación</th><th>Volumen</th><th>Fecha de baja</th></tr>');
                        while ($oDepartamento = $resultadoConsultaPreparada->fetchObject()) {// TAMBIEN SE PUEDE REALIZAR CON fetch(PDO::FETCH_OBJ)
                            echo('<tr>');
                            echo('<td>' . $oDepartamento->CodDepartamento . '</td>');
                            echo('<td>' . $oDepartamento->DescDepartamento . '</td>');
                            echo('<td>' . $oDepartamento->FechaCreacionDepartamento . '</td>');
                            echo('<td>' . $oDepartamento->VolumenNegocio . '</td>');
                            echo('<td>' . $oDepartamento->FechaBaja . '</td>');
                            echo('</tr>');
                        }
                        echo('</table><br>');
                        echo('</div><br><br>');
                    }
                } catch (PDOException $miExcepcionPDO) {
                    $miDB->rollback(); //  Revierte o deshace los cambios
                    $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
                    $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

                    echo ("<div class='errorException'>Hubo un error al insertar los datos en la tabla Departamento.<br></div>");
                    echo "<span class='errorException'>Error: </span>" . $mensajeExcepcion . "<br>"; // Mostramos el mensaje de la excepción
                    echo "<span class='errorException'>Código del error: </span>" . $errorExcepcion; // Mostramos el código de la excepción
                } finally {
                    unset($miDB); // Para cerrar la conexión
                }
            ?>
        </main>
        <footer>
            <p>2023-2024 © Todos los derechos reservados. <a href="../indexProyectoTema4.php">Erika Martínez Pérez</a></p>
        </footer>
    </body>
</html>