<?php
    class Conexion{
        public static function Conectar(){
            define('servidor', '172.16.206.12');
            //define('servidor', '192.168.5.3');
            define('nombre_bd', 'intranet');
            define('usuario', 'and32x');
            define('password', '');	
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
            try{
                $conexion = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, password, $opciones);
                return $conexion;
            }catch (Exception $e){
                die("El error de Conexión es: ". $e->getMessage());
            }
        }
    }
?>