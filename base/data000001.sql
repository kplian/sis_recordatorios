/********************************************I-DAT-VAN-GTAREAS-0-02/06/2020********************************************/

select pxp.f_insert_tgui ('<i class="fa fa-bell-o fa-2x"></i> RECORDATORIOS', '', 'SREC', 'si', 1, '', 1, '', '', 'REC');
select pxp.f_insert_tgui ('Recordatorios', 'Configuracion de envio de correos recordatorios', 'REC', 'si', 1, 'sis_recordatorios/vista/recordatorios/Recordatorios.php', 2, '', 'Recordatorios', 'REC');

select param.f_import_tdocumento ('insert','REC','Correlativo Recordatorios','REC','tabla','gestion','','coddoc-correlativo/gestion');
/********************************************F-DAT-VAN-GTAREAS-0-02/06/2020********************************************/