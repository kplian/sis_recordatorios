<?php
/****************************************************************************************
*@package pXP
*@file MODRecordatorios.php
*@author  (valvarado)
*@date 16-06-2020 15:28:32
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                16-06-2020 15:28:32    valvarado             Creacion    
  #
*****************************************************************************************/

class MODRecordatorios extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarRecordatorios(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='rec.ft_recordatorios_sel';
        $this->transaccion='REC_REC_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_recordatorio','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('codigo','varchar');
		$this->captura('nombre','varchar');
		$this->captura('forzar_dia_habil','varchar');
		$this->captura('ruta_plantilla','varchar');
		$this->captura('ruta_script','varchar');
		$this->captura('estado','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarRecordatorios(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='rec.ft_recordatorios_ime';
        $this->transaccion='REC_REC_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('forzar_dia_habil','forzar_dia_habil','varchar');
		$this->setParametro('ruta_plantilla','ruta_plantilla','varchar');
		$this->setParametro('ruta_script','ruta_script','varchar');
		$this->setParametro('estado','estado','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarRecordatorios(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='rec.ft_recordatorios_ime';
        $this->transaccion='REC_REC_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_recordatorio','id_recordatorio','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('forzar_dia_habil','forzar_dia_habil','varchar');
		$this->setParametro('ruta_plantilla','ruta_plantilla','varchar');
		$this->setParametro('ruta_script','ruta_script','varchar');
		$this->setParametro('estado','estado','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarRecordatorios(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='rec.ft_recordatorios_ime';
        $this->transaccion='REC_REC_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_recordatorio','id_recordatorio','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function modificarEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='rec.ft_recordatorios_ime';
        $this->transaccion='REC_REC_MODEST';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_recordatorio','id_recordatorio','int4');
        $this->setParametro('estado','estado','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
}
?>