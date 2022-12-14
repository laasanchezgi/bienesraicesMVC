<?php

    namespace Model;

    class Propiedad extends ActiveRecord {
        protected static $tabla = 'propiedades';
        protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

        // Estas variables deben coincidir exactamente con las columnas de la base de datos
        public $id;
        public $titulo;
        public $precio;
        public $imagen;
        public $descripcion;
        public $habitaciones;
        public $wc;
        public $estacionamiento;
        public $creado;
        public $vendedores_id;

        // Constructor
        public function __construct($args = [])
        {
            // A todo lo public se le hace referencia con $this
            $this->id = $args['id'] ?? null;
            $this->titulo = $args['titulo'] ?? '';
            $this->precio = $args['precio'] ?? '';
            $this->imagen = $args['imagen'] ?? '';
            $this->descripcion = $args['descripcion'] ?? '';
            $this->habitaciones = $args['habitaciones'] ?? '';
            $this->wc = $args['wc'] ?? '';
            $this->estacionamiento = $args['estacionamiento'] ?? '';
            $this->creado = date('Y/m/d');
            $this->vendedores_id = $args['vendedores_id'] ?? '';
        }

        public function validar() {

            // Evitar que se inserten valores faltantes a la base de datos
            if (!$this->titulo) {
                self::$errores[] = "Debes añadir un titulo";
            }
            if (!$this->precio) {
                self::$errores[] = "El precio es obligatorio";
            }
    
            if (strlen($this->descripcion)<50) {
                self::$errores[] = "La descripción es obligatoria";
            }
    
            if (!$this->habitaciones) {
                self::$errores[] = "El número de habitaciones es obligatorio";
            }
    
            if (!$this->wc) {
                self::$errores[] = "El número de baños es obligatorio";
            }
    
            if (!$this->estacionamiento) {
                self::$errores[] = "El número de estacionamientos es obligatorio";
            }
    
            if (!$this->vendedores_id) {
                self::$errores[] = "El vendedor es obligatorio";
            }

            if (!$this->imagen) {
                self::$errores[] = "La imagen es obligatoria";
            }

            return self::$errores;
        }
    } 