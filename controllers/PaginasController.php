<?php 

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router) {
        $router->render('paginas/nosotros');
    }
    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router) {
        $id = validarORedireccionar('/propiedades');
        
        $propiedad = Propiedad::find($id);
        
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router) {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router) {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router) {

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $respuestas = $_POST['contacto'];

            //Crear una nueva instancia de PHPmailer
            $mail = new PHPMailer();

            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io'; 
            $mail->SMTPAuth =true;
            $mail->Username = '07ad8501e0acb0';
            $mail->Password = '9bfcd842e7d36d';
            $mail->SMTPSecure = 'tls';
            $mail->Port =2525;

            //Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            //Habilitar HTML
            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';
            
            //Definir el contenido 
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje </p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre']  . '</p>';

            //Enviar de forma condicional algunos campos de email o telefono
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligio ser contactado por Telefono:</p>';
                $contenido .= '<p>Teléfono: ' . $respuestas['telefono']  . '</p>';
                $contenido .= '<p>Fecha contacto: ' . $respuestas['fecha']  . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora']  . '</p>';
            }else {
                //Es email, entonces agregamos el campo de email
                $contenido .= '<p>Eligio ser contactado por Email:</p>';
                $contenido .= '<p>E-Mail: ' . $respuestas['email']  . '</p>';
            }

            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje']  . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo']  . '</p>';
            $contenido .= '<p>Precio: $' . $respuestas['precio']  . '</p>';
            $contenido .= '<p>Contacto: ' . $respuestas['contacto']  . '</p>';

            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML'; 

            //Enviar el Email
            if($mail->send()){
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}