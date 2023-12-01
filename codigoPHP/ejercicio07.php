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
            <h1>8. Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se encuentra en el directorio .../tmp/ del servidor.</h1>
        </header>
        <main>
            <?php
                /**
                 * @author Alvaro Cordero Miñambres 
                 * Adaptado por @author Erika Martínez Pérez
                 * @version 1.0
                 * @since 18/11/2023
                 */
                
                require_once '../config/configDB.php';
                
                // Declaro una variable de entrada para mostrar o no la tabla con los valores de la BD
                $entradaOK = true;

                //Abro un bloque try catch para tener un mayor control de los errores
                try {
                    // CONEXION CON LA BD
                    /**
                     * Establecemos la conexión por medio de PDO
                     * DSN -> IP del servidor y Nombre de la base de datos
                     * USER -> Usuario con el que se conecta a la base de datos
                     * PASSWORD -> Contraseña del usuario
                     * */
                    $miDB = new PDO(dsn,usuario,password);

                    /**
                     * Modificamos los errores y añadimos los siguientes atributos de PDO
                     */
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    /**
                     * Declaracion de la consulta SQL 
                     * En este caso hacemos un select de la tabla Departamanetos
                     */
                    $sql1 = 'SELECT * FROM T02_Departamento';

                    //Preparamos la consulta que previamente vamos a ejecutar
                    $resultadoConsulta = $miDB->prepare($sql1);

                    //Ejecutamos la consulta
                    $resultadoConsulta->execute();

                    /*                 * +
                     * Mostramos el numero de registros que hemos seleccionado
                     * el metodo rowCount() devuelve el numero de filas que tiene la consulta
                     */
                    $numRegistros = $resultadoConsulta->rowCount();

                    //Mediante echo mostranmos la variable que almacena el numero de registros
                    echo ('Numero de registros: ' . $numRegistros);

                    //Guardo el primer registro como un objeto
                    $oResultado = $resultadoConsulta->fetchObject();

                    // Inicializamos un array vacío para almacenar todos los departamentos
                    $aDepartamentos = [];

                    //Inicializamos el contador
                    $numeroDepartamento = 0;
                    /**
                     * Recorro los registros que devuelve la consulta y obtengo por cada valor su resultado
                     */
                    while ($oResultado) {
                        //Guardamos los valores en un array asociativo
                        $aDepartamento = [
                            'T02_CodDepartamento' => $oResultado->T02_CodDepartamento,
                            'T02_DescDepartamento' => $oResultado->T02_DescDepartamento,
                            'T02_FechaCreacionDepartamento' => $oResultado->T02_FechaCreacionDepartamento,
                            'T02_VolumenDeNegocio' => $oResultado->T02_VolumenDeNegocio,
                            'T02_FechaBajaDepartamento' => $oResultado->T02_FechaBajaDepartamento
                        ];

                        // Añadimos el array $aDepartamento al array $aDepartamentos
                        $aDepartamentos[] = $aDepartamento;

                        //Incremento el contador de departamentos para almacenar informacion el la siguiente posicion        
                        $numeroDepartamento++;

                        //Guardo el registro actual y avanzo el puntero al siguiente registro que obtengo de la consulta
                        $oResultado = $resultadoConsulta->fetchObject();
                    }


                    /**
                     * La funcion json_encode devuelve un string con la representacion JSON
                     * Le pasamos el array aDepartamentos y utilizanos el atributo JSON_PRRETY_PRINT para que use espacios en blanco para formatear los datos devueltos.
                     */
                    $json = json_encode($aDepartamentos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    /**
                     * Mediante la funcion file_put_contents() podremos escribir informacion en un fichero
                     * Pasandole como parametros la ruta donde queresmos que se guarde y el que queremos sobrescribir
                     * JSON_UNESCAPED_UNICODE: Codifica caracteres Unicode multibyte literalmente
                     */
                    file_put_contents("../tmp/departamentos_exportar.json", $json);

                    //Mediante echo mostramos el numero de bytes escritos
                    echo ("<br>Exportado correctamente");

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