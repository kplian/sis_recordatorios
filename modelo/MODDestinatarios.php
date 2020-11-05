<?php
/****************************************************************************************
 * @package pXP
 * @file MODDestinatarios.php
 * @author  (valvarado)
 * @date 16-06-2020 15:35:08
 * @description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 *
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                16-06-2020 15:35:08    valvarado             Creacion
 * #
 *****************************************************************************************/

class MODDestinatarios extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarDestinatarios()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'rec.ft_destinatarios_sel';
        $this->transaccion = 'REC_DES_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_recordatorio', 'int4');
        $this->captura('estado_reg', 'varchar');
        $this->captura('ci', 'varchar');
        $this->captura('nombres', 'varchar');
        $this->captura('apellido_paterno', 'varchar');
        $this->captura('apellido_materno', 'varchar');
        $this->captura('emails', 'varchar');
        $this->captura('estado', 'varchar');
        $this->captura('id_usuario_reg', 'int4');
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('id_usuario_ai', 'int4');
        $this->captura('usuario_ai', 'varchar');
        $this->captura('id_usuario_mod', 'int4');
        $this->captura('fecha_mod', 'timestamp');
        $this->captura('usr_reg', 'varchar');
        $this->captura('usr_mod', 'varchar');
        $this->captura('fecha_envio_original', 'date');
        $this->captura('fecha_envio_forzado', 'date');
        $this->captura('dia', 'int4');
        $this->captura('mes', 'int4');
        $this->captura('anio', 'int4');
        $this->captura('campos_extra', 'json');
        $this->captura('nombre_archivo_foto', 'text');
        $this->captura('fecha_nacimiento', 'date');
        $this->captura('ruta_plantilla', 'varchar');
        $this->captura('ruta_script', 'varchar');
        $this->captura('sobrenombre', 'varchar');
        $this->captura('cualidad_1', 'varchar');
        $this->captura('cualidad_2', 'varchar');
        $this->captura('genero', 'varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarDestinatarios()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'rec.ft_destinatarios_ime';
        $this->transaccion = 'REC_DES_INS';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('id_recordatorio', 'id_recordatorio', 'int4');
        $this->setParametro('ci', 'ci', 'varchar');
        $this->setParametro('nombres', 'nombres', 'varchar');
        $this->setParametro('apellido_paterno', 'apellido_paterno', 'varchar');
        $this->setParametro('apellido_materno', 'apellido_materno', 'varchar');
        $this->setParametro('nickname', 'nickname', 'varchar');
        $this->setParametro('emails', 'emails', 'varchar');
        $this->setParametro('ruta_imagen', 'ruta_imagen', 'varchar');
        $this->setParametro('cantidad_envios', 'cantidad_envios', 'int4');
        $this->setParametro('estado', 'estado', 'varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function modificarDestinatarios()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'rec.ft_destinatarios_ime';
        $this->transaccion = 'REC_DES_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('id_recordatorio', 'id_recordatorio', 'int4');
        $this->setParametro('ci', 'ci', 'varchar');
        $this->setParametro('nombres', 'nombres', 'varchar');
        $this->setParametro('apellido_paterno', 'apellido_paterno', 'varchar');
        $this->setParametro('apellido_materno', 'apellido_materno', 'varchar');
        $this->setParametro('nickname', 'nickname', 'varchar');
        $this->setParametro('emails', 'emails', 'varchar');
        $this->setParametro('ruta_imagen', 'ruta_imagen', 'varchar');
        $this->setParametro('cantidad_envios', 'cantidad_envios', 'int4');
        $this->setParametro('estado', 'estado', 'varchar');
        $this->setParametro('fecha_envio_original', 'fecha_envio_original', 'date');
        $this->setParametro('fecha_envio_forzado', 'fecha_envio_forzado', 'date');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function eliminarDestinatarios()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'rec.ft_destinatarios_ime';
        $this->transaccion = 'REC_DES_ELI';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('ci', 'ci', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function sincronizar()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'rec.ft_destinatarios_ime';
        $this->transaccion = 'REC_DETENV_REG';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_recordatorio', 'id_recordatorio', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function enviar()
    {
        $plantillas = array('tarjeta_1.tpl', 'tarjeta_2.tpl', 'tarjeta_3.tpl');
        $params[] = array(
            'bg_img' => TEMPLATE_PATH . '/img/bg-1.jpg',
            'bg_img_url' => 'https://i.ibb.co/sFc7s90/bg-1.jpg',
            'logo' => TEMPLATE_PATH . '/img/logo.png'
        );
        $params[] = array(
            'bg_img' => TEMPLATE_PATH . '/img/bg-3.jpg',
            'bg_img_url' => 'https://i.ibb.co/sFc7s90/bg-3.jpg',
            'logo' => TEMPLATE_PATH . '/img/logo-white.png'
        );
        $params[] = array(
            'bg_img' => TEMPLATE_PATH . '/img/bg-4.jpg',
            'bg_img_url' => 'https://i.ibb.co/sFc7s90/bg-4.jpg',
            'logo' => TEMPLATE_PATH . '/img/logo-white.png'
        );
        $posicion = rand(0, 2);
        $seleccionado = $params[$posicion];
        $datos = array();
        $this->objParam->defecto('ordenacion', 'id_recordatorio');
        $this->objParam->defecto('dir_ordenacion', 'asc');
//        $this->objParam->addFiltro(" detenv.id_recordatorio = ''" . $this->objParam->getParametro('id_recordatorio') . "'' AND detenv.fecha_envio = ''".date('Y-m-d')."''");
        $this->objParam->addFiltro(" detenv.id_recordatorio = ''" . $this->objParam->getParametro('id_recordatorio') . "'' AND detenv.fecha_envio = ''2020-07-01''");
        $this->objFunc = $this->create('MODGenerico');
        $this->res = $this->objFunc->listarEnvios($this->objParam);
        if ($this->res->getTipo() == 'EXITO' && count($this->res->getDatos()) > 0) {
            $datosEnvio = $this->res->getDatos();
            foreach ($datosEnvio as $item) {
                $birtdayCard = new Template(TEMPLATE_PATH . '/' . $plantillas[$posicion]);
                foreach ($item as $key => $value) {
                    $birtdayCard->set($key, $value);
                }
                $birtdayCard->set('foto', FOTOS . '/' . $item['ruta_imagen']);
                $birtdayCard->set('bg_img', $seleccionado['bg_img']);
                $birtdayCard->set('bg_img_url', $seleccionado['bg_img_url']);
                $birtdayCard->set('logo', $seleccionado['logo']);
                $uTimezone = new DateTimeZone('America/La_Paz');
                $date_final = new DateTime($item['fecha_nacimiento']);
                $date_final->setTimeZone($uTimezone);
                setlocale(LC_TIME, 'es_ES.UTF-8');
                $birtdayCard->set('fecha_nacimiento', strftime("%d de %B", $date_final->getTimestamp()));
                $header = new Header();
                $footer = new Footer();
                $container = new Container($header, $footer, $birtdayCard);
                $card = new MasterLayout($container);
                $contenido = $card->output();
                $correo = new CorreoExterno();
                $correo->addDestinatario($item['emails'], $item['nombres']);
                $correo->setAsunto('Feliz Cumpleaños');
                $correo->setMensajeHtml($contenido);
                $correo->setMensaje($contenido);
                $status = $correo->enviarCorreo();
                $datos [] = array(
                    'id_recordatorio' => $this->objParam->getParametro('id_recordatorio'),
                    'ci' => $item['ci'],
                    'estado' => $status,
                );

            }
        }
        $mensajeExito = new Mensaje();
        $mensajeExito->setMensaje('EXITO', 'ACTEnvioMasivo.php', 'Proceso ejecutado', '', '', '', '', '');
        $this->res = $mensajeExito;
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}

?>