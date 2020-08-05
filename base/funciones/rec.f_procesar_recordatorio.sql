CREATE OR REPLACE FUNCTION rec.f_procesar_recordatorio()
    RETURNS TABLE
            (
                ci                   varchar,
                nombres              varchar,
                apellido_paterno     varchar,
                apellido_materno     varchar,
                emails               varchar,
                nombre_archvio_foto  text,
                fecha_envio_original date,
                fecha_envio_forzado  date,
                dia                  integer,
                mes                  integer,
                anio                 integer
            )
AS
$body$
declare
    v_nombre_funcion varchar = 'rec.f_procesar_recordatorio';
    v_resp           varchar;
    v_registros      record;
    fecha_envio_tmp  date;
    v_fecha_actual   date;
begin
    v_fecha_actual = now();
    FOR v_registros in (select DISTINCT per.id_persona,
                                        per.ci,
                                        per.nombre,
                                        per.apellido_paterno,
                                        per.apellido_materno,
                                        per.fecha_nacimiento,
                                        c.email_empresa as emails,
                                        per.nombre_archivo_foto,
                                        c.fecha_finalizacion,
                                        c.fecha_asignacion
                        from orga.vfuncionario_cargo c
                                 inner join segu.tpersona per on c.ci = per.ci
                        where (date_part('DAY', per.fecha_nacimiento) = date_part('DAY', v_fecha_actual)
                            AND date_part('MONTH', per.fecha_nacimiento) = date_part('MONTH', v_fecha_actual))
                          AND ((c.fecha_asignacion <= v_fecha_actual AND c.fecha_finalizacion >= v_fecha_actual)
                            or (c.fecha_asignacion <= v_fecha_actual AND c.fecha_finalizacion is null)))
        LOOP

            ci = v_registros.ci;
            nombres = v_registros.nombre;
            apellido_paterno = v_registros.apellido_paterno;
            apellido_materno = v_registros.apellido_materno;
            emails = v_registros.emails;
            nombre_archvio_foto = v_registros.nombre_archivo_foto;
            fecha_envio_original =
                    (date_part('YEAR', v_fecha_actual) || '-' || date_part('MONTH', v_registros.fecha_nacimiento) ||
                     '-' || date_part('DAY', v_registros.fecha_nacimiento))::date;

            dia = date_part('DAY', fecha_envio_original);
            mes = date_part('MONTH', fecha_envio_original);
            anio = date_part('YEAR', fecha_envio_original);

            if (EXTRACT(ISODOW FROM fecha_envio_original) IN (6, 7)) then
                fecha_envio_tmp = (date_trunc('week', fecha_envio_original::date) + INTERVAL '4 days');
                fecha_envio_forzado = date_part('YEAR', v_fecha_actual) || '-' || date_part('MONTH', fecha_envio_tmp) ||
                                      '-' || date_part('DAY', fecha_envio_tmp);
                dia = date_part('DAY', fecha_envio_forzado);
                mes = date_part('MONTH', fecha_envio_forzado);
                anio = date_part('YEAR', fecha_envio_forzado);
            else
                fecha_envio_forzado = null;
            end if;
            return next;

        end loop;
exception
    when others then
        v_resp = '';
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp, 'codigo_error', SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp, 'procedimiento', v_nombre_funcion);
        raise exception '%',v_resp;
end ;
$body$
    LANGUAGE 'plpgsql'
    VOLATILE
    CALLED ON NULL INPUT
    SECURITY INVOKER
    COST 100
    ROWS 1000;

ALTER FUNCTION rec.f_procesar_recordatorio ()
    OWNER TO postgres;