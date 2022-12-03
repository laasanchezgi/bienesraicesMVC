<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Admin;
    
    class LoginController {
        public static function login(Router $router) {

            $errores = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Modelo (Crea una nueva instancia, crea un nuevo objeto y tanto email como password haran parte de dicho objeto)
                $auth = new Admin($_POST);

                // Errores
                $errores = $auth->validar();

                // Verificar el usuario, su contraseña y si es el caso autenticarlo
                if (empty($errores)) {
                    // Varificar si el usuario existe
                    $resultado =  $auth->existeUsuario();
                    if (!$resultado) {
                        $errores = Admin::getErrores();
                    } else {
                        // Verificar el password
                        $autenticado = $auth->comprobarPassword($resultado);
                        if ($autenticado) {
                            // Autenticar el usuario
                            $auth->autenticar();
                        } else {
                            // Password incorrecto (mensaje de error)
                            $errores = Admin::getErrores(); 
                        }
                    }
                }
            }

            $router->render('auth/login', [
                'errores' => $errores
            ]);
        }
        
        public static function logout() {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
    }