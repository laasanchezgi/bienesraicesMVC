<?php
    namespace MVC;

    class Router {

        public $rutasGET = [];
        public $rutasPOST = [];

        // url's que reaccionan a un metodo GET
        public function get ($url, $fn) {
            $this->rutasGET[$url] = $fn;
        }

        // url's que reaccionan a un metodo POST
        public function post ($url, $fn) {
            $this->rutasPOST[$url] = $fn;
        }

        public function comprobarRutas() {

            session_start();
            $auth = $_SESSION['login'];

            // Arreglo de rutas protegidas
            $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

            $urlActual = $_SERVER['PATH_INFO'] ?? '/';
            $metodo = $_SERVER['REQUEST_METHOD'];

            if ($metodo === 'GET') {
                $fn = $this->rutasGET[$urlActual] ?? null;
            } else {
                $fn = $this->rutasPOST[$urlActual] ?? null;
            }

            // Proteger las rutas
            if (in_array($urlActual, $rutas_protegidas) && !$auth) {
                header ('Location: /');
            }


            if ($fn) {
                // La url existe y hay una función asociada
                // call_user_func() --> Es una funcione que permite llamar a una función cuando no sabemos como se llama esa función
                call_user_func($fn, $this);
            } else {
                echo "Pagina NO encontrada";
            }
        }

        // Muestra una vista
        public function render ($view, $datos = []) {
            // No se sabe el nombre de cada una de las llaves del arreglo asociativos
            // Este codigo itera y genera variables con el nombre de las llaves del arreglo asociativo que se le esta pasando hacia la vista
            // $$: variable de variable, mantiene el nombre, pero no pierde el valor
            foreach ($datos as $key => $value) {
                $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
            }
            // Inicia un almacenamineto en memoria
            ob_start();
            // Se le ingresa dinámicamente las vistas
            include __DIR__ . "/views/$view.php";
            // Limpia la memoria (Para que el servidor NO colapse)
            $contenido = ob_get_clean();
            // Incluir el layout
            include __DIR__ . "/views/layout.php";
        }

    }