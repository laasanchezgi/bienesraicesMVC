<?php

    namespace Controllers;
    use MVC\Router;
    use Model\Vendedor;

    class VendedorController {
        // Crear
        public static function crear (Router $router) {
            $errores = Vendedor::getErrores();
            $vendedor = new Vendedor;

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Crea una nueva instancia 
                $vendedor = new Vendedor($_POST['vendedor']);
                // Validar
                $errores = $vendedor->validar();
                // Si no hay errores, guardar vendedor en la BD
                if(empty($errores)) {
                    $vendedor->guardar();
                }
            }

            $router->render('vendedores/crear', [
                'errores' => $errores,
                'vendedor' => $vendedor
            ]);
        }

        // Actualizar
        public static function actualizar (Router $router) {
            $id = validar_redireccionar('/admin');
            $vendedor = Vendedor::find($id);
            $errores = Vendedor::getErrores();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Asignar los valores
                $args = $_POST['vendedor'];
                // Sincronizar objeto en memoria con lo que el usuario escribió
                $vendedor->sincronizar($args);
                // Validación
                $errores = $vendedor->validar();
                // Si no hay errores, guardar 
                if (empty($errores)) {
                    $vendedor->guardar();
                }
            }

            $router->render ('vendedores/actualizar', [
                'errores' => $errores,
                'vendedor' => $vendedor
            ]);
        }

        // Eliminar
        public static function eliminar () {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Validad id
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if ($id) {
                    $tipo = $_POST['tipo'];
                    if (validarTipoContenido($tipo)) {
                        $vendedor = Vendedor::find($id);
                        $vendedor->eliminar();
                    }
                }
            }
        }
    }
