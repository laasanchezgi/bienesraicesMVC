<?php

    namespace Model;

    class Vendedor extends ActiveRecord {
        protected static $tabla = 'vendedores';
        protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

        // Estas variables deben coincidir exactamente con las columnas de la base de datos
        public $id;
        public $nombre;
        public $apellido;
        public $telefono;

        // Constructor
        public function __construct($args = [])
        {
            // A todo lo public se le hace referencia con $this
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->apellido = $args['apellido'] ?? '';
            $this->telefono = $args['telefono'] ?? '';
        }

        // Validación
        public function validar() {
            if (!$this->nombre) {
                self::$errores[] = "El nombre es obligatorio";
            }
            if (!$this->apellido) {
                self::$errores[] = "El apellido es obligatorio";
            }
            if (!$this->telefono) {
                self::$errores[] = "El teléfono es obligatorio";
            }
            // Expresión regular --> Es una forma de buscar un patron dentro de un texto
            if (!preg_match('/[0-9]{10}/', $this->telefono)) {
                self::$errores[] = "Formato no válido";
            }

            return self::$errores;
        }
    } 