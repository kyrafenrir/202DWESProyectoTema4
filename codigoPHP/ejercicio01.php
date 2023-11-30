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
            <h1>2. Mostrar el contenido de la tabla Departamento y el número de registros.</h1>
        </header>
        <main>
            <?php
                /**
                * Author:  Erika Martínez Pérez
                * Created: 06/11/2023
                */
                
                require_once '../config/confDB.php';
                
                try {
                    // Establecemos la conexión con la base de datos
                    $miDB = new PDO(dsn,usuario,password);
                    
                    // Se preparan las consultas
                    $consulta = $miDB->prepare('select * from Departamento');
                    // Se ejecuta la consulta
                    $consulta->execute();
                    // Se almacena el numero de filas afectadas
                    $count = $consulta->rowCount();
                    // Se crea una tabla para imprimir las tuplas
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
                    // Se imprime por pantalla el array que devuelve fetchAll(PDO::FETCH_CLASS)
                    echo('Número de registros: '.$count);
                    echo('</div><br><br>');
                    
                    unset($miDB);
                } catch (PDOException $pdoEx) { // Mostrado dell mensaje seguido del error correspondiente debido a la excepción
                    echo ("ERROR DE CONEXIÓN ".$pdoEx->getMessage());
                }
                
                try {
                    // Establecemos la conexión con la base de datos
                    $miDB = new PDO(dsn,usuario,password);
                    
                    // Se preparan las consultas
                    $consulta = $miDB->query('select * from Departamento');
                    // Se almacena el numero de filas afectadas
                    $count = $consulta->rowCount();
                    // Se crea una tabla para imprimir las tuplas
                    echo('<table><tr><th>Código</th><th>Descripción</th><th>Fecha de creación</th><th>Volumen</th><th>Fecha de baja</th></tr>');
                    // Se recorre cada fila, es decir, cada departamento
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
                    // Se imprime por pantalla el array que devuelve fetchAll(PDO::FETCH_CLASS)
                    echo('Número de registros: '.$count);
                    echo('</div><br><br>');
                    
                    unset($miDB);
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