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
                width: 150px;
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
                margin-left: 153px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>4. Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).</h1>
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
                
                try {
                    // Establecemos la conexión con la base de datos
                    $miDB = new PDO(dsn,usuario,password);
                    // Inicializacion de variables
                    $entradaOK = true; // Inizacion de la variable que indica que todo en el formulario esta correctamente
                    $_REQUEST['date'] = date('Y-m-d'); // Inicializamos la variable global para la fehca dandole el formato para insertar
                    
                    $aErrores = [
                        'T02_DescDepartamento' => '',
                    ]; // Inicializacion del array donde recogemos los errores 
                    $aRespuestas = [
                        'T02_DescDepartamento' => '',
                    ]; // Inicializacion del array donde recogemos las respuestas

                    // Cargar valores por defecto en los campos del formulario
                    if(isset($_REQUEST['submit'])){
                        // Validacion de la entrada y actuar en consecuencia
                        $aErrores['T02_DescDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['T02_DescDepartamento'],255,0,0);
                        
                        // Foreach para recorrer el array de errores
                        foreach($aErrores as $campo => $error){
                            // Si existe algun error la entrada pasa a ser false
                            if($error != null){

                                $_REQUEST[$campo] = '';
                                $entradaOK = false;
                            }
                        }
                    } else {
                        // El formulario no se ha rellenado nunca
                        $entradaOK = false;
                    }

                    // Código que se ejecuta cuando se envía el formulario y muestra de los valores
                    if ($entradaOK){
                        // Tratamiento de datos
                        ?>
                            <h2>Formulario de búsqueda de departamento:</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" name="ejercicio03">
                                <div>
                                    <label> Búsqueda: </label>
                                    <input type="text" name="T02_DescDepartamento" value="<?php echo (isset($_REQUEST['T02_DescDepartamento']) ? $_REQUEST['T02_DescDepartamento'] : ''); ?>" size="32" placeholder="Búsqueda."><?php echo(' <span>'.$aErrores['T02_DescDepartamento'].'</span>');?>
                                    <br>
                                    <input type="submit" name="submit" value="Buscar">
                                </div>
                            </form>
                        <?php
            
                         // Se añaden al array $aRespuestas las respuestas cuando son correctas
                        $aRespuestas['T02_DescDepartamento'] = $_REQUEST['T02_DescDepartamento'];
                            
                            // Se preparan las consultas
                            $consulta = $miDB->prepare('select * from T02_Departamento where T02_DescDepartamento like "%'.$aRespuestas['T02_DescDepartamento'].'%"');
                            // Se ejecuta la consulta
                            $consulta->execute();
                            // Se crea una tabla para imprimir las tuplas
                            echo('<h2>Tabla de los departamentos: </h2>');
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
                        <h2>Formulario de búsqueda de departamento:</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" name="ejercicio03">
                            <div>
                                <label> Búsqueda: </label>
                                <input type="text" name="T02_DescDepartamento" value="<?php echo (isset($_REQUEST['T02_DescDepartamento']) ? $_REQUEST['T02_DescDepartamento'] : ''); ?>" size="32" placeholder="Búsqueda."><?php echo(' <span>'.$aErrores['T02_DescDepartamento'].'</span>');?>
                                <br>
                                <input type="submit" name="submit" value="Buscar">
                            </div>
                        </form>
                        <?php
                    
                        $consulta = $miDB->prepare('select * from T02_Departamento');
                        // Se ejecuta la consulta
                        $consulta->execute();
                        // Se crea una tabla para imprimir las tuplas
                        echo('<h2>Tabla de los departamentos: </h2>');
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
                    }
                    
                    unset($miDB); // Desconecion de la base de datos
                } catch (PDOException $pdoEx) { // Mostrado dell mensaje seguido del error correspondiente debido a la excepción
                    echo ("ERROR DE CONEXIÓN ".$pdoEx->getMessage());
                }
            ?>
        </main>
        <footer>
            <p>2023-2024 © Todos los derechos reservados. <a href="../indexProyectoTema4.php">Erika Martínez Pérez</a></p>
        </footer>
    </body>
</html>