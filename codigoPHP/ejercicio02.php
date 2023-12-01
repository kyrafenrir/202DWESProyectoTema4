<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../webroot/css/style.css">
        <title>DWES</title>
        <style>
            *{
                box-sizing: border-box;
            }
            
            main {
                padding-left: 10px;
            }
            
            label{
                display: inline-block;
                width: 300px;
                text-align: right;
            }
            
            input{
                display: inline-block;
                margin-bottom: 6px;
                width: 300px;
            }
            
            span{
                display: inline-block;
                width: 700px;
            }
            
            input:last-child{
                width: 100px;
                margin-left: 300px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>3. Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.</h1>
        </header>
        <main>
            <?php
                /**
                * Author:  Erika Martínez Pérez
                * Created: 07/11/2023
                */
            
                // Utilizacion de la libreria de validacion donde se incluyen los metodos de validacion de las entradas del formulario
                require_once '../core/231018libreriaValidacion.php';
                require_once '../config/configDB.php';
                
                $_REQUEST['T02_FechaCreacionDepartamento'] = date('Y-m-d / H:i:s'); // Inicializamos la variable global para la fehca dandole el formato para insertar

                $aErrores = [
                    'T02_CodDepartamento' => '',
                    'T02_DescDepartamento' => '',
                    'T02_FechaCreacionDepartamento' => '',
                    'T02_VolumenDeNegocio' => '',
                    'T02_FechaBajaDepartamento' => '',
                ]; // Inicializacion del array donde recogemos los errores 
                $aRespuestas = [
                    'T02_CodDepartamento' => '',
                    'T02_DescDepartamento' => '',
                    'T02_FechaCreacionDepartamento' => '',
                    'T02_VolumenDeNegocio' => '',
                    'T02_FechaBajaDepartamento' => '',
                ]; // Inicializacion del array donde recogemos las respuestas
                // Cargar valores por defecto en los campos del formulario
                if (isset($_REQUEST['submit'])) {
                    // Validacion de la entrada y actuar en consecuencia
                    $aErrores['T02_CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['T02_CodDepartamento'], 3, 3, 1);

                    try {
                        // Establecemos la conexión con la base de datos
                        $miDB = new PDO(dsn,usuario,password);
                        // Inicializacion de variables
                        $entradaOK = true; // Inizacion de la variable que indica que todo en el formulario esta correctamente
                        // Momento de insercción en tabla
                        $consultaCodComprobacion = 'select T02_CodDepartamento from T02_Departamento where T02_CodDepartamento="' . $_REQUEST['T02_CodDepartamento'] . '"';

                        // Consulta preparada
                        $resultadoConsultaCodComprobacion = $miDB->prepare($consultaCodComprobacion);
                        // Se ejecuta la consulta
                        $resultadoConsultaCodComprobacion->execute();

                        $departamentoExiste = $resultadoConsultaCodComprobacion->fetchObject();

                        unset($miDB); // Desconecion de la base de datos
                    } catch (PDOException $pdoEx) { // Mostrado dell mensaje seguido del error correspondiente debido a la excepción
                        echo ("ERROR DE CONEXIÓN " . $pdoEx->getMessage());
                    }

                    $aErrores['T02_DescDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['T02_DescDepartamento'], 255, 8, 1);
                    $aErrores['T02_VolumenDeNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['T02_VolumenDeNegocio'], 1000000000, 0, 1);

                    // Comprobación de error
                    if ($departamentoExiste) {
                        $aErrores['T02_CodDepartamento'] = "Código de departamento introducido ya es existente.";
                    }

                    // Foreach para recorrer el array de errores
                    foreach ($aErrores as $campo => $error) {
                        // Si existe algun error la entrada pasa a ser false
                        if ($error != null) {

                            $_REQUEST[$campo] = '';
                            $entradaOK = false;
                        }
                    }
                } else {
                    // El formulario no se ha rellenado nunca
                    $entradaOK = false;
                }

                // Código que se ejecuta cuando se envía el formulario y muestra de los valores
                if ($entradaOK) {
                    // Tratamiento de datos
                    echo "<h2>Datos del nuevo departamento:</h2>";
                    echo "Codigo de departamento: " . $_REQUEST['T02_CodDepartamento'] . "<br>";
                    echo "Descripción del departamento: " . $_REQUEST['T02_DescDepartamento'] . "<br>";
                    echo "Fecha de creación: " . $_REQUEST['T02_FechaCreacionDepartamento'] . "<br>";
                    echo "Volumen de negocio: " . $_REQUEST['T02_VolumenDeNegocio'] . "<br>";
                    echo "Fecha de baja: " . $aRespuestas['T02_FechaBajaDepartamento'] . "<br><br>";

                    // Se añaden al array $aRespuestas las respuestas cuando son correctas
                    $aRespuestas['T02_CodDepartamento'] = $_REQUEST['T02_CodDepartamento'];
                    $aRespuestas['T02_DescDepartamento'] = $_REQUEST['T02_DescDepartamento'];
                    $aRespuestas['T02_FechaCreacionDepartamento'] = $_REQUEST['T02_FechaCreacionDepartamento'];
                    $aRespuestas['T02_VolumenDeNegocio'] = $_REQUEST['T02_VolumenDeNegocio'];
                    $aRespuestas['T02_FechaBajaDepartamento'] = 'null';

                    try {
                        // Establecemos la conexión con la base de datos
                        $miDB = new PDO(dsn,usuario,password);
                        
                        // Momento de insercción en tabla
                        $consulta = 'insert into T02_Departamento values ("' . $aRespuestas['T02_CodDepartamento'] . '","' . $aRespuestas['T02_DescDepartamento'] . '","' . $aRespuestas['T02_FechaCreacionDepartamento']. '",' . $aRespuestas['T02_VolumenDeNegocio'] . ',' . $aRespuestas['T02_FechaBajaDepartamento'] . ');';

                        // Consulta preparada
                        $resultadoConsulta = $miDB->prepare($consulta);

                        // Ejecutando la declaración SQL
                        if ($resultadoConsulta->execute()) {
                            echo "Los datos se han insertado correctamente en la tabla Departamento.";
                        } else {
                            echo "Hubo un error al insertar los datos en la tabla Departamento.";
                        }

                        // Se preparan las consultas
                        $consulta = $miDB->prepare('select * from T02_Departamento');
                        // Se ejecuta la consulta
                        $consulta->execute();

                        unset($miDB); // Desconecion de la base de datos
                    } catch (PDOException $pdoEx) { // Mostrado dell mensaje seguido del error correspondiente debido a la excepción
                        echo ("ERROR DE CONEXIÓN " . $pdoEx->getMessage());
                    }

                    // Se crea una tabla para imprimir las tuplas
                    echo('<h2>Tabla de los departamentos actualizados: </h2>');
                    echo('<table><tr><th>Código</th><th>Descripción</th><th>Fecha de creación</th><th>Volumen</th><th>Fecha de baja</th></tr>');
                    while($oDepartamento = $consulta->fetchObject()){// TAMBIEN SE PUEDE REALIZAR CON fetch(PDO::FETCH_OBJ)
                        echo('<tr>');
                        echo('<td>'.$oDepartamento->T02_CodDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->T02_DescDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->T02_FechaCreacionDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->T02_VolumenDeNegocio.'</td>');
                        echo('<td>'.$oDepartamento->T02_FechaBajaDepartamento.'</td>');
                        echo('</tr>');
                    }
                    echo('</table><br>');
                    echo('</div><br><br>');

                    // Código que se ejecuta antes de rellenar el formulario y muestra el formulario
                } else {
                    // Mostrar el formuilario hasta que rellenemos correctamente
                        ?>
                            <h2>Formulario de nuevo departamento:</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="ejercicio02">
                                <div>
                                    <label> Siglas del departamento: </label>
                                    <input type="text" name="T02_CodDepartamento" value="<?php echo (isset($_REQUEST['T02_CodDepartamento']) ? $_REQUEST['T02_CodDepartamento'] : ''); ?>" size="32" placeholder="Las siglas del departamento."><?php echo(' <span>' . $aErrores['T02_CodDepartamento'] . '</span>'); ?>
                                    <br>
                                    <label> Descripción del departamento: </label>
                                    <input type="text" name="T02_DescDepartamento" value="<?php echo (isset($_REQUEST['T02_DescDepartamento']) ? $_REQUEST['T02_DescDepartamento'] : ''); ?>" size="32" placeholder="Descripción del departamento."><?php echo(' <span>' . $aErrores['T02_DescDepartamento'] . '</span>'); ?>
                                    <br>
                                    <label> Fecha de creación: </label>
                                    <input type="text" name="T02_FechaCreacionDepartamento" value="<?php echo $_REQUEST['T02_FechaCreacionDepartamento']; ?>" size="32" disabled><?php echo(' <span>' . $aErrores['T02_FechaCreacionDepartamento'] . '</span>'); ?>
                                    <br>
                                    <label> Volumen de negocio: </label>
                                    <input type="text" name="T02_VolumenDeNegocio" value="<?php echo (isset($_REQUEST['T02_VolumenDeNegocio']) ? $_REQUEST['T02_VolumenDeNegocio'] : ''); ?>" size="32" placeholder="Indica el volumen."><?php echo(' <span>' . $aErrores['T02_VolumenDeNegocio'] . '</span>'); ?>
                                    <br>
                                    <label> Fecha de baja: </label>
                                    <input type="text" name="T02_FechaBajaDepartamento" value="<?php echo (isset($_REQUEST['T02_FechaBajaDepartamento']) ? $_REQUEST['T02_FechaBajaDepartamento'] : ''); ?>" size="32" placeholder="YYYY-MM-DD" disabled><?php echo(' <span>' . $aErrores['T02_FechaBajaDepartamento'] . '</span>'); ?>
                                    <br><br>
                                    <input type="submit" name="submit" value="Enviar datos">
                                </div>
                            </form>
                    <?php
                }
            ?>
        </main>
        <footer>
            <p>2023-2024 © Todos los derechos reservados. <a href="../indexProyectoTema4.php">Erika Martínez Pérez</a></p>
        </footer>
    </body>
</html>