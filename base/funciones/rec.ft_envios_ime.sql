CREATE OR REPLACE FUNCTION "rec"."ft_envios_ime"(p_administrador integer, p_id_usuario integer,
                                                 p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:        Recordatorios
 FUNCION:         rec.ft_envios_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'rec.tenvios'
 AUTOR:          (valvarado)
 FECHA:            16-06-2020 18:58:53
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                16-06-2020 18:58:53    valvarado             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento    INTEGER;
    v_parametros           RECORD;
    v_id_requerimiento     INTEGER;
    v_resp                 VARCHAR;
    v_nombre_funcion       TEXT;
    v_mensaje_error        TEXT;
    v_id_envio             INTEGER;
    v_registros            record;
    v_fecha_actual         date;
    v_registro             record;
    v_recodatorio          record;
    v_fecha_envio          date;
    v_envios               json;
    v_envio                record;
    v_envio_obj            varchar;
    v_id_recordatorio      integer;
    v_ci                   varchar;
    v_fecha_envio_original date;
    v_fecha_envio_forzado  date;
    v_dia                  integer ;
    v_mes                  integer;
    v_anio                 integer;
    v_estado               varchar;
    v_emails               varchar;
BEGIN

    v_nombre_funcion = 'rec.ft_envios_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'REC_DETENV_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        valvarado
     #FECHA:        16-06-2020 18:58:53
    ***********************************/

    IF (p_transaccion = 'REC_DETENV_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO rec.tenvios(estado_reg,
                                    ci,
                                    estado,
                                    fecha_envio_original,
                                    id_recordatorio,
                                    id_usuario_reg,
                                    fecha_reg,
                                    id_usuario_ai,
                                    usuario_ai,
                                    id_usuario_mod,
                                    fecha_mod)
            VALUES ('activo',
                    v_parametros.ci,
                    v_parametros.estado,
                    v_parametros.fecha_envio,
                    v_parametros.id_recordatorio,
                    p_id_usuario,
                    now(),
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    null,
                    null)
            RETURNING id_envio into v_id_envio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                        'Detalle Envios almacenado(a) con exito (id_envio' || v_id_envio || ')');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_envio', v_id_envio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'REC_DETENV_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 18:58:53
        ***********************************/

    ELSIF (p_transaccion = 'REC_DETENV_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE rec.tenvios
            SET ci                   = v_parametros.ci,
                estado               = v_parametros.estado,
                fecha_envio_original = v_parametros.fecha_envio,
                id_recordatorio      = v_parametros.id_recordatorio,
                id_usuario_mod       = p_id_usuario,
                fecha_mod            = now(),
                id_usuario_ai        = v_parametros._id_usuario_ai,
                usuario_ai           = v_parametros._nombre_usuario_ai
            WHERE id_envio = v_parametros.id_envio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Detalle Envios modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_envio', v_parametros.id_envio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'REC_DETENV_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 18:58:53
        ***********************************/

    ELSIF (p_transaccion = 'REC_DETENV_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE
            FROM rec.tenvios
            WHERE id_envio = v_parametros.id_envio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Detalle Envios eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_envio', v_parametros.id_envio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;
        /*********************************
              #TRANSACCION:  'ENV_DETENV_REG'
              #DESCRIPCION:    Registro de envios realizados
              #AUTOR:        valvarado
              #FECHA:        16-06-2020 15:28:32
             ***********************************/

    ELSIF (p_transaccion = 'REC_ENV_REG') THEN

        BEGIN

            v_envios = v_parametros.lista_envios::json;
            for v_envio in (select json_array_elements(v_envios))
                loop
                    ---asignamos valores alas varibles

                    v_envio_obj = v_envio.json_array_elements::json;
                    v_id_recordatorio = v_envio_obj::JSON ->> 'id_recordatorio';
                    v_ci = v_envio_obj::JSON ->> 'ci';
                    v_fecha_envio_original = v_envio_obj::JSON ->> 'fecha_envio_original';
                    v_fecha_envio_forzado = coalesce(v_envio_obj::JSON ->> 'fecha_envio_forzado', NULL);
                    v_dia = v_envio_obj::JSON ->> 'dia';
                    v_mes = v_envio_obj::JSON ->> 'mes';
                    v_anio = v_envio_obj::JSON ->> 'anio';
                    v_estado = v_envio_obj::JSON ->> 'estado';
                    v_emails = v_envio_obj::JSON ->> 'emails';
                    insert into rec.tenvios (id_recordatorio,
                                             ci,
                                             fecha_envio_original,
                                             fecha_envio_forzado,
                                             dia,
                                             mes,
                                             anio,
                                             estado,
                                             emails,
                                             estado_reg,
                                             id_usuario_reg,
                                             fecha_reg,
                                             id_usuario_ai,
                                             usuario_ai,
                                             id_usuario_mod,
                                             fecha_mod)
                    values (v_id_recordatorio,
                            v_ci,
                            v_fecha_envio_original,
                            v_fecha_envio_forzado,
                            v_dia,
                            v_mes,
                            v_anio,
                            v_estado,
                            v_emails,
                            'activo',
                            p_id_usuario,
                            now(),
                            v_parametros._id_usuario_ai,
                            v_parametros._nombre_usuario_ai,
                            null,
                            null);
                end loop;
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Recordatorios eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_recordatorio', 0::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;
    ELSE

        RAISE EXCEPTION 'Transaccion inexistente: %',p_transaccion;

    END IF;

EXCEPTION

    WHEN OTHERS THEN
        v_resp = '';
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp, 'codigo_error', SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp, 'procedimientos', v_nombre_funcion);
        raise exception '%',v_resp;

END;
$BODY$
    LANGUAGE 'plpgsql' VOLATILE
                       COST 100;
ALTER FUNCTION "rec"."ft_envios_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
