CREATE OR REPLACE FUNCTION "rec"."ft_destinatarios_ime"(p_administrador integer, p_id_usuario integer,
                                                        p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:        Recordatorios
 FUNCION:         rec.ft_destinatarios_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'rec.tdestinatarios'
 AUTOR:          (valvarado)
 FECHA:            16-06-2020 15:35:08
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                16-06-2020 15:35:08    valvarado             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento INTEGER;
    v_parametros        RECORD;
    v_id_requerimiento  INTEGER;
    v_resp              VARCHAR;
    v_nombre_funcion    TEXT;
    v_mensaje_error     TEXT;
    v_ci                INTEGER;
    v_files_json        json;
    v_file              record;
    v_file_json         json;
    v_funcionario       record;
    v_filename          varchar;
    v_recodatorio       record;
    v_registro          record;
BEGIN

    v_nombre_funcion = 'rec.ft_destinatarios_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'REC_DES_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        valvarado
     #FECHA:        16-06-2020 15:35:08
    ***********************************/

    IF (p_transaccion = 'REC_DES_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO rec.tdestinatarios(estado_reg,
                                           id_recordatorio,
                                           ci,
                                           nombres,
                                           apellido_paterno,
                                           apellido_materno,
                                           emails,
                                           estado,
                                           id_usuario_reg,
                                           fecha_reg,
                                           id_usuario_ai,
                                           usuario_ai,
                                           id_usuario_mod,
                                           fecha_mod)
            VALUES ('activo',
                    v_parametros.id_recordatorio,
                    v_parametros.ci,
                    v_parametros.nombres,
                    v_parametros.apellido_paterno,
                    v_parametros.apellido_materno,
                    v_parametros.nickname,
                    v_parametros.emails,
                    v_parametros.ruta_imagen,
                    v_parametros.cantidad_envios,
                    v_parametros.estado,
                    p_id_usuario,
                    now(),
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    null,
                    null)
            RETURNING ci into v_ci;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                        'Destinatarios almacenado(a) con exito (ci' || v_ci ||
                                        ')');
            v_resp = pxp.f_agrega_clave(v_resp, 'ci', v_ci::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'REC_DES_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 15:35:08
        ***********************************/

    ELSIF (p_transaccion = 'REC_DES_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE rec.tdestinatarios
            SET id_recordatorio  = v_parametros.id_recordatorio,
                ci               = v_parametros.ci,
                nombres          = v_parametros.nombres,
                apellido_paterno = v_parametros.apellido_paterno,
                apellido_materno = v_parametros.apellido_materno,
                emails           = v_parametros.emails,
                estado           = v_parametros.estado,
                id_usuario_mod   = p_id_usuario,
                fecha_mod        = now(),
                id_usuario_ai    = v_parametros._id_usuario_ai,
                usuario_ai       = v_parametros._nombre_usuario_ai
            WHERE ci = v_parametros.ci;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Destinatarios modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'ci', v_parametros.ci::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'REC_DES_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 15:35:08
        ***********************************/

    ELSIF (p_transaccion = 'REC_DES_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE
            FROM rec.tdestinatarios
            WHERE ci = v_parametros.ci;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Destinatarios eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'ci', v_parametros.ci::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;
        /*********************************
                #TRANSACCION:  'REC_DETENV_REG'
                #DESCRIPCION:    Registro de programacion de envios
                #AUTOR:        valvarado
                #FECHA:        16-06-2020 15:28:32
               ***********************************/

    ELSIF (p_transaccion = 'REC_DETENV_REG') THEN

        BEGIN
            --Sentencia de la eliminacion
            select *
            into v_recodatorio
            from rec.trecordatorios reco
            where reco.id_recordatorio = v_parametros.id_recordatorio;

            for v_registro in execute 'select * FROM ' || v_recodatorio.ruta_script
                LOOP
                    if v_registro.ci is not null then
                        INSERT INTO rec.tdestinatarios(estado_reg,
                                                       ci,
                                                       estado,
                                                       fecha_envio_original,
                                                       fecha_envio_forzado,
                                                       id_recordatorio,
                                                       id_usuario_reg,
                                                       fecha_reg,
                                                       id_usuario_ai,
                                                       usuario_ai,
                                                       id_usuario_mod,
                                                       fecha_mod,
                                                       emails,
                                                       dia,
                                                       mes,
                                                       anio,
                                                       nombres,
                                                       apellido_paterno,
                                                       apellido_materno)
                        VALUES ('activo',
                                v_registro.ci,
                                '',
                                v_registro.fecha_envio_original,
                                v_registro.fecha_envio_forzado,
                                v_recodatorio.id_recordatorio,
                                p_id_usuario,
                                now(),
                                v_parametros._id_usuario_ai,
                                v_parametros._nombre_usuario_ai,
                                null,
                                null,
                                v_registro.emails,
                                v_registro.dia,
                                v_registro.mes,
                                v_registro.anio,
                                v_registro.nombres,
                                v_registro.apellido_paterno,
                                v_registro.apellido_materno)
                        on conflict on constraint tdestinatarios_pk
                            do update set fecha_envio_original = v_registro.fecha_envio_original,
                                          fecha_envio_forzado  = v_registro.fecha_envio_forzado,
                                          emails               = v_registro.emails,
                                          dia                  = v_registro.dia,
                                          mes                  = v_registro.mes,
                                          anio                 = v_registro.anio,
                                          nombres              = v_registro.nombres,
                                          apellido_paterno     = v_registro.apellido_paterno,
                                          apellido_materno     = v_registro.apellido_materno;
                    end if;
                end loop;
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Recordatorios eliminado(a)');
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
ALTER FUNCTION "rec"."ft_destinatarios_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
