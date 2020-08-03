<?php
/****************************************************************************************
 * @package pXP
 * @file MODEnvios.php
 * @author  (valvarado)
 * @date 16-06-2020 18:58:53
 * @description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 *
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                16-06-2020 18:58:53    valvarado             Creacion
 * #
 *****************************************************************************************/

class MODEnvios extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarEnvios()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'rec.ft_envios_sel';
        $this->transaccion = 'REC_DETENV_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_envio', 'int4');
        $this->captura('estado_reg', 'varchar');
        $this->captura('ci', 'varchar');
        $this->captura('estado', 'varchar');
        $this->captura('fecha_envio_original', 'date');
        $this->captura('fecha_envio_forzado', 'date');
        $this->captura('id_recordatorio', 'int4');
        $this->captura('id_usuario_reg', 'int4');
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('id_usuario_ai', 'int4');
        $this->captura('usuario_ai', 'varchar');
        $this->captura('id_usuario_mod', 'int4');
        $this->captura('fecha_mod', 'timestamp');
        $this->captura('emails', 'varchar');
        $this->captura('usr_reg', 'varchar');
        $this->captura('usr_mod', 'varchar');
        $this->captura('nombre', 'varchar');
        $this->captura('apellido_paterno', 'varchar');
        $this->captura('apellido_materno', 'varchar');
        $this->captura('nombre_archivo_foto', 'text');
        $this->captura('fecha_nacimiento', 'date');
        $this->captura('ruta_plantilla', 'varchar');
        $this->captura('ruta_script', 'varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarEnvios()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'rec.ft_envios_ime';
        $this->transaccion = 'REC_DETENV_INS';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('ci', 'ci', 'int4');
        $this->setParametro('estado', 'estado', 'int4');
        $this->setParametro('fecha_envio', 'fecha_envio', 'timestamp');
        $this->setParametro('id_recordatorio', 'id_recordatorio', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function modificarEnvios()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'rec.ft_envios_ime';
        $this->transaccion = 'REC_DETENV_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_envio', 'id_envio', 'int4');
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('ci', 'ci', 'int4');
        $this->setParametro('estado', 'estado', 'int4');
        $this->setParametro('fecha_envio', 'fecha_envio', 'timestamp');
        $this->setParametro('id_recordatorio', 'id_recordatorio', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function eliminarEnvios()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'rec.ft_envios_ime';
        $this->transaccion = 'REC_DETENV_ELI';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_envio', 'id_envio', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
}

?>