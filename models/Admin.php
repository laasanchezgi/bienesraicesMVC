<?php
    namespace Model;

    class Admin extends ActiveRecord {
        // Base de datos
        protected static $tabla = 'usuarios';
        protected static $columnasDB = ['id', 'email', 'password'];

        // Variables publicas
        public $id;
        public $email;
        public $password;

        // Constructor
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->email = $args['email'] ?? '';
            $this->password = $args['password'] ?? '';
        }

        // Validar que el usuario ingreso el correo y la contraseña
        public function validar () {
            if (!$this->email) {
                self::$errores[] = 'El email es obligatorio';
            }
            if (!$this->password) {
                self::$errores[] = 'El password es obligatorio';
            }
            return self::$errores;
        }

        // Validar si el usuario existe
        public function existeUsuario () {
            $query = " SELECT * FROM " .self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
            $resultado = self::$db->query($query);
            if (!$resultado->num_rows) {
                self::$errores[] = 'El usuario no existe';
                return;
            }
            return $resultado;
        }

        // Validar password
        public function comprobarPassword($resultado) {
            $usuario = $resultado->fetch_object();
            // Función PHP (password a comparar, password en la BD)
            $autenticado = password_verify($this->password, $usuario->password);

            if (!$autenticado) {
                self::$errores[] = 'El password es incorrecto';
            }
            return $autenticado;
        }

        // Autenticar el usuario
        public function autenticar () {
            session_start();

            // Llenar el arreglo de session
            $_SESSION['usuario'] = $this->email;
            $_SESSION['login'] = true;

            header('Location: /admin');
        }
    }