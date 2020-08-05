<?php
require_once dirname(__FILE__) . '/IEmailStrategy.php';

class Tarjeta implements IEmailStrategy
{
    var $params = array();

    public function __construct($params)
    {
        $this->params = $params;
    }

    function enviar()
    {
        $params_defecto[] = array(
            'template'=>'tarjeta_1.tpl',
            'bg_img' => TEMPLATE_PATH . '/img/bg-1.jpg',
            'bg_img_url' => 'https://i.ibb.co/sFc7s90/bg-1.jpg',
            'logo' => TEMPLATE_PATH . '/img/logo.png'
        );
        $params_defecto[] = array(
            'template'=>'tarjeta_2.tpl',
            'bg_img' => TEMPLATE_PATH . '/img/bg-3.jpg',
            'bg_img_url' => 'https://i.ibb.co/mXSPQYk/bg-3.jpg',
            'logo' => TEMPLATE_PATH . '/img/logo-white.png'
        );
        $params_defecto[] = array(
            'template'=>'tarjeta_3.tpl',
            'bg_img' => TEMPLATE_PATH . '/img/bg-4.jpg',
            'bg_img_url' => 'https://i.ibb.co/yVtKZN5/bg-4.jpg',
            'logo' => TEMPLATE_PATH . '/img/logo-white.png'
        );
        $posicion = rand(0,2);
        $seleccionado = $params_defecto[$posicion];
        $datos = array();
        if (empty($this->params['genero'])) {
            $saludo = 'Querida(o)';
        }
        if ($this->params['genero'] == 'masculino') {
            $saludo = 'Querido';
        } else {
            $saludo = 'Querida';
        }
        $tpl = new Template(TEMPLATE_PATH . '/' . $seleccionado['template']);
        foreach ($this->params as $key => $item) {
            $tpl->set($key, $item);
        }
        $tpl->set('foto', '../../'.$_SESSION['_FOLDER_FOTOS_PERSONA'].'/' . $this->params['nombre_archivo_foto']);
        $tpl->set('bg_img', $seleccionado['bg_img']);
        $tpl->set('bg_img_url', $seleccionado['bg_img_url']);
        $tpl->set('logo', $seleccionado['logo']);
        $tpl->set('saludo',$saludo);
        $uTimezone = new DateTimeZone('America/La_Paz');
        $date_final = new DateTime($this->params['fecha_nacimiento']);
        $date_final->setTimeZone($uTimezone);
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $tpl->set('fecha_nacimiento', strftime("%d de %B", $date_final->getTimestamp()));

        $header = new Header();
        $footer = new Footer();
        $container = new Container($header, $footer, $tpl);
        $card = new MasterLayout($container);
        $contenido = $card->output();

        $correo = new CorreoExterno();
        $correo->addDestinatario($this->params['emails'], $this->params['nombres']);
        $correo->addCC('endetransmisionsa@endetransmision.bo','Ende Transmision SA');
        $correo->addCC('obradeterminada@endetransmision.bo','Obra Determinada');
        $correo->setAsunto('Feliz Cumpleaños');
        $correo->setMensajeHtml($contenido);
        $correo->setMensaje($contenido);
        $status = $correo->enviarCorreo();
        return $status;
    }
    function preview()
    {
        $params_defecto[] = array(
            'template'=>'tarjeta_1.tpl',
            'bg_img' => TEMPLATE_PATH . '/img/bg-1.jpg',
            'bg_img_url' => 'https://i.ibb.co/sFc7s90/bg-1.jpg',
            'logo' => '../../../sis_recordatorios/plantillas/img/logo.png'
        );
        $params_defecto[] = array(
            'template'=>'tarjeta_2.tpl',
            'bg_img' => TEMPLATE_PATH . '/img/bg-3.jpg',
            'bg_img_url' => 'https://i.ibb.co/mXSPQYk/bg-3.jpg',
            'logo' => '../../../sis_recordatorios/plantillas/img/logo-white.png'
        );
        $params_defecto[] = array(
            'template'=>'tarjeta_3.tpl',
            'bg_img' => TEMPLATE_PATH . '/img/bg-4.jpg',
            'bg_img_url' => 'https://i.ibb.co/yVtKZN5/bg-4.jpg',
            'logo' => '../../../sis_recordatorios/plantillas/img/logo-white.png'
        );
        $posicion = rand(0,2);
        $seleccionado = $params_defecto[$posicion];
        $datos = array();
        if (empty($this->params['genero'])) {
            $saludo = 'Querida(o)';
        }
        if ($this->params['genero'] == 'masculino') {
            $saludo = 'Querido';
        } else {
            $saludo = 'Querida';
        }
        $tpl = new Template(TEMPLATE_PATH . '/' . $seleccionado['template']);
        foreach ($this->params as $key => $item) {
            $tpl->set($key, $item);
        }
        $tpl->set('foto','../../../'.$_SESSION['_FOLDER_FOTOS_PERSONA'].'/'. $this->params['nombre_archivo_foto']);
        $tpl->set('bg_img', $seleccionado['bg_img']);
        $tpl->set('bg_img_url', $seleccionado['bg_img_url']);
        $tpl->set('logo', $seleccionado['logo']);
        $tpl->set('saludo',$saludo);
        $uTimezone = new DateTimeZone('America/La_Paz');
        $date_final = new DateTime($this->params['fecha_nacimiento']);
        $date_final->setTimeZone($uTimezone);
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $tpl->set('fecha_nacimiento', strftime("%d de %B", $date_final->getTimestamp()));

        return $tpl->output();
    }
}