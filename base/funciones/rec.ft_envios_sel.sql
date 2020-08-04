CREATE OR REPLACE FUNCTION "rec"."ft_envios_sel"(p_administrador integer, p_id_usuario integer,
                                                 p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:        Recordatorios
 FUNCION:         rec.ft_envios_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'rec.tenvios'
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

    v_consulta       VARCHAR;
    v_parametros     RECORD;
    v_nombre_funcion TEXT;
    v_resp           VARCHAR;
    v_paginacion     varchar;
BEGIN

    v_nombre_funcion = 'rec.ft_envios_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'REC_DETENV_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        valvarado
     #FECHA:        16-06-2020 18:58:53
    ***********************************/

    IF (p_transaccion = 'REC_DETENV_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_paginacion = '';
            if (v_parametros.puntero is not null AND v_parametros.cantidad is not null) then
                v_paginacion = ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            end if;

            v_consulta := 'SELECT detenv.id_envio,
                           detenv.estado_reg,
                           detenv.ci,
                           detenv.estado,
                           detenv.fecha_envio_original,
                           detenv.fecha_envio_forzado,
                           detenv.id_recordatorio,
                           detenv.id_usuario_reg,
                           detenv.fecha_reg,
                           detenv.id_usuario_ai,
                           detenv.usuario_ai,
                           detenv.id_usuario_mod,
                           detenv.fecha_mod,
                           detenv.emails,
                           usu1.cuenta as usr_reg,
                           usu2.cuenta as usr_mod,
                           per.nombre,
                           per.apellido_paterno,
                           per.apellido_materno,
                           per.nombre_archivo_foto,
                           per.fecha_nacimiento,
                           reco.ruta_plantilla,
                           reco.ruta_script
                    FROM rec.tenvios detenv
                             JOIN segu.tpersona per ON per.ci = detenv.ci
                             JOIN rec.trecordatorios reco ON reco.id_recordatorio = detenv.id_recordatorio
                             JOIN segu.tusuario usu1 ON usu1.id_usuario = detenv.id_usuario_reg
                             LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = detenv.id_usuario_mod
                     WHERE';

            --Definicion de la respuesta
            v_consulta := v_consulta || v_parametros.filtro;
            v_consulta := v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion ||
                          v_paginacion;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;
        /*********************************
         #TRANSACCION:  'REC_DETENV_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 18:58:53
        ***********************************/

    ELSIF (p_transaccion = 'REC_DETENV_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta := 'SELECT COUNT(id_envio)
                         FROM rec.tenvios detenv
                            JOIN segu.tpersona per ON per.ci = detenv.ci
                            JOIN rec.trecordatorios reco ON reco.id_recordatorio = detenv.id_recordatorio
                            JOIN segu.tusuario usu1 ON usu1.id_usuario = detenv.id_usuario_reg
                            LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = detenv.id_usuario_mod
                         WHERE ';

            --Definicion de la respuesta
            v_consulta := v_consulta || v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

    ELSE

        RAISE EXCEPTION 'Transaccion inexistente';

    END IF;

EXCEPTION

    WHEN OTHERS THEN
        v_resp = '';
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp, 'codigo_error', SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp, 'procedimientos', v_nombre_funcion);
        RAISE EXCEPTION '%',v_resp;
END;
$BODY$
    LANGUAGE 'plpgsql' VOLATILE
                       COST 100;
ALTER FUNCTION "rec"."ft_envios_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
