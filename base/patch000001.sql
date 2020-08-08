/***********************************I-SCP-VAN-GTAREAS-0-02/06/2020****************************************/
create table rec.trecordatorios
(
    id_recordatorio  serial not null,
    codigo           varchar,
    nombre           varchar,
    forzar_dia_habil varchar,
    ruta_plantilla   varchar,
    ruta_script      varchar,
    estado           varchar,
    constraint trecordatorio_pk
        primary key (id_recordatorio)
)
    inherits (pxp.tbase);

alter table rec.trecordatorios
    owner to postgres;

create table rec.tenvios
(
    id_envio             serial not null,
    ci                   varchar,
    estado               varchar,
    fecha_envio_original date,
    id_recordatorio      integer,
    dia                  integer,
    mes                  integer,
    anio                 integer,
    fecha_envio_forzado  date,
    emails               varchar,
    constraint tenvios_pk
        primary key (id_envio),
    constraint tenvios_pk_2
        unique (ci),
    constraint tenvios_trecordatorios_id_recordatorio_fk
        foreign key (id_recordatorio) references rec.trecordatorios
)
    inherits (pxp.tbase);

alter table rec.tenvios
    owner to postgres;

create table rec.tdestinatarios
(
    ci                   varchar not null,
    nombres              varchar,
    apellido_paterno     varchar,
    apellido_materno     varchar,
    emails               varchar,
    estado               varchar,
    campos_extra         json,
    id_recordatorio      integer,
    fecha_envio_original date,
    fecha_envio_forzado  date,
    dia                  integer,
    mes                  integer,
    anio                 integer,
    constraint tdestinatarios_pk
        primary key (ci),
    constraint tdestinatarios_trecordatorios_id_recordatorio_fk
        foreign key (id_recordatorio) references rec.trecordatorios
)
    inherits (pxp.tbase);

alter table rec.tdestinatarios
    owner to postgres;

create unique index tdestinatarios_ci_uindex
    on rec.tdestinatarios (ci);
/***********************************F-SCP-VAN-GTAREAS-0-02/06/2020****************************************/
/***********************************I-SCP-VAN-GTAREAS-0-07/08/2020****************************************/
alter table rec.tenvios drop constraint tenvios_pk_2;
/***********************************F-SCP-VAN-GTAREAS-0-07/08/2020****************************************/