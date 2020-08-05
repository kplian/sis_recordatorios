<?php
/**
 * @package pXP
 * @file ACTAperturasDigitales.php
 * @author  (valvarado)
 * @date 17-06-2020 22:13:29
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                20-04-2020 22:13:29                                CREACION
 */
define('FOTOS', dirname(__DIR__) . '/imagenes');
define('TEMPLATE_PATH', dirname(__DIR__) . '/plantillas');
include_once(dirname(__FILE__) . '/../../lib/PHPMailer/class.phpmailer.php');
include_once(dirname(__FILE__) . '/../../lib/PHPMailer/class.smtp.php');
include_once(dirname(__FILE__) . '/../../lib/lib_general/cls_correo_externo.php');
require_once(dirname(__FILE__) . '/../lib/Loader.php');
require_once dirname(__FILE__) . '/../lib/Envio.php';
require_once dirname(__FILE__) . '/../lib/Tarjeta.php';

class ACTGenerico extends ACTbase
{

    function enviar()
    {
        $this->objParam->defecto('ordenacion', 'id_recordatorio');
        $this->objParam->defecto('dir_ordenacion', 'asc');
        $this->objParam->defecto('cantidad', 100000);
        $this->objParam->defecto('puntero', 0);
        $mes = date('m');
        $dia = date('d');
        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        $this->objParam->addFiltro(" reco.estado = ''Ejecutando'' AND des.fecha_envio_forzado is null  AND des.mes = ''" . $mes . "'' AND des.dia  = ''" . $dia . "''");
        $this->objFunc = $this->create('MODGenerico');

        $this->res = $this->objFunc->listarDestinatarios($this->objParam);
        if ($this->res->getTipo() == 'EXITO' && count($this->res->getDatos()) > 0) {
            $datosDestinatario = $this->res->getDatos();
            foreach ($datosDestinatario as $item) {
                $tarjeta = new Tarjeta($item);
                $envio = new Envio();
                $envio->usarEstrategia($tarjeta);
                $status = $envio->ejecutar();
                $datos [] = array(
                    'id_recordatorio' => (string)$item['id_recordatorio'],
                    'ci' => (string)$item['ci'],
                    'fecha_envio_original' => $item['fecha_envio_original'],
                    'fecha_envio_forzado' => $item['fecha_envio_forzado'],
                    'dia' => (string)$item['dia'],
                    'mes' => (string)$item['mes'],
                    'anio' => (string)$item['anio'],
                    'estado' => (string)$status,
                    'emails' => (string)$item['emails']);
            }
        }
        $json = json_encode($datos);
        $this->objParam->addParametro('lista_envios', $json);
        $this->objFunc = $this->create('MODGenerico');
        $this->res = $this->objFunc->insertarEnvios($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }


    function enviar_forzados()
    {
        $this->objParam->defecto('ordenacion', 'id_recordatorio');
        $this->objParam->defecto('dir_ordenacion', 'asc');
        $this->objParam->defecto('cantidad', 100000);
        $this->objParam->defecto('puntero', 0);
        $mes = date('m');
        $dia = date('d');
        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        $this->objParam->addFiltro(" reco.estado = ''Ejecutando'' AND des.fecha_envio_forzado is not null  AND des.mes = ''" . $mes . "'' AND des.dia  = ''" . $dia . "''");
        $this->objFunc = $this->create('MODGenerico');

        $this->res = $this->objFunc->listarDestinatarios($this->objParam);
        if ($this->res->getTipo() == 'EXITO' && count($this->res->getDatos()) > 0) {
            $datosDestinatario = $this->res->getDatos();
            foreach ($datosDestinatario as $item) {
                $tarjeta = new Tarjeta($item);
                $envio = new Envio();
                $envio->usarEstrategia($tarjeta);
                $status = $envio->ejecutar();
                $datos [] = array(
                    'id_recordatorio' => (string)$item['id_recordatorio'],
                    'ci' => (string)$item['ci'],
                    'fecha_envio_original' => $item['fecha_envio_original'],
                    'fecha_envio_forzado' => $item['fecha_envio_forzado'],
                    'dia' => (string)$item['dia'],
                    'mes' => (string)$item['mes'],
                    'anio' => (string)$item['anio'],
                    'estado' => (string)$status,
                    'emails' => (string)$item['emails']);
            }
        }
        $json = json_encode($datos);
        $this->objParam->addParametro('lista_envios', $json);
        $this->objFunc = $this->create('MODGenerico');
        $this->res = $this->objFunc->insertarEnvios($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function sincronizar()
    {
        $this->objFunc = $this->create('MODGenerico');
        $this->res = $this->objFunc->sincronizar($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}

?>