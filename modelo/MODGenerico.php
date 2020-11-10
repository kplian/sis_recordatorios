<?php
/**
 * @package pXP
 * @file MODAperturasDigitales.php
 * @author  (valvarado)
 * @date 20-04-2020 22:13:29
 * @description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                20-04-2020 22:13:29                                CREACION
 */

class MODGenerico extends MODbase
{
    public function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }
    function listarDestinatarios()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'rec.ft_destinatarios_sel';
        $this->transaccion = 'REC_DES_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion
        $this->tipo_conexion = 'seguridad';
        $this->setCount(false);
        $this->resetCaptura();
        $this->addConsulta();
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
        $this->captura('imagen_predeterminada', 'varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function listarEnvios()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'rec.ft_envios_sel';
        $this->transaccion = 'REC_DETENV_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion
        $this->tipo_conexion = 'seguridad';
        $this->setCount(false);
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
        $this->procedimiento = 'rec.ft_envios_ime';
        $this->transaccion = 'REC_ENV_REG';
        $this->tipo_procedimiento = 'IME';
        $this->tipo_conexion = 'seguridad';
        $this->setParametro('lista_envios', 'lista_envios', 'text');

        $this->armarConsulta();
        $this->ejecutarConsulta();

        return $this->respuesta;

    }

    function sincronizar()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'rec.ft_destinatarios_ime';
        $this->transaccion = 'REC_DETENV_REG';
        $this->tipo_procedimiento = 'IME';
        $this->tipo_conexion = 'seguridad';
        //Define los parametros para la funcion
//        $this->setParametro('id_recordatorio', 'id_recordatorio', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
}

?>