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
            <h1>7. Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla Departamento de nuestra base de datos. (IMPORTAR). El fichero importado se encuentra en el directorio .../tmp/ del servidor</h1>
        </header>
        <main>
            <?php
                /**
                 * @author Carlos García Cachón
                 * Adaptado por @author Erika Martínez Pérez
                 * @version 1.0
                 * @since 20/11/2023
                 */

                // Inicizalicación de variables de uso
                $host = '192.168.20.19'; // Nombre del servidor de la base de datos erroneo
                $namedb = 'DB202DWESProyectoTema4'; // Nombre de la base de datos
                $usuario = 'user202DWESProyectoTema4'; // Nombre de usuario de la base de datos
                $password = 'paso'; // Contraseña de la base de datos

                // Declaro una variable de entrada para mostrar o no la tabla con los valores de la BD
                $bEntradaOK = true;

                //Abro un bloque try catch para tener un mayor control de los errores
                try {
                    // CONEXION CON LA BD
                    /**
                     * Establecemos la conexión por medio de PDO
                     * DSN -> IP del servidor y Nombre de la base de datos
                     * USER -> Usuario con el que se conecta a la base de datos
                     * PASSWORD -> Contraseña del usuario
                     * */
                    $miDB = new PDO('mysql:host=' . $host . '; dbname=' . $namedb, $usuario, $password);

                    /**
                     * Modificamos los errores y añadimos los siguientes atributos de PDO
                     */
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Indicamos la ruta del archivo y la guardamos en una variable
                    $rutaArchivoJSON = '../tmp/departamentos.json';

                    // Leemos el contenido del archivo JSON
                    $contenidoArchivoJSON = file_get_contents($rutaArchivoJSON);

                    // Decodificamos el JSON a un array asociativo
                    $aContenidoDecodificadoArchivoJSON = json_decode($contenidoArchivoJSON, true);

                    // Verificamos si la decodificación fue exitosa
                    if ($aContenidoDecodificadoArchivoJSON === null && json_last_error() !== JSON_ERROR_NONE) {
                        // En caso negativo "matamos" la ejecución del script
                        die('Error al decodificar el archivo JSON.');
                    }
                    
                    // CONSULTAS Y TRANSACCION
                    $miDB->beginTransaction(); // Deshabilitamos el modo autocommit
                    // Consultas SQL de inserción 
                    $consultaInsercion = "INSERT Departamento(CodDepartamento, DescDepartamento, FechaCreacionDepartamento, VolumenNegocio, FechaBaja) "
                            . "VALUES (:CodDepartamento, :DescDepartamento, :FechaCreacionDepartamento, :VolumenNegocio, :FechaBaja)";

                    // Preparamos las consultas
                    $resultadoconsultaInsercion = $miDB->prepare($consultaInsercion);

                    foreach ($aContenidoDecodificadoArchivoJSON as $departamento) {
                        // Recorremos los registros que vamos a insertar en la tabla
                        $codDepartamento = $departamento['codDepartamento'];
                        $descDepartamento = $departamento['descDepartamento'];
                        $fechaCreacionDepartamento = $departamento['fechaCreacionDepartamento'];
                        $volumenNegocio = $departamento['volumenNegocio'];
                        $fechaBaja = $departamento['fechaBaja'];

                        // Si la fecha de baja está vacía asignamos el valor 'NULL'
                        if (empty($fechaBaja)) {
                            $fechaBaja = NULL;
                        }
                        
                        $aRegistros = [
                            ':CodDepartamento' => $codDepartamento,
                            ':DescDepartamento' => $descDepartamento,
                            ':FechaCreacionDepartamento' => $fechaCreacionDepartamento,
                            ':VolumenNegocio' => $volumenNegocio,
                            ':FechaBaja' => $fechaBaja
                        ];
                        
                        if (!$resultadoconsultaInsercion->execute($aRegistros)) {
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

                        // Creamos una tabla en la que mostraremos la tabla de la BD
                        echo ("<div class='list-group text-center'>");
                        echo ("<table>
                                        <thead>
                                        <tr>
                                            <th>Codigo de Departamento</th>
                                            <th>Descripcion de Departamento</th>
                                            <th>Fecha de Creacion</th>
                                            <th>Volumen de Negocio</th>
                                            <th>Fecha de Baja</th>
                                        </tr>
                                        </thead>");

                        /* Aqui recorremos todos los valores de la tabla, columna por columna, usando el parametro 'PDO::FETCH_ASSOC' , 
                         * el cual nos indica que los resultados deben ser devueltos como un array asociativo, donde los nombres de las columnas de 
                         * la tabla se utilizan como claves (keys) en el array.
                         */
                        echo ("<tbody>");
                        while ($oDepartamento = $resultadoConsultaPreparada->fetchObject()) {
                            echo ("<tr>");
                            echo ("<td>" . $oDepartamento->CodDepartamento . "</td>");
                            echo ("<td>" . $oDepartamento->DescDepartamento . "</td>");
                            echo ("<td>" . $oDepartamento->FechaCreacionDepartamento . "</td>");
                            echo ("<td>" . $oDepartamento->VolumenNegocio . "</td>");
                            echo ("<td>" . $oDepartamento->FechaBaja . "</td>");
                            echo ("</tr>");
                        }

                        echo ("</tbody>");
                        /* Ahora usamos la función 'rowCount()' que nos devuelve el número de filas afectadas por la consulta y 
                         * almacenamos el valor en la variable '$numeroDeRegistros'
                         */
                        $numeroDeRegistrosConsultaPreparada = $resultadoConsultaPreparada->rowCount();
                        // Y mostramos el número de registros
                        echo ("<tfoot ><tr style='background-color: #666; color:white;'><td colspan='5'>Número de registros en la tabla Departamento: " . $numeroDeRegistrosConsultaPreparada . '</td></tr></tfoot>');
                        echo ("</table>");
                        echo ("</div>");
                    }

                    //Controlamos las excepciones mediante la clase PDOException
                } catch (PDOException $miExcepcionPDO) {
                    /**
                     * Revierte o deshace los cambios
                     * Esto solo se usara si estamos usando consultas preparadas
                     */
                    $miDB->rollback();

                    //Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
                    $errorExcepcion = $miExcepcionPDO->getCode();

                    // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'
                    $mensajeExcepcion = $miExcepcionPDO->getMessage();

                    // Mostramos el mensaje de la excepción
                    echo "<span style='color: red'>Error: </span>" . $mensajeExcepcion . "<br>";

                    // Mostramos el código de la excepción
                    echo "<span style='color: red'>Código del error: </span>" . $errorExcepcion;

                    //En culaquier cosa cerramos la sesion
                } finally {
                    // El metodo unset sirve para cerrar la sesion con la base de datos
                    unset($miDB);
                }
            ?>
        </main>
        <footer>
            <p>2023-2024 © Todos los derechos reservados. <a href="../indexProyectoTema4.php">Erika Martínez Pérez</a></p>
        </footer>
    </body>
</html>