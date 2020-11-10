<?php
/****************************************************************************************
 * @package pXP
 * @file Destinatarios.php
 * @author  (valvarado)
 * @date 16-06-2020 15:35:08
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 *
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                16-06-2020 15:35:08    valvarado            Creacion
 * #
 *******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Destinatarios = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Destinatarios.superclass.constructor.call(this, config);

                this.init();
                this.addBotones();
                this.store.baseParams = {
                    id_recordatorio: 0
                };
                this.load({params: {start: 0, limit: 50}});
            },

            Atributos: [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_recordatorio'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'nombre_archivo_foto',
                        fieldLabel: 'Fotografia',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100,
                        renderer: function (value, p, record) {
                            var foto = record.data['nombre_archivo_foto'];
                            return String.format('{0}', "<div style='text-align:center'><img src = '../../control/foto_persona/ActionObtenerFoto.php?file=" + foto + "' align='center'  height='70'/></div>");
                        },
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.ruta_imagen', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'ci',
                        fieldLabel: 'CI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.ci', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    bottom_filter: true,
                    form: true
                },
                {
                    config: {
                        name: 'nombres',
                        fieldLabel: 'Nombres',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.nombres', type: 'string'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'apellido_paterno',
                        fieldLabel: 'Apellido Paterno',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.apellido_paterno', type: 'string'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'apellido_materno',
                        fieldLabel: 'Apellido Materno',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.apellido_materno', type: 'string'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'emails',
                        fieldLabel: 'Emails',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.emails', type: 'string'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_nacimiento',
                        fieldLabel: 'Fecha Nacimiento',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'per.fecha_nacimiento', type: 'date'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_envio_original',
                        fieldLabel: 'Fecha Envio Original',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'des.fecha_envio_original', type: 'date'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_envio_forzado',
                        fieldLabel: 'Fecha Envio Forzado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'des.fecha_envio_forzado', type: 'date'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'estado',
                        fieldLabel: 'Estado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.estado', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'imagen_predeterminada',
                        fieldLabel: 'Mostrar Imagen Predeterminada?',
                        qtip: 'Si se mostrará la imagen predeterminada en lugar de la fotografía original',
                        allowBlank: false,
                        anchor: '40%',
                        gwidth: 80,
                        typeAhead: true,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        store: ['si', 'no']
                    },
                    type: 'ComboBox',
                    id_grupo: 1,
                    filters: {
                        pfiltro: 'des.imagen_predeterminada',
                        type: 'list',
                        options: ['si', 'no']
                    },
                    valorInicial: 'no',
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'des.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'des.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'des.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu2.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'des.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            title: 'Detalle Destinatarios',
            ActSave: '../../sis_recordatorios/control/Destinatarios/insertarDestinatarios',
            ActDel: '../../sis_recordatorios/control/Destinatarios/eliminarDestinatarios',
            ActList: '../../sis_recordatorios/control/Destinatarios/listarDestinatarios',
            id_store: 'ci',
            fields: [                
                {name: 'id_recordatorio', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'ci', type: 'string'},
                {name: 'nombres', type: 'string'},
                {name: 'apellido_paterno', type: 'string'},
                {name: 'apellido_materno', type: 'string'},
                {name: 'emails', type: 'string'},
                {name: 'estado', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'fecha_envio_original', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'fecha_envio_forzado', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'dia', type: 'numeric'},
                {name: 'mes', type: 'numeric'},
                {name: 'anio', type: 'numeric'},
                {name: 'nombre_archivo_foto', type: 'string'},
                {name: 'fecha_nacimiento', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'imagen_predeterminada', type: 'string'},
            ],
            sortInfo: {
                field: 'ci',
                direction: 'ASC'
            },
            bdel: true,
            bsave: false,
            bnew: false,
            bedit: true,
            onReloadPage: function (m) {
                this.maestro = m;

                this.Atributos[this.getIndAtributo('id_recordatorio')].valorInicial = this.maestro.id_recordatorio;

                this.store.baseParams = {
                    id_recordatorio: this.maestro.id_recordatorio
                };
                this.load({params: {start: 0, limit: 50}});
            },

            sincronizar: function () {
                var self = this;
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_recordatorios/control/Destinatarios/sincronizar',
                    params: {id_recordatorio: this.maestro.id_recordatorio},
                    success: function (resp) {
                        Phx.CP.loadingHide();
                        self.reload();
                    },
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            },
            preparaMenu: function (n) {
                var data = this.getSelectedData();
                var tb = this.tbar;
                Phx.vista.Destinatarios.superclass.preparaMenu.call(this, n);
                if (data) {
                    this.getBoton('enviar').enable();
                    this.getBoton('preview').enable();
                }
                return tb
            },
            liberaMenu: function () {
                var tb = Phx.vista.Destinatarios.superclass.liberaMenu.call(this);
                if (tb) {
                    this.getBoton('sicronizar').enable();
                    this.getBoton('enviar').disable();
                    this.getBoton('preview').disable();
                }
                return tb
            },
            addBotones: function () {
                this.addButton('sicronizar',
                    {
                        text: 'Sincronizar',
                        iconCls: 'breload',
                        grupo: [0, 2],
                        disabled: false,
                        handler: this.sincronizar,
                        tooltip: '<b>Enviar correos</b>'
                    });
                this.addButton('enviar',
                    {
                        text: 'Enviar',
                        iconCls: 'bsendmail',
                        grupo: [0, 2],
                        disabled: false,
                        handler: this.enviar,
                        tooltip: '<b>Enviar Actual</b>'
                    });
                this.addButton('preview',
                    {
                        text: 'Previzualizaci&oacute;n',
                        iconCls: 'bsee',
                        grupo: [0, 2],
                        disabled: false,
                        handler: this.preview,
                        tooltip: '<b>Previzualizaci&oacute;n</b>'
                    });
            },
            enviar: function () {
                var self = this;
                Phx.CP.loadingShow();
                var data = self.getSelectedData();
                Ext.Ajax.request({
                    url: '../../sis_recordatorios/control/Destinatarios/enviar',
                    params: {id_recordatorio: data.id_recordatorio, ci: data.ci},
                    success: function (resp) {
                        Phx.CP.loadingHide();
                        self.reload();
                    },
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            },
            preview: function () {
                var self = this;
                var data = self.getSelectedData();
                var win = new Ext.Window({
                    id: 'preview-win',
                    title: 'Previzualizaci&oacute;n',
                    autoScroll: true,
                    layout: 'fit',
                    autoHeight: true,
                    autoLoad: {
                        url: '../../sis_recordatorios/control/Destinatarios/preview',
                        params: {id_recordatorio: data.id_recordatorio, ci: data.ci},
                        scripts: true
                    }
                });
                win.show();
            }
        },
    )
</script>
        
        