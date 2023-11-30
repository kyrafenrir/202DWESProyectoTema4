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
            <h1>5. Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno</h1>
        </header>
        <main>
                <?php
                    /**
                    * @author Carlos García Cachón
                    * Adaptado por @author Erika Martínez Pérez
                    * @version 1.0
                    * @since 17/11/2023
                    */
                   // Incluyo la libreria de validación para comprobar los campos
                   require_once '../core/231018libreriaValidacion.php';
                   require_once '../config/confDB.php';

                   try {
                       // CONEXION CON LA BD
                       // Establecemos la conexión por medio de PDO
                       $miDB = new PDO(dsn,usuario,password);
                       $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configuramos las excepciones
                       // CONSULTAS Y TRANSACCION
                       $miDB->beginTransaction(); // Deshabilitamos el modo autocommit
                       // Consultas SQL de inserción 
                       $consultaInsercion1 = "INSERT INTO Departamento(CodDepartamento, DescDepartamento, FechaCreacionDepartamento, VolumenNegocio, FechaBaja) VALUES ('AAD', 'Departamento de Cobro', now(), 7.4, NULL)";
                       $consultaInsercion2 = "INSERT INTO Departamento(CodDepartamento, DescDepartamento, FechaCreacionDepartamento, VolumenNegocio, FechaBaja) VALUES ('AAE', 'Departamento de I+D', now(), 10.7, NULL)";
                       $consultaInsercion3 = "INSERT INTO Departamento(CodDepartamento, DescDepartamento, FechaCreacionDepartamento, VolumenNegocio, FechaBaja) VALUES ('AAF', 'Departamento de Inmuebles', now(), 18.3, NULL)";

                       // Preparamos las consultas
                       $resultadoconsultaInsercion1 = $miDB->prepare($consultaInsercion1);
                       $resultadoconsultaInsercion2 = $miDB->prepare($consultaInsercion2);
                       $resultadoconsultaInsercion3 = $miDB->prepare($consultaInsercion3);

                       // Ejecuto las consultas preparadas y mostramos la tabla en caso 'true' o un mensaje de error en caso de 'false'.
                       // (La función 'execute()' devuelve un valor booleano que indica si la consulta se ejecutó correctamente o no.)
                       if ($resultadoconsultaInsercion1->execute() && $resultadoconsultaInsercion2->execute() && $resultadoconsultaInsercion3->execute()) {
                           $miDB->commit(); // Confirma los cambios y los consolida
                           echo ("<div class='respuestaCorrecta'>Los datos se han insertado correctamente en la tabla Departamento.</div>");

                           // Preparamos y ejecutamos la consulta SQL
                           $consulta = "SELECT * FROM Departamento";
                           $resultadoConsultaPreparada = $miDB->prepare($consulta);
                           $resultadoConsultaPreparada->execute();

                           /* Aqui recorremos todos los valores de la tabla, columna por columna, usando el parametro 'PDO::FETCH_ASSOC' , 
                            * el cual nos indica que los resultados deben ser devueltos como un array asociativo, donde los nombres de las columnas de 
                            * la tabla se utilizan como claves (keys) en el array.
                            */
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