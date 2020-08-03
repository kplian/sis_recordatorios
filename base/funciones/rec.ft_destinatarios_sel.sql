CREATE OR REPLACE FUNCTION "rec"."ft_destinatarios_sel"(p_administrador integer, p_id_usuario integer,
                                                        p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:        Recordatorios
 FUNCION:         rec.ft_destinatarios_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'rec.tdestinatarios'
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

    v_consulta       VARCHAR;
    v_parametros     RECORD;
    v_nombre_funcion TEXT;
    v_resp           VARCHAR;
    v_paginacion     varchar;
BEGIN

    v_nombre_funcion = 'rec.ft_destinatarios_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'REC_DES_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        valvarado    
     #FECHA:        16-06-2020 15:35:08
    ***********************************/

    IF (p_transaccion = 'REC_DES_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_paginacion = '';
            if (v_parametros.puntero is not null AND v_parametros.cantidad is not null) then
                v_paginacion = ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            end if;
            v_consulta := 'SELECT
                        des.id_recordatorio,
                        des.estado_reg,
                        des.ci,
                        des.nombres,
                        des.apellido_paterno,
                        des.apellido_materno,
                        des.emails,
                        des.estado,
                        des.id_usuario_reg,
                        des.fecha_reg,
                        des.id_usuario_ai,
                        des.usuario_ai,
                        des.id_usuario_mod,
                        des.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        des.fecha_envio_original,
                        des.fecha_envio_forzado,
                        des.dia,
                        des.mes,
                        des.anio,
                        des.campos_extra,
                        per.nombre_archivo_foto,
                        per.fecha_nacimiento,
                        reco.ruta_plantilla,
                        reco.ruta_script,
                        per.sobrenombre,
                        per.cualidad_1,
                        per.cualidad_2,
                        per.genero
                        FROM rec.tdestinatarios des
                        JOIN segu.tpersona per ON per.ci = des.ci
                        JOIN rec.trecordatorios reco ON reco.id_recordatorio = des.id_recordatorio
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = des.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = des.id_usuario_mod
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta := v_consulta || v_parametros.filtro;
            v_consulta := v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion ||
                          v_paginacion;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

        /*********************************
         #TRANSACCION:  'REC_DES_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 15:35:08
        ***********************************/

    ELSIF (p_transaccion = 'REC_DES_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta := 'SELECT COUNT(des.ci)
                         FROM rec.tdestinatarios des
                         JOIN segu.tpersona per ON per.ci = des.ci
                         JOIN rec.trecordatorios reco ON reco.id_recordatorio = des.id_recordatorio
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = des.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = des.id_usuario_mod
                         WHERE ';

            --Definicion de la respuesta            
            v_consulta := v_consulta || v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END ;

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
ALTER FUNCTION "rec"."ft_destinatarios_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
