<?php
/****************************************************************************************
 * @package pXP
 * @file ACTDestinatarios.php
 * @author  (valvarado)
 * @date 16-06-2020 15:35:08
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 *
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                16-06-2020 15:35:08    valvarado             Creacion
 * #
 *****************************************************************************************/

define('FOTOS', dirname(__DIR__) . '/imagenes');
define('TEMPLATE_PATH', dirname(__DIR__) . '/plantillas');
include_once(dirname(__FILE__) . '/../../lib/PHPMailer/class.phpmailer.php');
include_once(dirname(__FILE__) . '/../../lib/PHPMailer/class.smtp.php');
include_once(dirname(__FILE__) . '/../../lib/lib_general/cls_correo_externo.php');
require_once(dirname(__FILE__) . '/../lib/Loader.php');
require_once dirname(__FILE__) . '/../lib/Envio.php';
require_once dirname(__FILE__) . '/../lib/Tarjeta.php';
class ACTDestinatarios extends ACTbase
{

    function listarDestinatarios()
    {
        $this->objParam->defecto('ordenacion', 'ci');

        $this->objParam->defecto('dir_ordenacion', 'asc');
        if ($this->objParam->getParametro('id_recordatorio') != '') {
            $this->objParam->addFiltro("des.id_recordatorio = ''" . $this->objParam->getParametro('id_recordatorio') . "''");
        }
        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODDestinatarios', 'listarDestinatarios');
        } else {
            $this->objFunc = $this->create('MODDestinatarios');

            $this->res = $this->objFunc->listarDestinatarios($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarDestinatarios()
    {
        $this->objFunc = $this->create('MODDestinatarios');
        if ($this->objParam->insertar('ci')) {
            $this->res = $this->objFunc->insertarDestinatarios($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarDestinatarios($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarDestinatarios()
    {
        $this->objFunc = $this->create('MODDestinatarios');
        $this->res = $this->objFunc->eliminarDestinatarios($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }


    function sincronizar()
    {
        $this->objParam->defecto('ordenacion', 'id_recordatorio');
        $this->objParam->defecto('dir_ordenacion', 'asc');
        $this->objFunc = $this->create('MODDestinatarios');
        $this->res = $this->objFunc->sincronizar($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function enviar()
    {
        $id_recordatorio = $this->objParam->getParametro('id_recordatorio');
        $ci = $this->objParam->getParametro('ci');
        $this->objParam->defecto('ordenacion', 'id_recordatorio');
        $this->objParam->defecto('dir_ordenacion', 'asc');
        $this->objParam->addFiltro(" des.ci = ''".$ci."'' AND des.id_recordatorio = ''" . $id_recordatorio . "''");
        $this->objFunc = $this->create('MODDestinatarios');
        $this->res = $this->objFunc->listarDestinatarios($this->objParam);
        if ($this->res->getTipo() == 'EXITO' && count($this->res->getDatos()) > 0) {
            $datosEnvio = $this->res->getDatos();
            foreach ($datosEnvio as $item) {
                $tarjeta = new Tarjeta($item);
                $envio = new Envio();
                $envio->usarEstrategia($tarjeta);
                $datos [] = $envio->ejecutar();
            }
        }

        $mensajeExito = new Mensaje();
        $mensajeExito->setMensaje('EXITO', 'ACTEnvioGenerico.php', 'Proceso ejecutado', '', '', '', '', '');
        $this->res = $mensajeExito;
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function preview()
    {
        $id_recordatorio = $this->objParam->getParametro('id_recordatorio');
        $ci = $this->objParam->getParametro('ci');
        $this->objParam->defecto('ordenacion', 'id_recordatorio');
        $this->objParam->defecto('dir_ordenacion', 'asc');
        $this->objParam->defecto('cantidad', 1);
        $this->objParam->defecto('puntero', 0);

        $this->objParam->addFiltro(" des.ci = ''".$ci."'' AND des.id_recordatorio = ''" . $id_recordatorio . "''");
        $this->objFunc = $this->create('MODDestinatarios');
        $this->res = $this->objFunc->listarDestinatarios($this->objParam);
        if ($this->res->getTipo() == 'EXITO' && count($this->res->getDatos()) > 0) {
            $datosEnvio = $this->res->getDatos();
            $tarjeta = new Tarjeta($datosEnvio[0]);
            echo $tarjeta->preview();
        }
    }
}

?>