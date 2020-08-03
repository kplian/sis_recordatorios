<?php
/****************************************************************************************
*@package pXP
*@file ACTEnvios.php
*@author  (valvarado)
*@date 16-06-2020 18:58:53
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                16-06-2020 18:58:53    valvarado             Creacion    
  #
*****************************************************************************************/

class ACTEnvios extends ACTbase{    
            
    function listarEnvios(){
		$this->objParam->defecto('ordenacion','id_envio');
        if ($this->objParam->getParametro('id_recordatorio') != '') {
            $this->objParam->addFiltro("detenv.id_recordatorio = ''" . $this->objParam->getParametro('id_recordatorio') . "''");
        }
        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEnvios','listarEnvios');
        } else{
        	$this->objFunc=$this->create('MODEnvios');
            
        	$this->res=$this->objFunc->listarEnvios($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarEnvios(){
        $this->objFunc=$this->create('MODEnvios');    
        if($this->objParam->insertar('id_envio')){
            $this->res=$this->objFunc->insertarEnvios($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarEnvios($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarEnvios(){
        	$this->objFunc=$this->create('MODEnvios');    
        $this->res=$this->objFunc->eliminarEnvios($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}

?>