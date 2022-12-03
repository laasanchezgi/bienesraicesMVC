<?php
    namespace Controllers;
    // Dependencias del proyecto
    use MVC\Router;
    use Model\Propiedad;
    use Model\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    class PropiedadController {

        public static function index(Router $router) {
            // Consulta la BD
            // Propiedades
            $propiedades = Propiedad::all();
            // Vendedores
            $vendedores = Vendedor::all();
            // Muestra mensaje condicional
            $resultado = $_GET['resultado'] ?? null;
            // []--> Arreglo asociativos, los datos hacia la vista
            $router->render('propiedades/admin', [
                // nombreKey = nombreVariable
                'propiedades' => $propiedades,
                'resultado' => $resultado,
                'vendedores' => $vendedores
            ]);
        }

        public static function crear(Router $router) {
            $propiedad = new Propiedad;
            $vendedores = Vendedor::all();
            // Arreglo con mensajes de errores
            $errores = Propiedad::getErrores();

            // Almacenar en la BD una propiedad creada a través del formulario
            if($_SERVER["REQUEST_METHOD"] === 'POST') {
                $propiedad = new Propiedad($_POST['propiedad']);
            
                // Generar un nombre unico para cada imagen que se suba
                $nombreImagen = md5(uniqid(rand(),true)) . '.jpg';
            
                // Setear la imagen
                // Realiza un resize a la imagen con intervención
                if ($_FILES['propiedad']['tmp_name']['imagen']){
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    $propiedad->setImagen($nombreImagen);
                }
            
                // Validar propiedad
                $errores = $propiedad->validar();
            
                // REVISAR que el arreglo de errores este vacio
                if (empty($errores)) {
            
                    // Crear la carpeta para subir imagenes
                    if (!is_dir(CARPETA_IMAGENES)) {
                        mkdir(CARPETA_IMAGENES);
                    }
            
                    // Guardar la imagen en el servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
            
                    // Guardar propiedad en la BD
                    $propiedad->guardar();
                }
            }

            $router->render('propiedades/crear', [
                'propiedad' => $propiedad,
                'vendedores' => $vendedores,
                'errores' => $errores
            ]);
        }

        public static function actualizar(Router $router) {
            $id = validar_redireccionar('/admin');
            $propiedad = Propiedad::find($id);
            $vendedores = Vendedor::all();
            $errores = Propiedad::getErrores();

            // Método POST para actualizar
            if($_SERVER["REQUEST_METHOD"] === 'POST') {

                // Asignar los atributos
                $args = $_POST['propiedad'];
            
                // Sincronizar
                $propiedad->sincronizar($args);
                
                // Validar
                $errores = $propiedad->validar();
            
                // Subida de archivos
                // Generar un nombre unico para cada imagen que se suba
                $nombreImagen = md5(uniqid(rand(),true)) . '.jpg';
            
                // Setear la imagen
                // Realiza un resize a la imagen con intervención
                if ($_FILES['propiedad']['tmp_name']['imagen']){
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    $propiedad->setImagen($nombreImagen);
                }
            
                // REVISAR que el arreglo de errores este vacio
                if (empty($errores)) {
                    if ($_FILES['propiedad']['tmp_name']['imagen']) {
                        // Almacenar la imagen
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                    }
                    $propiedad->guardar();
                }
            }

            $router->render('/propiedades/actualizar', [
                'propiedad' => $propiedad,
                'errores' => $errores,
                'vendedores' => $vendedores
            ]);
        }

        public static function eliminar() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Validad id
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if ($id) {
                    $tipo = $_POST['tipo'];
                    if (validarTipoContenido($tipo)) {
                        $propiedad = Propiedad::find($id);
                        $propiedad->eliminar();
                    }
                }
            }
        }
    }