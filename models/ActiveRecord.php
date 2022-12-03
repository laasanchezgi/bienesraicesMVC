<?php
    namespace Model;

    class ActiveRecord {
        
        // Conexión a la BD
        protected static $db;
        protected static $columnasDB = [];
        protected static $tabla = '';

        // ERRORES
        protected static $errores = [];

        // Definir la conexión a la BD
        public static function setDB($database) {
            self::$db = $database;
        }

        // Guardar para actualizar
        public function guardar() {
            if(!is_null($this->id)) {
                // actualizar
                $this->actualizar();
            } else {
                // Creando un nuevo registro
                $this->crear();
            }
        }

        // Guardar
        public function crear() {
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' "; 
            $query .= join("', '", array_values($atributos));
            $query .= " ') ";

            // Resultado de la consulta
            $resultado = self::$db->query($query);

            // Mensaje de exito
            if($resultado) {
                // Redireccionar al usuario.
                header('Location: /admin?resultado=1');
            }

        }

        // Actualizar
        public function actualizar() {
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            $valores = [];
            foreach($atributos as $key => $value) {
                $valores[] = "{$key}='{$value}'";
            }

            $query = "UPDATE " . static::$tabla ." SET ";
            $query .=  join(', ', $valores );
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
            $query .= " LIMIT 1 "; 

            $resultado = self::$db->query($query);

            if($resultado) {
                // Redireccionar al usuario.
                header('Location: /admin?resultado=2');
            }
        }

        // Eliminar un registro
        public function eliminar() {
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
            $resultado = self::$db->query($query);
            if($resultado) {
                $this->borrarImagen();
                header('location: /admin?resultado=3');
            }
        }

        // Identificar y unir los atributos de la BD
        public function atributos () {
            $atributos = [];
            foreach(static::$columnasDB as $columna) {
                // Para no tener problemas con el id, no se agrega a atributos
                if($columna === 'id') continue;
                $atributos[$columna] = $this->$columna;
            }
            return $atributos;
        }

        // Sanitizar los atributos antes de guardarlo en la BD
        public function sanitizarAtributos () {
            $atributos = $this->atributos();
            $sanitizado = [];
            foreach($atributos as $key => $value) {
                $sanitizado[$key] = self::$db->escape_string($value);
            }
            return $sanitizado;
        }

        // Subida de archivos
        public function setImagen($imagen) {
            // Elimina la imagen previa
            if(!is_null($this->id)) {
                $this->borrarImagen();
            }
            // Asignar al atributo de imagen el nombre de la imagen
            if ($imagen) {
                $this->imagen = $imagen;
            }
        }

        // Borrar imagen
        public function borrarImagen() {
            // Comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if ($existeArchivo) {
                unlink(CARPETA_IMAGENES .$this->imagen);
            }
        }

        // Validación
        public static function getErrores() {
            return static::$errores;
        }

        // Validación de los campos
        public function validar() {
            static::$errores = [];
            return static:: $errores;
        }

        // Lista todas las propiedades
        public static function all() {
            $query = "SELECT * FROM " . static::$tabla;
            $resultado = self::consultarSQL($query);
            return $resultado;
        }

        // Obtiene determinado número de registros
        public static function get ($cantidad) {
            $query = " SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
            $resultado = self::consultarSQL($query);
            return $resultado;
        }

        // Busca un registro por su id
        public static function find($id) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
            $resultado = self::consultarSQL($query);
            // array_shift es una función de php que retorna la primera posición
            return array_shift($resultado);
        }
        

        // Consultar SQL
        public static function consultarSQL($query){
            // Consultar la BD
            $resultado = self::$db->query($query);
            // Iterar los resultados
            $array = [];
            while ($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjeto($registro);
            }

            // Liberar la memoria y retornar los resultados
            $resultado->free();
            // Retornar los resultados
            return $array;
        }

        // Creando objetos a partir de los arreglos generados de la Base de datos
        protected static function crearObjeto($registro){
            $objeto = new static;
            foreach($registro as $key => $value) {
                if (property_exists($objeto, $key)) {
                    $objeto->$key = $value;
                }
            }
            return $objeto;
        } 

        // Sincroniza el objeto en memoria con los cambios realizados por el usuario
        public function sincronizar($args=[]) {
            foreach($args as $key => $value) {
                if (property_exists($this, $key) && !is_null($value)) {
                    $this->$key = $value;
                }
            }
        }
    }