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
                
                // Inicizalicación de variables de uso
                $host = '192.168.20.19'; // Nombre del servidor de la base de datos erroneo
                $namedb = 'DB202DWESProyectoTema4'; // Nombre de la base de datos
                $usuario = 'user202DWESProyectoTema4'; // Nombre de usuario de la base de datos
                $password = 'paso'; // Contraseña de la base de datos
                
                $_REQUEST['FechaCreacionDepartamento'] = date('Y-m-d / H:i:s'); // Inicializamos la variable global para la fehca dandole el formato para insertar

                $aErrores = [
                    'CodDepartamento' => '',
                    'DescDepartamento' => '',
                    'FechaCreacionDepartamento' => '',
                    'VolumenNegocio' => '',
                    'FechaBaja' => '',
                ]; // Inicializacion del array donde recogemos los errores 
                $aRespuestas = [
                    'CodDepartamento' => '',
                    'DescDepartamento' => '',
                    'FechaCreacionDepartamento' => '',
                    'VolumenNegocio' => '',
                    'FechaBaja' => '',
                ]; // Inicializacion del array donde recogemos las respuestas
                // Cargar valores por defecto en los campos del formulario
                if (isset($_REQUEST['submit'])) {
                    // Validacion de la entrada y actuar en consecuencia
                    $aErrores['CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['CodDepartamento'], 3, 3, 1);

                    try {
                        // Establecemos la conexión con la base de datos
                        $miDB = new PDO('mysql:host=' . $host . '; dbname=' . $namedb, $usuario, $password);
                        // Inicializacion de variables
                        $entradaOK = true; // Inizacion de la variable que indica que todo en el formulario esta correctamente
                        // Momento de insercción en tabla
                        $consultaCodComprobacion = 'select CodDepartamento from Departamento where CodDepartamento="' . $_REQUEST['CodDepartamento'] . '"';

                        // Consulta preparada
                        $resultadoConsultaCodComprobacion = $miDB->prepare($consultaCodComprobacion);
                        // Se ejecuta la consulta
                        $resultadoConsultaCodComprobacion->execute();

                        $departamentoExiste = $resultadoConsultaCodComprobacion->fetchObject();

                        unset($miDB); // Desconecion de la base de datos
                    } catch (PDOException $pdoEx) { // Mostrado dell mensaje seguido del error correspondiente debido a la excepción
                        echo ("ERROR DE CONEXIÓN " . $pdoEx->getMessage());
                    }

                    $aErrores['DescDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['DescDepartamento'], 255, 8, 1);
                    $aErrores['VolumenNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['VolumenNegocio'], 1000000000, 0, 1);

                    // Comprobación de error
                    if ($departamentoExiste) {
                        $aErrores['CodDepartamento'] = "Código de departamento introducido ya es existente.";
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
                    echo "Codigo de departamento: " . $_REQUEST['CodDepartamento'] . "<br>";
                    echo "Descripción del departamento: " . $_REQUEST['DescDepartamento'] . "<br>";
                    echo "Fecha de creación: " . $_REQUEST['FechaCreacionDepartamento'] . "<br>";
                    echo "Volumen de negocio: " . $_REQUEST['VolumenNegocio'] . "<br>";
                    echo "Fecha de baja: " . $aRespuestas['FechaBaja'] . "<br><br>";

                    // Se añaden al array $aRespuestas las respuestas cuando son correctas
                    $aRespuestas['CodDepartamento'] = $_REQUEST['CodDepartamento'];
                    $aRespuestas['DescDepartamento'] = $_REQUEST['DescDepartamento'];
                    $aRespuestas['FechaCreacionDepartamento'] = $_REQUEST['FechaCreacionDepartamento'];
                    $aRespuestas['VolumenNegocio'] = $_REQUEST['VolumenNegocio'];
                    $aRespuestas['FechaBaja'] = 'null';

                    try {
                        // Establecemos la conexión con la base de datos
                        $miDB = new PDO('mysql:host=' . $host . '; dbname=' . $namedb, $usuario, $password);
                        
                        // Momento de insercción en tabla
                        $consulta = 'insert into Departamento values ("' . $aRespuestas['CodDepartamento'] . '","' . $aRespuestas['DescDepartamento'] . '","' . $aRespuestas['FechaCreacionDepartamento']. '",' . $aRespuestas['VolumenNegocio'] . ',' . $aRespuestas['FechaBaja'] . ');';

                        // Consulta preparada
                        $resultadoConsulta = $miDB->prepare($consulta);

                        // Ejecutando la declaración SQL
                        if ($resultadoConsulta->execute()) {
                            echo "Los datos se han insertado correctamente en la tabla Departamento.";
                        } else {
                            echo "Hubo un error al insertar los datos en la tabla Departamento.";
                        }

                        // Se preparan las consultas
                        $consulta = $miDB->prepare('select * from Departamento');
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
                        echo('<td>'.$oDepartamento->CodDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->DescDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->FechaCreacionDepartamento.'</td>');
                        echo('<td>'.$oDepartamento->VolumenNegocio.'</td>');
                        echo('<td>'.$oDepartamento->FechaBaja.'</td>');
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
                                    <input type="text" name="CodDepartamento" value="<?php echo (isset($_REQUEST['CodDepartamento']) ? $_REQUEST['CodDepartamento'] : ''); ?>" size="32" placeholder="Las siglas del departamento."><?php echo(' <span>' . $aErrores['CodDepartamento'] . '</span>'); ?>
                                    <br>
                                    <label> Descripción del departamento: </label>
                                    <input type="text" name="DescDepartamento" value="<?php echo (isset($_REQUEST['DescDepartamento']) ? $_REQUEST['DescDepartamento'] : ''); ?>" size="32" placeholder="Descripción del departamento."><?php echo(' <span>' . $aErrores['DescDepartamento'] . '</span>'); ?>
                                    <br>
                                    <label> Fecha de creación: </label>
                                    <input type="text" name="FechaCreacionDepartamento" value="<?php echo $_REQUEST['FechaCreacionDepartamento']; ?>" size="32" disabled><?php echo(' <span>' . $aErrores['FechaCreacionDepartamento'] . '</span>'); ?>
                                    <br>
                                    <label> Volumen de negocio: </label>
                                    <input type="text" name="VolumenNegocio" value="<?php echo (isset($_REQUEST['VolumenNegocio']) ? $_REQUEST['VolumenNegocio'] : ''); ?>" size="32" placeholder="Indica el volumen."><?php echo(' <span>' . $aErrores['VolumenNegocio'] . '</span>'); ?>
                                    <br>
                                    <label> Fecha de baja: </label>
                                    <input type="text" name="FechaBaja" value="<?php echo (isset($_REQUEST['FechaBaja']) ? $_REQUEST['FechaBaja'] : ''); ?>" size="32" placeholder="YYYY-MM-DD" disabled><?php echo(' <span>' . $aErrores['FechaBaja'] . '</span>'); ?>
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