CREATE OR REPLACE FUNCTION "rec"."ft_recordatorios_ime"(p_administrador integer, p_id_usuario integer,
                                                        p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:        Recordatorios
 FUNCION:         rec.ft_recordatorios_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'rec.trecordatorios'
 AUTOR:          (valvarado)
 FECHA:            16-06-2020 15:28:32
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                16-06-2020 15:28:32    valvarado             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento INTEGER;
    v_parametros        RECORD;
    v_id_requerimiento  INTEGER;
    v_resp              VARCHAR;
    v_nombre_funcion    TEXT;
    v_mensaje_error     TEXT;
    v_id_recordatorio   INTEGER;
    v_codigo            VARCHAR;
BEGIN

    v_nombre_funcion = 'rec.ft_recordatorios_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'REC_REC_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        valvarado    
     #FECHA:        16-06-2020 15:28:32
    ***********************************/

    IF (p_transaccion = 'REC_REC_INS') THEN

        BEGIN
            v_codigo = param.f_obtener_correlativo(
                    'REC',
                    null,-- par_id,
                    NULL, --id_uo
                    NULL, -- id_depto
                    1,
                    'REC',
                    null
                );
            --Sentencia de la insercion
            INSERT INTO rec.trecordatorios(estado_reg,
                                           codigo,
                                           nombre,
                                           forzar_dia_habil,
                                           ruta_plantilla,
                                           ruta_script,
                                           estado,
                                           id_usuario_reg,
                                           fecha_reg,
                                           id_usuario_ai,
                                           usuario_ai,
                                           id_usuario_mod,
                                           fecha_mod)
            VALUES ('activo',
                    v_codigo,
                    v_parametros.nombre,
                    v_parametros.forzar_dia_habil,
                    v_parametros.ruta_plantilla,
                    v_parametros.ruta_script,
                    v_parametros.estado,
                    p_id_usuario,
                    now(),
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    null,
                    null)
            RETURNING id_recordatorio into v_id_recordatorio;

            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                        'Recordatorios almacenado(a) con exito (id_recordatorio' || v_id_recordatorio ||
                                        ')');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_recordatorio', v_id_recordatorio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'REC_REC_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 15:28:32
        ***********************************/

    ELSIF (p_transaccion = 'REC_REC_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE rec.trecordatorios
            SET nombre           = v_parametros.nombre,
                forzar_dia_habil = v_parametros.forzar_dia_habil,
                ruta_plantilla   = v_parametros.ruta_plantilla,
                ruta_script      = v_parametros.ruta_script,
                estado           = v_parametros.estado,
                id_usuario_mod   = p_id_usuario,
                fecha_mod        = now(),
                id_usuario_ai    = v_parametros._id_usuario_ai,
                usuario_ai       = v_parametros._nombre_usuario_ai
            WHERE id_recordatorio = v_parametros.id_recordatorio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Recordatorios modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_recordatorio', v_parametros.id_recordatorio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'REC_REC_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 15:28:32
        ***********************************/

    ELSIF (p_transaccion = 'REC_REC_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE
            FROM rec.trecordatorios
            WHERE id_recordatorio = v_parametros.id_recordatorio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Recordatorios eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_recordatorio', v_parametros.id_recordatorio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;
        /*********************************
           #TRANSACCION:  'REC_REC_MODEST'
           #DESCRIPCION:    Modificacion de Estados
           #AUTOR:        valvarado
           #FECHA:        16-06-2020 15:28:32
          ***********************************/

    ELSIF (p_transaccion = 'REC_REC_MODEST') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE rec.trecordatorios
            SET estado         = v_parametros.estado,
                id_usuario_mod = p_id_usuario,
                fecha_mod      = now(),
                id_usuario_ai  = v_parametros._id_usuario_ai,
                usuario_ai     = v_parametros._nombre_usuario_ai
            WHERE id_recordatorio = v_parametros.id_recordatorio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Recordatorios modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_recordatorio', v_parametros.id_recordatorio::varchar);

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
ALTER FUNCTION "rec"."ft_recordatorios_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
