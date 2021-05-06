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
        // Método para encriptar o hashear
        public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
        }
        // Método para Desencriptar o volver al estado original
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
        }
        // Método para generar códigos aleatorios
        protected static function generarCodigoAleatorio($letra, $longitud, $numero){
            for($i=1; $i<=$longitud; $i++){
                $aletorio = rand(0,9);
                $letra.=$aletorio;
            }
            return $letra.="-".$numero;
        }
        //Función o metodo para limpiar cadeanas
        protected static function limpiarCadena($cadena){
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);
            $cadena = str_ireplace("<script>", "",$cadena);
            $cadena = str_ireplace("/<script>", "",$cadena);
            $cadena = str_ireplace("<script src", "",$cadena);
            $cadena = str_ireplace("<script type=", "",$cadena);
            $cadena = str_ireplace("SELECT * FROM", "",$cadena);
            $cadena = str_ireplace("DELETE FROM", "",$cadena);
            $cadena = str_ireplace("INSERT INTO", "",$cadena);
            $cadena = str_ireplace("DROP TABLE", "",$cadena);
            $cadena = str_ireplace("DROP DATABASE", "",$cadena);
            $cadena = str_ireplace("TRUNCATE TABLE", "",$cadena);
            $cadena = str_ireplace("SHOW TABLES", "",$cadena);
            $cadena = str_ireplace("SHOW DATABASES", "",$cadena);
            $cadena = str_ireplace("<?php", "",$cadena);
            $cadena = str_ireplace("?>", "",$cadena);
            $cadena = str_ireplace("--", "",$cadena);
            $cadena = str_ireplace(">", "",$cadena);
            $cadena = str_ireplace("<", "",$cadena);
            $cadena = str_ireplace("[", "",$cadena);
            $cadena = str_ireplace("]", "",$cadena);
            $cadena = str_ireplace("^", "",$cadena);
            $cadena = str_ireplace("==", "",$cadena);
            $cadena = str_ireplace(";", "",$cadena);
            $cadena = str_ireplace("::", "",$cadena);
            $cadena = stripslashes($cadena);
            $cadena = trim($cadena);
            return $cadena;
        }
    }
