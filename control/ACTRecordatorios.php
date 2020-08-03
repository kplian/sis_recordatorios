<?php
/****************************************************************************************
 * @package pXP
 * @file ACTRecordatorios.php
 * @author  (valvarado)
 * @date 16-06-2020 15:28:32
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 *
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                16-06-2020 15:28:32    valvarado             Creacion
 * #
 *****************************************************************************************/

class ACTRecordatorios extends ACTbase
{

    function listarRecordatorios()
    {
        $this->objParam->defecto('ordenacion', 'id_recordatorio');

        $this->objParam->defecto('dir_ordenacion', 'asc');
        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODRecordatorios', 'listarRecordatorios');
        } else {
            $this->objFunc = $this->create('MODRecordatorios');

            $this->res = $this->objFunc->listarRecordatorios($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarRecordatorios()
    {
        $this->objFunc = $this->create('MODRecordatorios');
        if ($this->objParam->insertar('id_recordatorio')) {
            $this->res = $this->objFunc->insertarRecordatorios($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarRecordatorios($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarRecordatorios()
    {
        $this->objFunc = $this->create('MODRecordatorios');
        $this->res = $this->objFunc->eliminarRecordatorios($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function cambiarEstado()
    {
        $this->objFunc = $this->create('MODRecordatorios');
        $this->res = $this->objFunc->modificarEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

}

?>