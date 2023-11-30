/**
 * Author:  Erika Martínez Pérez
 * Created: 31 oct 2023
 */

-- Borrado de la base de datos
drop database if exists DB202DWESProyectoTema4;
-- Creacion de la base de datos
create database if not exists DB202DWESProyectoTema4;
-- Uso de de la base de datos
use DB202DWESProyectoTema4;

-- Creacion de la tabla Departamento 
create table Departamento (
    CodDepartamento varchar(3) primary key,  
    DescDepartamento varchar(255),
    FechaCreacionDepartamento datetime,
    VolumenNegocio float,
    FechaBaja datetime
)engine=innodb;

-- Creación del usuario 
create user 'user202DWESProyectoTema4'@'%' identified by 'paso';
-- Comando para darle permisos al usuario sobre la base de datos
grant all privileges on DB202DWESProyectoTema4.* to 'user202DWESProyectoTema4'@'%';