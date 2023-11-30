<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/webroot/css/style.css">
        <title>Erika Martínez Pérez - DWES</title>
    </head>
    <body>
        <header>
            <h1>TEMA 4: TÉCNICAS DE ACCESO A DATOS EN PHP</h1>
        </header>
        <table>
            <tr>
                <th>Script BD</th>
                <th>Codigo</th>
            </tr>
            <tr>
                <td>CreaDB202DWESProyectoTema4.sql</td>
                <td><a href="mostrarcodigo/muestraEjercicioSQL00.php">Visualizar</a></td>
            </tr>
            <tr>
                <td>CargaInicialDB202DWESProyectoTema4.sql</td>
                <td><a href="mostrarcodigo/muestraEjercicioSQL01.php">Visualizar</a></td>
            </tr>
            <tr>
                <td>BorraDB202DWESProyectoTema4.sql</td>
                <td><a href="mostrarcodigo/muestraEjercicioSQL02.php">Visualizar</a></td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Nº</th>
                <th>Ejercicios del tema 4</th>
                <th>Ejecutar PDO</th>
                <th>Código PDO</th>
                <th>Ejecutar MySQLi</th>
                <th>Código MySQLi</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Conexión a la base de datos con la cuenta usuario y tratamiento de errores.</td>
                <td><a href="codigoPHP/ejercicio00.php">Ejecutar</a></td>
                <td><a href="mostrarcodigo/muestraEjercicio00.php">Visualizar</a></td>
                <td><a href="codigoPHP/ejercicio00.php"></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio00.php"></a></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Mostrar el contenido de la tabla Departamento y el número de registros.</td>
                <td><a href="codigoPHP/ejercicio01.php">Ejecutar</a></td>
                <td><a href="mostrarcodigo/muestraEjercicio01.php">Visualizar</a></td>
                <td><a href="codigoPHP/ejercicio01.php"></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio01.php"></a></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.</td>
                <td><a href="codigoPHP/ejercicio02.php">Ejecutar</a></td>
                <td><a href="mostrarcodigo/muestraEjercicio02.php">Visualizar</a></td>
                <td><a href="codigoPHP/ejercicio02.php"></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio02.php"></a></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).</td>
                <td><a href="codigoPHP/ejercicio03.php">Ejercutar</a></td>
                <td><a href="mostrarcodigo/muestraEjercicio03.php">Visualizar</a></td>
                <td><a href="codigoPHP/ejercicio03.php"></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio03.php"></a></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.</td>
                <td><a href="codigoPHP/ejercicio04.php">Ejercutar</a></td>
                <td><a href="mostrarcodigo/muestraEjercicio04.php">Visualizar</a></td>
                <td><a href="codigoPHP/ejercicio04.php"></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio04.php"></a></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada.</td>
                <td><a href="codigoPHP/ejercicio05.php">Ejecutar</a></td>
                <td><a href="mostrarcodigo/muestraEjercicio05.php">Visualizar</a></td>
                <td><a href="codigoPHP/ejercicio05.php"></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio05.php"></a></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla Departamento de nuestra base de datos. (IMPORTAR). El fichero importado se encuentra en el directorio .../tmp/ del servidor.</td>
                <td><a href="codigoPHP/ejercicio06.php">Ejecutar</a></td>
                <td><a href="mostrarcodigo/muestraEjercicio06.php">Visualizar</a></td>
                <td><a href="codigoPHP/ejercicio06.php"></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio06.php"></a></td>
            </tr>
            <tr>
                <td>8</td>
                <td>Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se encuentra en el directorio .../tmp/ del servidor.</td>
                <td><a href="codigoPHP/ejercicio07.php">Ejecutar</a></td>
                <td><a href="mostrarcodigo/muestraEjercicio07.php">Visualizar</a></td>
                <td><a href="codigoPHP/ejercicio07.php"></a></td>
                <td><a href="mostrarcodigo/muestraEjercicio07.php"></a></td>
            </tr>
        </table>
    </body>
</html>