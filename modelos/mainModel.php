<?php
    // Verificamos que haya una petición ajax
    if($peticionAjax){
        // Si existe, entonces  salimos uno atras entramos en la carpeta ajax e incluimos el archivo de la configuracioin del servidor
        require_once ("../config/SERVER.php");
    }else{
        // caso contrario, entonces  entramos a la carpeta config e incluimos
        require_once ("./config/SERVER.php");
    }
    class mainModel{
        // Método o funcion para conectar a la base de datos
        protected static function conectar(){
            $conexion = new PDO(SGBD, USER, PASS);
            $conexion->exec("SET CHARACTER SET utf8");
            return $conexion;
        }
        // funcion o metodos para consultas simples
        protected static function ejecutarConsultaSimple($consulta){
            $sql = self::conectar()->prepare($consulta);
            $sql->execute();
            return $sql;
        }
    }
