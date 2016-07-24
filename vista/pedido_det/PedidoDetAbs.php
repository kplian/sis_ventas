<?php
/**
*@package pXP
*@file gen-PedidoDet.php
*@author  rcm
*@date 05-11-2013 06:34:29
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PedidoDetAbs=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.PedidoDetAbs.superclass.constructor.call(this,config);
		/*this.grid.getTopToolbar().disable();
		this.grid.getBottomToolbar().disable();*/
		this.init();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pedido_det'
			},
			type:'Field',
			form:true 
		},
		{
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
				name: 'codigo',
				fieldLabel: 'Código',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100,
				disabled:true
			},
			type:'TextField',
			filters:{pfiltro:'detped.codigo',type:'string'},
			id_grupo:0,
			grid:true,
			form:true
		},
		{
			config : {
				name : 'id_item',
				fieldLabel : 'Item',
				allowBlank : false,
				emptyText : 'Elija un Item...',
				store : new Ext.data.JsonStore({
					url : '../../sis_almacenes/control/Item/listarItemNotBase',
					id : 'id_item',
					root : 'datos',
					sortInfo : {
						field : 'nombre',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_item', 'nombre', 'codigo', 'desc_clasificacion', 'codigo_unidad'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'item.nombre#item.codigo#cla.nombre'
					}
				}),
				valueField : 'id_item',
				displayField : 'nombre',
				gdisplayField : 'desc_item',
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>Nombre: {nombre}</p><p>Código: {codigo}</p><p>Clasif.: {desc_clasificacion}</p></div></tpl>',
				hiddenName : 'id_item',
				forceSelection : true,
				typeAhead : false,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '100%',
				gwidth : 250,
				minChars : 2,
				turl : '../../../sis_almacenes/vista/item/BuscarItem.php',
				tasignacion : true,
				tname : 'id_item',
				ttitle : 'Items',
				tdata : {},
				tcls : 'BuscarItem',
				pid : this.idContenedor,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_item']);
				},
				resizable: true
			},
			type : 'TrigguerCombo',
			id_grupo : 0,
			filters : {
				pfiltro : 'item.nombre#item.codigo',
				type : 'string'
			},
			grid : true,
			form : true
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Descripción',
				allowBlank: false,
				anchor: '100%',
				gwidth: 250,
				maxLength:15000
			},
			type:'TextArea',
			filters:{pfiltro:'prod.descripcion',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'cantidad_sol',
				fieldLabel: 'Cantidad',
				allowBlank: false,
				anchor: '100%',
				gwidth: 100,
				maxLength:30
			},
			type:'NumberField',
			filters:{pfiltro:'detped.cantidad_sol',type:'numeric'},
			id_grupo:0,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'precio_unit',
				fieldLabel: 'Precio Unitario',
				allowBlank: false,
				anchor: '100%',
				gwidth: 100,
				maxLength:30
			},
			type:'NumberField',
			filters:{pfiltro:'prod.precio_unit',type:'numeric'},
			id_grupo:0,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'precio_total',
				fieldLabel: 'Precio Total',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:30,
				readOnly: true,
				renderer: function(value, p, record) {
					var aux=record.data['cantidad_sol']*record.data['precio_unit'];
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
				name: 'observaciones',
				fieldLabel: 'Observaciones',
				allowBlank: true,
				anchor: '100%',
				gwidth: 250,
				maxLength:15000
			},
			type:'TextArea',
			filters:{pfiltro:'detped.observaciones',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config : {
				name : 'id_proveedor',
				fieldLabel : 'Proveedor',
				allowBlank : true,
				emptyText : 'Proveedor...',
				store : new Ext.data.JsonStore({
					url : '../../sis_parametros/control/Proveedor/listarProveedorCombos',
					id : 'id_proveedor',
					root : 'datos',
					sortInfo : {
						field : 'desc_proveedor',
						direction : 'ASC'
					},
					fields : ['id_proveedor', 'desc_proveedor'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'desc_proveedor'
					}
				}),
				valueField : 'id_proveedor',
				displayField : 'desc_proveedor',
				gdisplayField : 'desc_proveedor',
				hiddenName : 'id_proveedor',
				forceSelection : true,
				typeAhead : true,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '99%',
				enableMultiSelect : true,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_proveedor']);
				}
			},
			type : 'ComboBox',
			id_grupo : 0,
			filters : {
				pfiltro : 'prov.desc_proveedor',
				type : 'string'
			},
			grid : true,
			form : true
		},
		{
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_envio'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'estado',
				fieldLabel: 'estado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'TextField',
			filters:{pfiltro:'detped.estado',type:'string'},
			id_grupo:0,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'nro_serie',
				fieldLabel: 'Nro.Serie',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
			type:'TextField',
			filters:{pfiltro:'prod.nro_serie',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'marca',
				fieldLabel: 'Marca',
				allowBlank: true,
				anchor: '100%',
				gwidth: 130,
				maxLength:150
			},
			type:'TextField',
			filters:{pfiltro:'prod.marca',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'procedencia',
				fieldLabel: 'Procedencia',
				allowBlank: true,
				anchor: '100%',
				gwidth: 150,
				maxLength:200
			},
			type:'TextField',
			filters:{pfiltro:'prod.procedencia',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
	   		config:{
	       		    name:'id_unidad_medida_peso',
	   				origen:'UNIDADMEDIDA',
	   				tinit:false,
	   				fieldLabel:'Medida Peso',
	   				gdisplayField:'desc_unidad_medida_peso',
	   				anchor: '100%',
	   			    gwidth: 70,
		   			renderer:function (value, p, record){return String.format('{0}', record.data['desc_unidad_medida_peso']);},
		   			tipo: 'Masa',
		   			allowBlank:true
	       	     },
	   			type:'ComboRec',
	   			id_grupo:1,
	   			filters:{	
			        pfiltro:'umed.descripcion#umed.codigo',
					type:'string'
				},
	   			grid:true,
	   			form:true
	   	},
		{
			config:{
				name: 'peso',
				fieldLabel: 'Peso',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
			type:'NumberField',
			filters:{pfiltro:'prod.peso',type:'numeric'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
	   		config:{
	       		    name:'id_unidad_medida_long',
	   				origen:'UNIDADMEDIDA',
	   				tinit:false,
	   				fieldLabel:'Medida Longitud',
	   				gdisplayField:'desc_unidad_medida_long',
	   				anchor: '100%',
	   			    gwidth: 70,
		   			renderer:function (value, p, record){return String.format('{0}', record.data['desc_unidad_medida_long']);},
		   			tipo: 'Longitud',
		   			allowBlank:true
	       	     },
	   			type:'ComboRec',
	   			id_grupo:1,
	   			filters:{	
			        pfiltro:'umed1.descripcion#umed1.codigo',
					type:'string'
				},
	   			grid:true,
	   			form:true
	   	},
		{
			config:{
				name: 'altura',
				fieldLabel: 'Altura',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
			type:'NumberField',
			filters:{pfiltro:'prod.altura',type:'numeric'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'ancho',
				fieldLabel: 'Ancho',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
			type:'NumberField',
			filters:{pfiltro:'prod.ancho',type:'numeric'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'largo',
				fieldLabel: 'Largo',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
			type:'NumberField',
			filters:{pfiltro:'prod.largo',type:'numeric'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'relacion_peso_vol',
				fieldLabel: 'Relación Peso/Volumen',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:30,
				readOnly: true,
				renderer: function(value, p, record) {
					var aux=(record.data['altura']*record.data['largo']*record.data['ancho'])/365*2.2;
					return String.format('{0}', aux);
				}
			},
			type:'NumberField',
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
			filters:{pfiltro:'detped.estado_reg',type:'string'},
			id_grupo:0,
			grid:true,
			form:false
		},
		{
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_producto'
			},
			type:'Field',
			form:true 
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
			filters:{pfiltro:'usu1.cuenta',type:'string'},
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
			filters:{pfiltro:'detped.fecha_reg',type:'date'},
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
			filters:{pfiltro:'usu2.cuenta',type:'string'},
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
			filters:{pfiltro:'detped.fecha_mod',type:'date'},
			id_grupo:0,
			grid:true,
			form:false
		}
	],
	tam_pag:50,	
	title:'Detalle Pedido',
	ActSave:'../../sis_ventas/control/PedidoDet/insertarPedidoDet',
	ActDel:'../../sis_ventas/control/PedidoDet/eliminarPedidoDet',
	ActList:'../../sis_ventas/control/PedidoDet/listarPedidoDet',
	id_store:'id_pedido_det',
	fields: [
		{name:'id_pedido_det', type: 'numeric'},
		{name:'id_pedido', type: 'numeric'},
		{name:'id_item', type: 'numeric'},
		{name:'id_proveedor', type: 'numeric'},
		{name:'id_envio', type: 'numeric'},
		{name:'codigo', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'cantidad_sol', type: 'numeric'},
		{name:'estado', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_proceso_macro', type: 'numeric'},
		{name:'id_estado_wf', type: 'numeric'},
		{name:'id_proceso_wf', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_item', type: 'string'},
		{name:'desc_proveedor', type: 'string'},
		
		{name:'id_producto', type: 'numeric'},
		{name:'id_unidad_medida_peso', type: 'numeric'},
		{name:'id_unidad_medida_long', type: 'numeric'},
		{name:'codigo_producto', type: 'string'},
		{name:'precio_unit', type: 'numeric'},
		{name:'descripcion', type: 'string'},
		{name:'nro_serie', type: 'string'},
		{name:'marca', type: 'string'},
		{name:'procedencia', type: 'string'},
		{name:'peso', type: 'numeric'},
		{name:'altura', type: 'numeric'},
		{name:'ancho', type: 'numeric'},
		{name:'largo', type: 'numeric'},
		{name:'desc_unidad_medida_peso', type: 'string'},
		{name:'desc_unidad_medida_long', type: 'string'},
		
		{name:'id_sucursal', type: 'numeric'},
		{name:'id_sucursal_dest', type: 'numeric'},
		{name:'desc_sucursal_dest', type: 'string'},
		{name:'desc_sucursal', type: 'string'},
		{name:'destinatario', type: 'string'},
		{name:'desc_cliente', type: 'string'},
		{name:'nro_pedido', type: 'string'},
		{name:'fecha', type: 'date',dateFormat:'Y-m-d'},
		
	],
	sortInfo:{
		field: 'id_pedido_det',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
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
                title: 'Detalle Producto',
                bodyStyle: 'padding:0 10px 0;',
                columnWidth: 0.5,
                items:[],
		        id_grupo:1,
		        collapsible:true,
		        collapsed:false
			}
			]
		}],
	iniciarEventos: function(){
		this.Cmp.cantidad_sol.on('blur',function(){
			this.Cmp.precio_total.setValue(this.calcularPrecioTotal(this.Cmp.cantidad_sol.getValue(),this.Cmp.precio_unit.getValue()));
		},this);
		this.Cmp.precio_unit.on('blur',function(){
			this.Cmp.precio_total.setValue(this.calcularPrecioTotal(this.Cmp.cantidad_sol.getValue(),this.Cmp.precio_unit.getValue()));
		},this);
		this.Cmp.altura.on('change',function(){
			this.Cmp.relacion_peso_vol.setValue(this.calcularRelPrecioVol(this.Cmp.altura.getValue(),this.Cmp.largo.getValue(),this.Cmp.ancho.getValue()));
		},this);
		this.Cmp.largo.on('change',function(){
			this.Cmp.relacion_peso_vol.setValue(this.calcularRelPrecioVol(this.Cmp.altura.getValue(),this.Cmp.largo.getValue(),this.Cmp.ancho.getValue()));
		},this);
		this.Cmp.ancho.on('change',function(){
			this.Cmp.relacion_peso_vol.setValue(this.calcularRelPrecioVol(this.Cmp.altura.getValue(),this.Cmp.largo.getValue(),this.Cmp.ancho.getValue()));
		},this);
	},
	calcularPrecioTotal: function(pCant,pPrecio){
		var cant,precio,total;
		cant=pCant;
		precio=pPrecio;
		if(isNaN(pCant)){
			cant=0;
		}
		if(isNaN(pPrecio)){
			precio=0;
		}
		console.log(cant,precio)
		total = cant * precio;
		console.log(total)
		return total;
	},
	repCodigoBarras: function() {
		var rec = this.sm.getSelected();
		var data = rec.data;
		if (data) {
			Ext.Ajax.request({
				url : '../../sis_ventas/control/PedidoDet/reporteCodigoBarras',
				params : {
					id_pedido_det: data.id_pedido_det,
					start:0,
					limit:1,
					sort:'id_pedido_det',
					dir: 'ASC'
				},
				success : this.successExport,
				failure : this.conexionFailure,
				timeout : this.timeout,
				scope : this
			});
		} else{
			alert('Debe seleccionar un registro')
		}
	},
	gestionarWF: function(a, b, c){                   
	    var d= this.sm.getSelected().data;
	    Phx.CP.loadingShow();            
	    if(d){
	    	Ext.Ajax.request({
		        url:'../../sis_ventas/control/PedidoDet/gestionarWF',
		        params:{id_pedido_det:d.id_pedido_det,operacion:'verificar'},
		        success:this.onGestionarWF,
		        failure: this.conexionFailure,
		        timeout:this.timeout,
		        scope:this
		    }); 
	    } else{
	    	alert('Debe seleccionar un registro')
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
					url:'../../sis_ventas/control/PedidoDet/gestionarWF',
				  	params:{
				  		id_pedido_det: d.id_pedido_det,
				  		operacion: this.operacion,
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
	onWF: function(res){
		//Llama a la función para ir al siguiente estado
   		Phx.CP.loadingShow(); 
   		var d= this.sm.getSelected().data;
		Ext.Ajax.request({
			url:'../../sis_ventas/control/PedidoDet/gestionarWF',
		  	params:{
		  		id_movimiento:d.id_movimiento,
		  		operacion:this.operacion,
		  		id_tipo_estado: this.cmbTipoEstWF.getValue(),
		  		id_funcionario_wf:this.cmbFunWF.getValue(),
		  		id_almacen: d.id_almacen,
		  		obs: this.txtObs.getValue()
		      },
		      success:this.successFinSol,
		      failure: this.conexionFailure,
		      timeout:this.timeout,
		      scope:this
		});
	},

	operacion: 'siguiente',
	
	calcularRelPrecioVol: function(pAltura,pLargo,pAncho){
		var alt,largo,ancho,rel;
		alt=pAltura;
		largo=pLargo;
		ancho=pAncho;
		if(isNaN(pAltura)){
			alt=0;
		}
		if(isNaN(pLargo)){
			largo=0;
		}
		if(isNaN(pAncho)){
			ancho=0;
		}
		rel = (alt*largo*ancho)/365*2.2;
		return rel;
	}
	
})
</script>
		
		