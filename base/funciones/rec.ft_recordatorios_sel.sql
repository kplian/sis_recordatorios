CREATE OR REPLACE FUNCTION "rec"."ft_recordatorios_sel"(p_administrador integer, p_id_usuario integer,
                                                        p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:        Recordatorios
 FUNCION:         rec.ft_recordatorios_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'rec.trecordatorios'
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

    v_consulta       VARCHAR;
    v_parametros     RECORD;
    v_nombre_funcion TEXT;
    v_resp           VARCHAR;
    v_paginacion     varchar;
BEGIN

    v_nombre_funcion = 'rec.ft_recordatorios_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'REC_REC_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        valvarado    
     #FECHA:        16-06-2020 15:28:32
    ***********************************/

    IF (p_transaccion = 'REC_REC_SEL') THEN

        BEGIN
            v_paginacion = '';
            if (v_parametros.puntero is not null AND v_parametros.cantidad is not null) then
                v_paginacion = ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            end if;
            --Sentencia de la consulta
            v_consulta := 'SELECT
                        rec.id_recordatorio,
                        rec.estado_reg,
                        rec.codigo,
                        rec.nombre,
                        rec.forzar_dia_habil,
                        rec.ruta_plantilla,
                        rec.ruta_script,
                        rec.estado,
                        rec.id_usuario_reg,
                        rec.fecha_reg,
                        rec.id_usuario_ai,
                        rec.usuario_ai,
                        rec.id_usuario_mod,
                        rec.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod    
                        FROM rec.trecordatorios rec
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = rec.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = rec.id_usuario_mod
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta := v_consulta || v_parametros.filtro;
            v_consulta := v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || v_paginacion ;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

        /*********************************
         #TRANSACCION:  'REC_REC_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        valvarado
         #FECHA:        16-06-2020 15:28:32
        ***********************************/

    ELSIF (p_transaccion = 'REC_REC_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta := 'SELECT COUNT(id_recordatorio)
                         FROM rec.trecordatorios rec
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = rec.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = rec.id_usuario_mod
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
ALTER FUNCTION "rec"."ft_recordatorios_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
