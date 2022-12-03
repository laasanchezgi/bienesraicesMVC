<?php 

    namespace Controllers;
    use MVC\Router;
    use Model\Propiedad;
    use PHPMailer\PHPMailer\PHPMailer;

    class PaginasController {

        public static function index(Router $router) {

            $propiedades = Propiedad::get(3);

            $inicio = true;

            $router->render('paginas/index', [
                'propiedades' => $propiedades,
                'inicio' => $inicio
            ]);
        }

        public static function nosotros(Router $router) {
            $router->render('paginas/nosotros', []);
        }

        public static function propiedades(Router $router) {
            $propiedades = Propiedad::all();
            $router->render('paginas/propiedades', [
               'propiedades' => $propiedades
            ]);
        }

        public static function propiedad(Router $router) {
            $id = validar_redireccionar('/propiedades');

            // Buscar la propiedad por si id
            $propiedad = Propiedad::find($id);

            $router->render('paginas/propiedad', [
                'propiedad' => $propiedad
            ]);
        }

        public static function blog(Router $router) {
            $router->render('paginas/blog', []);
        }

        public static function entrada(Router $router) {
            $router->render('paginas/entrada', []);
        }

        public static function contacto(Router $router) {

            $mensaje = null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //Respuestas
                $respuestas = $_POST['contacto'];

                // Crear una instancia de PHPMailer
                $mail = new PHPMailer();

                // Configurar STMP (Protocolo para envio de correos) (Datos para poder enviar el email, utilizando el servicio de mailtrap)
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = '96e4a64d61af4b';
                $mail->Password = '46524a3b5d2a77';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 2525;

                // Configurar el contenido del mail
                // Donde se envian
                $mail->setFrom('admin@bienesraices.com');
                // Quien lo envian
                $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
                // Asunto
                $mail->Subject = 'Tienes un nuevo mensaje';

                // Habilitar HTML (Se define el HTML, para poder usar etiquetas html dentro del email)
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';

                // Definir contenido
                $contenido = '<html>';
                $contenido .=  '<p> Tienes un nuevo mensaje </p> </html>';
                $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';

                // Enviar de forma condicional algunos campos de email o telefono
                if ($respuestas['contacto'] === 'telefono') {
                    
                    $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . '</p>';
                    $contenido .= '<p>Fecha de contacto: ' . $respuestas['fecha'] . '</p>';
                    $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
                } else {
                    // Email
                    $contenido .= '<p> Eligío ser contactado por email: </p>';
                    $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
                }
                
                
                $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
                $contenido .= '<p>Vende o compra: ' . $respuestas['tipo'] . '</p>';
                $contenido .= '<p>Precio o presupuesto: $ ' . $respuestas['precio'] . '</p>';
                $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . '</p>';
                $contenido .= '</html>';


                $mail->Body = $contenido;
                $mail->AltBody = 'Esto es texto alternativo sin HTML';

                // Enviar el email (Se revisa si se envia correctamente o si no se puede enviar)
                if ($mail->send()) {
                    $mensaje = "Mensaje enviado correctamente";
                } else {
                    $mensaje = "El mensaje no se pudo enviar...";
                }
            }
            $router->render('paginas/contacto', [
                'mensaje' => $mensaje
            ]);
        }
    }