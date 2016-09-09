<?php
/**
*@package pXP
*@file gen-Pedido.php
*@author  rcm
*@date 05-11-2013 06:34:26
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Pedido=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre

		Phx.vista.Pedido.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
		this.crearVentanaWF();
		//Eventos
		this.iniciarEventos();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pedido'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'fecha',
				fieldLabel: 'Fecha',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				format: 'd/m/Y', 
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'pedido.fecha',type:'date'},
			id_grupo:0,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Nro.Pedido',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20,
				disabled:true
			},
			type:'TextField',
			filters:{pfiltro:'pedido.codigo',type:'string'},
			id_grupo:0,
			grid:true,
			form:true
		},
		{
			config : {
				name : 'id_sucursal',
				fieldLabel : 'Sucursal',
				allowBlank : false,
				emptyText : 'Sucursal...',
				store : new Ext.data.JsonStore({
					url : '../../sis_ventas/control/Sucursal/listarSucursal',
					id : 'id_sucursal',
					root : 'datos',
					sortInfo : {
						field : 'descripcion',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_sucursal', 'codigo', 'descripcion'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'pedido.descripcion#pedido.codigo'
					}
				}),
				valueField : 'id_sucursal',
				displayField : 'descripcion',
				gdisplayField : 'desc_sucursal',
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>Código: {codigo}</p><p>Descripción: {descripcion}</p></div></tpl>',
				hiddenName : 'id_sucursal',
				forceSelection : true,
				typeAhead : false,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '100%',
				gwidth : 150,
				minChars : 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_sucursal']);
				}
			},
			type : 'ComboBox',
			id_grupo : 0,
			filters : {
				pfiltro : 'pedido.desc_sucursal',
				type : 'string'
			},
			grid : true,
			form : true
		},
		{
			config : {
				name : 'id_cliente',
				fieldLabel : 'Cliente',
				allowBlank : false,
				emptyText : 'Cliente...',
				store : new Ext.data.JsonStore({
					url : '../../sis_ventas/control/Cliente/listarCliente',
					id : 'id_cliente',
					root : 'datos',
					sortInfo : {
						field : 'nombre_cliente',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_cliente', 'codigo', 'nombre_cliente'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'client.nombre_cliente#client.codigo'
					}
				}),
				valueField : 'id_cliente',
				displayField : 'nombre_cliente',
				gdisplayField : 'desc_cliente',
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>Código: {codigo}</p><p>Cliente: {nombre_cliente}</p></div></tpl>',
				hiddenName : 'id_cliente',
				forceSelection : true,
				typeAhead : false,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '100%',
				gwidth : 150,
				minChars : 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_cliente']);
				}
			},
			type : 'ComboBox',
			id_grupo : 0,
			filters : {
				pfiltro : 'pedido.desc_cliente',
				type : 'string'
			},
			grid : true,
			form : true
		},
		{
	   		config:{
	       		    name:'id_moneda',
	   				origen:'MONEDA',
	   				tinit:false,
	   				fieldLabel: 'Moneda',
	   			    gwidth: 120,
	   			    anchor: '100%',
		   			renderer: function (value, p, record){return String.format('{0}', record.data['desc_moneda']);},
		   			gdisplayField: 'desc_moneda'
			},
   			type:'ComboRec',
   			id_grupo:0,
   			filters:{	
		        pfiltro:'pedido.desc_moneda',
				type:'string'
			},
   			grid:true,
   			form:true
	   },
	   {
			config:{
				name: 'precio_total',
				fieldLabel: 'Precio total',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:1179650
			},
			type:'NumberField',
			filters:{pfiltro:'pedido.precio_total',type:'numeric'},
			id_grupo:0,
			grid:true,
			form:true
		},
	   {
			config: {
				name: 'forma_pago',
				fieldLabel: 'Forma de Pago',
				anchor: '100%',
				tinit: false,
				allowBlank: false,
				origen: 'CATALOGO',
				gdisplayField: 'forma_pago',
				gwidth: 100,
				baseParams:{
						cod_subsistema:'VEN',
						catalogo_tipo:'tpedido__forma_pago'
				},
				renderer:function (value, p, record){return String.format('{0}', record.data['forma_pago']);}
			},
			type: 'ComboRec',
			id_grupo: 0,
			filters:{pfiltro:'pedido.forma_pago',type:'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'TextField',
			filters:{pfiltro:'pedido.estado',type:'string'},
			id_grupo:0,
			grid:true,
			form:false
		},
		{
			config: {
				name: 'tipo_pago',
				fieldLabel: 'Tipo Pago',
				anchor: '100%',
				tinit: false,
				allowBlank: false,
				origen: 'CATALOGO',
				gdisplayField: 'forma_pago',
				gwidth: 100,
				baseParams:{
						cod_subsistema:'VEN',
						catalogo_tipo:'tpedido__tipo_pago'
				},
				renderer:function (value, p, record){return String.format('{0}', record.data['tipo_pago']);}
			},
			type: 'ComboRec',
			id_grupo: 0,
			filters:{pfiltro:'pedido.tipo_pago',type:'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'monto_pagado',
				fieldLabel: 'Monto Pagado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:1179650,
				validator: function(val){
					if(this.Cmp){
						if(this.Cmp.precio_total<val){
						return 'El monto pagado debe ser menor o igual al precio total';
						} else{
							return true;
						}	
					}
				}
			},
				type:'NumberField',
				filters:{pfiltro:'pedido.monto_pagado',type:'numeric'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'saldo',
				fieldLabel: 'Saldo por Pagar',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:999999,
				readOnly: true,
				renderer: function(value, p, record) {
					var aux=(record.data['precio_total']-record.data['monto_pagado']);
					return String.format('{0}', aux);
				}
			},
			type:'NumberField',
			id_grupo:0,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'destinatario',
				fieldLabel: 'Destinatario',
				allowBlank: false,
				anchor: '100%',
				gwidth: 100,
				maxLength:100
			},
			type:'TextField',
			filters:{pfiltro:'pedido.destinatario',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config : {
				name : 'id_sucursal_dest',
				fieldLabel : 'Sucursal',
				allowBlank : false,
				emptyText : 'Sucursal...',
				store : new Ext.data.JsonStore({
					url : '../../sis_ventas/control/Sucursal/listarSucursal',
					id : 'id_sucursal',
					root : 'datos',
					sortInfo : {
						field : 'descripcion',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_sucursal', 'codigo', 'descripcion'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'pedido.descripcion#pedido.codigo'
					}
				}),
				valueField : 'id_sucursal',
				displayField : 'descripcion',
				gdisplayField : 'desc_sucursal_dest',
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>Código: {codigo}</p><p>Descripción: {descripcion}</p></div></tpl>',
				hiddenName : 'id_sucursal_dest',
				forceSelection : true,
				typeAhead : false,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '100%',
				gwidth : 150,
				minChars : 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_sucursal_dest']);
				}
			},
			type : 'ComboBox',
			id_grupo : 1,
			filters : {
				pfiltro : 'pedido.desc_sucursal_dest',
				type : 'string'
			},
			grid : true,
			form : true
		},
		/*{
	   		config:{
	       		    name:'id_lugar',
	   				origen:'LUGAR',
	   				tinit:false,
	   				fieldLabel: 'Lugar Entrega',
	   			    gwidth: 120,
	   			    anchor: '100%',
		   			renderer: function (value, p, record){return String.format('{0}', record.data['desc_lugar'])},
		   			gdisplayField: 'desc_lugar'
			},
   			type:'ComboRec',
   			id_grupo:1,
   			filters:{	
		        pfiltro:'pedido.desc_lugar',
				type:'string'
			},
   			grid:true,
   			form:true
	   },*/
		{
			config:{
				name: 'direccion',
				fieldLabel: 'Direccion',
				allowBlank: false,
				anchor: '100%',
				gwidth: 100,
				maxLength:1000
			},
			type:'TextArea',
			filters:{pfiltro:'pedido.direccion',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'telef_destinatario',
				fieldLabel: 'Telf.',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
			type:'TextField',
			filters:{pfiltro:'pedido.telef_destinatario',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'obs_destinatario',
				fieldLabel: 'Observaciones',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:1000
			},
			type:'TextArea',
			filters:{pfiltro:'pedido.obs_destinatario',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
			type:'TextField',
			filters:{pfiltro:'pedido.estado_reg',type:'string'},
			id_grupo:0,
			grid:true,
			form:false
		},

		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'pedido.fecha_reg',type:'date'},
			id_grupo:0,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'NumberField',
			filters:{pfiltro:'pedido.usr_reg',type:'string'},
			id_grupo:0,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'NumberField',
			filters:{pfiltro:'pedido.usr_mod',type:'string'},
			id_grupo:0,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'pedido.fecha_mod',type:'date'},
			id_grupo:0,
			grid:true,
			form:false
		}
	],
	tam_pag:50,	
	title:'Pedido',
	ActSave:'../../sis_ventas/control/Pedido/insertarPedido',
	ActDel:'../../sis_ventas/control/Pedido/eliminarPedido',
	ActList:'../../sis_ventas/control/Pedido/listarPedido',
	id_store:'id_pedido',
	fields: [
		{name:'id_pedido', type: 'numeric'},
		{name:'id_sucursal', type: 'numeric'},
		{name:'id_cliente', type: 'numeric'},
		{name:'id_moneda', type: 'numeric'},
		{name:'forma_pago', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'fecha', type: 'date',dateFormat:'Y-m-d'},
		{name:'codigo', type: 'string'},
		{name:'tipo_pago', type: 'string'},
		{name:'monto_pagado', type: 'numeric'},
		{name:'precio_total', type: 'numeric'},
		{name:'ciudad', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'destinatario', type: 'string'},
		{name:'pais', type: 'string'},
		{name:'direccion', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_sucursal', type: 'string'},
		{name:'desc_cliente', type: 'string'},
		{name:'desc_moneda', type: 'string'},
		{name:'id_sucursal_dest', type: 'numeric'},
		{name:'id_lugar', type: 'numeric'},
		{name:'telef_destinatario', type: 'string'},
		{name:'obs_destinatario', type: 'string'},
		{name:'desc_sucursal_dest', type: 'string'},
		{name:'desc_lugar', type: 'string'}
	],
	sortInfo:{
		field: 'id_pedido',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	south:{
		  url:'../../../sis_ventas/vista/pedido_det/PedidoDet.php',
		  title:'Detalle Pedido', 
		  height:'50%',
		  cls:'PedidoDet'
	},
	Grupos:[{ 
		layout: 'column',
		items:[
			{
				xtype:'fieldset',
				layout: 'form',
                border: true,
                title: 'Datos Generales',
                bodyStyle: 'padding:0 10px 0;',
                columnWidth: 0.5,
                items:[],
		        id_grupo:0,
		        collapsible:true
			},
			{
				xtype:'fieldset',
				layout: 'form',
                border: true,
                title: 'Datos Destinatario',
                bodyStyle: 'padding:0 10px 0;',
                columnWidth: 0.5,
                items:[],
		        id_grupo:1,
		        collapsible:true,
		        collapsed:false
			}
			]
	}],
	gestionarWF: function(){                   
	    var d= this.sm.getSelected().data;
	    Phx.CP.loadingShow();            
	    Ext.Ajax.request({
	        url:'../../sis_ventas/control/Pedido/gestionarWF',
	        params:{id_pedido:d.id_pedido,operacion:'verificar'},
	        success:this.onGestionarWF,
	        failure: this.conexionFailure,
	        timeout:this.timeout,
	        scope:this
	    });     
	},
	onGestionarWF:function(resp){
		Phx.CP.loadingHide();
        var d= this.sm.getSelected().data;
        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        var swWin=0;
        var swFun=0;
        var swEst=0;

        //Se verifica la respuesta de la verificación
        if(!reg.ROOT.error){
        	var data=reg.ROOT.datos;
        	//Obtiene la cantidad de estados posibles en el workflow
        	if(data.wf_cant_estados>1){
	       		swWin=1;
	       		swEst=1;
	       		swFun=1;
	       	}
	       	//Obtiene la cantidad de funcionarios posibles en el workflow 
        	if(data.wf_cant_funcionarios>1){
				swWin=1;
				swFun=1;
	       	} 
	       	//Verifica si hay que desplegar el formulario de WF
	       	if(swWin){
	       		//Habilita/Deshabilita los combos
	       		this.cmbTipoEstWF.disable();
	       		this.cmbFunWF.disable();
	       		this.txtObs.hide();
	       		this.cmbTipoEstWF.allowBlank=true;
	       		this.cmbFunWF.allowBlank=true;		
	       		this.txtObs.allowBlank=true;
	       		
	       		if(swEst){
	       			this.cmbTipoEstWF.enable();
	       			this.cmbTipoEstWF.allowBlank=false;		
	       		}
	       		if(swFun){
	       			this.cmbTipoEstWF.enable();
	       			this.cmbFunWF.enable();
	       			this.cmbTipoEstWF.allowBlank=false;
	       			this.cmbFunWF.allowBlank=false;		
	       		}
	       		//Setea parámetros del store de Estados
	       		Ext.apply(this.cmbTipoEstWF.store.baseParams,{id_tipo_proceso: data.id_tipo_proceso, id_tipo_estado_padre: data.id_tipo_estado_padre});
	       		
	       		//Setea parámetros del store de funcionarios
	       		Ext.apply(this.cmbFunWF.store.baseParams,{id_estado_wf: data.id_estado_wf, fecha: data.fecha, id_tipo_estado: data.wf_id_tipo_estado});

	       		//Muestra la ventana
	       		this.winWF.show();
	       	} else{
	       		//Se hace la llamda directa porque el WF no tiene bifurcaciones
	       		Phx.CP.loadingShow(); 
				Ext.Ajax.request({
					url:'../../sis_ventas/control/Pedido/gestionarWF',
				  	params:{
				  		id_pedido: d.id_pedido,
				  		operacion: 'siguiente',
				  		id_funcionario_wf: data.wf_id_funcionario,
				  		id_tipo_estado: data.wf_id_tipo_estado
				      },
				      success:this.successWF,
				      failure: this.conexionFailure,
				      timeout:this.timeout,
				      scope:this
				});
	       		
	       	}
        	
        	
    	} else {
            alert('Ocurrio un error durante el proceso')
        }
    },
    successWF: function(resp){
        Phx.CP.loadingHide();
        this.winWF.hide();
        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        if(!reg.ROOT.error){
            this.reload();
        }else{
            alert('Ocurrió un error durante el proceso')
        }
	},
	crearVentanaWF: function(){
		//Creación del formulario
   		this.formWF = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            autoDestroy: true,
            layout: 'form',
            items: [{
                        xtype: 'combo',
                        name: 'id_tipo_estado',
                        hiddenName: 'id_tipo_estado',
                        fieldLabel: 'Siguiente Estado',
                        listWidth:280,
                        allowBlank: false,
                        emptyText:'Elija el estado siguiente',
                        store:new Ext.data.JsonStore(
                        {
                            url: '../../sis_workflow/control/TipoEstado/listarEstadoSiguiente',
                            id: 'id_tipo_estado',
                            root:'datos',
                            sortInfo:{
                                field:'tipes.codigo',
                                direction:'ASC'
                            },
                            totalProperty:'total',
                            fields: ['id_tipo_estado','codigo_estado','nombre_estado','tipo_asignacion'],
                            // turn on remote sorting
                        remoteSort: true,
                            baseParams:{par_filtro:'tipes.nombre_estado#tipes.codigo'}
                        }),
                        valueField: 'id_tipo_estado',
                        displayField: 'codigo_estado',
                        forceSelection:true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender:true,
                        mode:'remote',
                        pageSize:50,
                        queryDelay:500,
                        width:210,
                        gwidth:220,
                        listWidth:'280',
                        minChars:2,
                        tpl: '<tpl for="."><div class="x-combo-list-item"><p>{codigo_estado}</p>Prioridad: <strong>{nombre_estado}</strong> </div></tpl>'
                    
                    },
                    {
                        xtype: 'combo',
                        name: 'id_funcionario_wf',
                        hiddenName: 'id_funcionario_wf',
                        fieldLabel: 'Funcionario Resp.',
                        allowBlank: false,
                        emptyText:'Elija un funcionario',
                        listWidth:280,
                        store:new Ext.data.JsonStore(
                        {
                            url: '../../sis_workflow/control/TipoEstado/listarFuncionarioWf',
                            id: 'id_funcionario',
                            root:'datos',
                            sortInfo:{
                                field:'prioridad',
                                direction:'ASC'
                            },
                            totalProperty:'total',
                            fields: ['id_funcionario','desc_funcionario','prioridad'],
                            // turn on remote sorting
                            remoteSort: true,
                            baseParams:{par_filtro:'fun.desc_funcionario1'}
                        }),
                        valueField: 'id_funcionario',
                        displayField: 'desc_funcionario',
                        forceSelection:true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender:true,
                        mode:'remote',
                        pageSize:50,
                        queryDelay:500,
                        width:210,
                        gwidth:220,
                         listWidth:'280',
                        minChars:2,
                        tpl: '<tpl for="."><div class="x-combo-list-item"><p>{desc_funcionario}</p>Prioridad: <strong>{prioridad}</strong> </div></tpl>'
                    
                    },{
                        name: 'obs',
                        xtype: 'textarea',
                        fieldLabel: 'Observaciones',
                        allowBlank: false,
                        anchor: '80%',
                        maxLength:500
                    }]
        });
        
        //Agarra los componentes en variables globales
        this.cmbFunWF =this.formWF.getForm().findField('id_funcionario_wf');
        this.cmbTipoEstWF =this.formWF.getForm().findField('id_tipo_estado');
        this.txtObs =this.formWF.getForm().findField('obs');
        
        //Eventos
        this.cmbFunWF.store.on('exception', this.conexionFailure);
        this.cmbTipoEstWF.store.on('exception', this.conexionFailure);
        this.cmbTipoEstWF.on('select',function(cmp,rec,ind){
        	if(rec.data.tipo_asignacion=='ninguno'){
        		this.cmbFunWF.allowBlank=true;
        		this.cmbFunWF.setValue('');
        		this.cmbFunWF.disable();
        	} else{
        		this.cmbFunWF.enable();
        		this.cmbFunWF.allowBlank=false;
	            Ext.apply(this.cmbFunWF.store.baseParams,{id_tipo_estado: this.cmbTipoEstWF.getValue()});
	            this.cmbFunWF.modificado=true;	
        	}
            
        },this);
        
        //Creación de la ventna
        this.winWF = new Ext.Window({
            title: 'Workflow',
            collapsible: true,
            maximizable: true,
            autoDestroy: true,
            width: 350,
            height: 200,
            layout: 'fit',
            plain: true,
            bodyStyle: 'padding:5px;',
            buttonAlign: 'center',
            items: this.formWF,
            modal:true,
            closeAction: 'hide',
            buttons: [{
                text: 'Guardar',
                handler:this.onWF,
                argument: this.opcionWF,
                scope:this
                
            },{
                text: 'Cancelar',
                handler:function(){this.winWF.hide()},
                scope:this
            }]
        });
   	},
   	
   	calcularSaldo: function(pTotal,pPagado){
   		var total,pagado,saldo;
		total=pTotal;
		pagado=pPagado;
		if(isNaN(pTotal)){
			total=0;
		}
		if(isNaN(pPagado)){
			pagado=0;
		}
		saldo = total - pagado;
		return saldo;
   	},
   	
   	iniciarEventos: function(){
   		this.Cmp.precio_total.on('change',function(){
			this.Cmp.saldo.setValue(this.calcularSaldo(this.Cmp.precio_total.getValue(),this.Cmp.monto_pagado.getValue()));
		},this);
		this.Cmp.monto_pagado.on('change',function(){
			this.Cmp.saldo.setValue(this.calcularSaldo(this.Cmp.precio_total.getValue(),this.Cmp.monto_pagado.getValue()));
		},this);
   	}
})
</script>
		
		