<?php
/****************************************************************************************
 * @package pXP
 * @file Recordatorios.php
 * @author  (valvarado)
 * @date 16-06-2020 15:28:32
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 *
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                16-06-2020 15:28:32    valvarado            Creacion
 * #
 *******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Recordatorios = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Recordatorios.superclass.constructor.call(this, config);
                this.addBotones();
                this.init();
                this.load({params: {start: 0, limit: this.tam_pag}})
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
                    filters: {pfiltro: 'rec.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'codigo',
                        fieldLabel: 'codigo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 500
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'rec.codigo', type: 'string'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'nombre',
                        fieldLabel: 'nombre',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 500
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'rec.nombre', type: 'string'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'forzar_dia_habil',
                        fieldLabel: 'Forzar dia Hábil',
                        qtip: 'Forzar el envió de correo solo dias hábiles (Lunes - Viernes)',
                        allowBlank: false,
                        anchor: '40%',
                        gwidth: 100,
                        maxLength: 500,
                        emptyText: 'si/no...',
                        typeAhead: true,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        store: ['si', 'no']
                    },
                    type: 'ComboBox',
                    id_grupo: 1,
                    filters: {
                        type: 'list', pfiltro: 'rec.forzar_dia_habil', options: ['si', 'no'],
                    },
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'ruta_plantilla',
                        fieldLabel: 'ruta_plantilla',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 500
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'rec.ruta_plantilla', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'ruta_script',
                        fieldLabel: 'ruta_script',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 500
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'rec.ruta_script', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'estado',
                        fieldLabel: 'Estado del recordatorio',
                        qtip: 'Permite establecer al recordatorio a un estado de Ejecutando o Parado',
                        allowBlank: false,
                        anchor: '40%',
                        gwidth: 100,
                        maxLength: 100,
                        emptyText: 'Ejcuatando/Parado...',
                        typeAhead: true,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        store: ['Ejecutando', 'Parado']
                    },
                    type: 'ComboBox',
                    id_grupo: 1,
                    filters: {
                        type: 'list', pfiltro: 'rec.estado', options: ['Ejecutando', 'Parado'],
                    },
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
                    filters: {pfiltro: 'rec.fecha_reg', type: 'date'},
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
                    filters: {pfiltro: 'rec.id_usuario_ai', type: 'numeric'},
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
                    filters: {pfiltro: 'rec.usuario_ai', type: 'string'},
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
                    filters: {pfiltro: 'rec.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            title: 'Recordatorios',
            ActSave: '../../sis_recordatorios/control/Recordatorios/insertarRecordatorios',
            ActDel: '../../sis_recordatorios/control/Recordatorios/eliminarRecordatorios',
            ActList: '../../sis_recordatorios/control/Recordatorios/listarRecordatorios',
            id_store: 'id_recordatorio',
            fields: [
                {name: 'id_recordatorio', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'codigo', type: 'string'},
                {name: 'nombre', type: 'string'},
                {name: 'forzar_dia_habil', type: 'string'},
                {name: 'ruta_plantilla', type: 'string'},
                {name: 'ruta_script', type: 'string'},
                {name: 'estado', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},

            ],
            sortInfo: {
                field: 'id_recordatorio',
                direction: 'ASC'
            },
            bdel: true,
            bsave: true,
            tabsouth: [
                {
                    url: '../../../sis_recordatorios/vista/destinatarios/Destinatarios.php',
                    title: 'Programa de Envios',
                    height: '40%',
                    cls: 'Destinatarios'
                },
                {
                    url: '../../../sis_recordatorios/vista/envios/Envios.php',
                    title: 'Envios Realizado',
                    height: '40%',
                    cls: 'Envios'
                }],
            liberaMenu: function () {
                var tb = Phx.vista.Recordatorios.superclass.liberaMenu.call(this);
                if (tb) {
                    this.getBoton('cambiar_estado').setIconClass('bplay');
                    this.getBoton('cambiar_estado').setText('Ejecutar');
                    this.getBoton('cambiar_estado').disable();
                }
                return tb
            },
            preparaMenu: function (n) {
                var data = this.getSelectedData();
                var tb = this.tbar;
                console.log(data);
                Phx.vista.Recordatorios.superclass.preparaMenu.call(this, n);
                if (data) {
                    switch (data.estado) {
                        case 'Ejecutando': {
                            this.getBoton('edit').disable();
                            this.getBoton('del').disable();
                            this.getBoton('cambiar_estado').setIconClass('bpause');
                            this.getBoton('cambiar_estado').setText('Parar');
                            this.getBoton('cambiar_estado').enable();
                            break;
                        }
                        case 'Parado': {
                            this.getBoton('cambiar_estado').setIconClass('bplay');
                            this.getBoton('cambiar_estado').setText('Ejecutar');
                            this.getBoton('cambiar_estado').enable();
                            this.getBoton('edit').enable();
                            this.getBoton('del').enable();
                            break;
                        }
                        default: {
                            this.getBoton('edit').disable();
                            this.getBoton('del').disable();
                            this.getBoton('cambiar_estado').setIconClass('bpause');
                            this.getBoton('cambiar_estado').setText('Parar');
                            this.getBoton('cambiar_estado').disable();
                        }
                    }

                }
                return tb
            },
            addBotones: function () {
                this.addButton('cambiar_estado',
                    {
                        text: 'Ejecutar',
                        iconCls: 'bplay',
                        grupo: [0, 2],
                        disabled: false,
                        handler: this.cambiar,
                        tooltip: '<b>Cmabiar Estado</b>'
                    });
            },
            cambiar: function () {
                var self = this;
                var data = self.getSelectedData();
                if (data.estado == 'Ejecutando') {
                    estado = 'Parado';
                } else {
                    estado = 'Ejecutando';
                }
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_recordatorios/control/Recordatorios/cambiarEstado',
                    params: {id_recordatorio: data.id_recordatorio, estado: estado},
                    success: function (resp) {
                        Phx.CP.loadingHide();
                        self.reload();
                    },
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            },
        }
    )
</script>
        
        