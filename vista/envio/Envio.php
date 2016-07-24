<?php
/**
*@package pXP
*@file gen-Envio.php
*@author  (admin)
*@date 21-11-2013 19:20:49
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Envio=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Envio.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
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
				name: 'fecha',
				fieldLabel: 'Fecha',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'envmer.fecha',type:'date'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Nro.Despacho',
				allowBlank: true,
				anchor: '50%',
				gwidth: 100,
				maxLength:20
			},
			type:'TextField',
			filters:{pfiltro:'envmer.codigo',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Descripción',
				allowBlank: false,
				anchor: '100%',
				gwidth: 100,
				maxLength:1000
			},
			type:'TextArea',
			filters:{pfiltro:'envmer.descripcion',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config: {
				name: 'medio',
				fieldLabel: 'Medio',
				anchor: '100%',
				tinit: false,
				allowBlank: false,
				origen: 'CATALOGO',
				gdisplayField: 'medio',
				gwidth: 100,
				baseParams:{
						cod_subsistema:'VEN',
						catalogo_tipo:'tenvio__medio'
				},
				renderer:function (value, p, record){return String.format('{0}', record.data['medio']);}
			},
			type: 'ComboRec',
			id_grupo: 1,
			filters:{pfiltro:'envmer.medio',type:'string'},
			grid: true,
			form: true
		},
		{
			config:{
	       		    name:'id_proveedor',
	   				origen:'PROVEEDOR',
	   				allowBlank:true,
	   				fieldLabel:'Transportadora',
	   				emptyText: 'Elija la empresa transportadora...',
	   				gdisplayField:'desc_proveedor',
	   				gwidth:200,
	   				width:'100%',
		   			renderer:function (value, p, record){return String.format('{0}',record.data['desc_proveedor']);}
	       	     },
	   			type:'ComboRec',
	   			id_grupo:0,
	   			filters:{	
			        pfiltro:'pro.codigo#pro.desc_proveedor',
					type:'string'
				},
	   		   
	   			grid:true,
	   			form:true
	   	},	
	   	{
			config:{
	       		    name:'id_persona_rmte',
	   				origen:'PERSONA',
	   				allowBlank:true,
	   				fieldLabel:'Remitente',
	   				gdisplayField:'desc_persona_rmte',
	   				gwidth:200,
		   			renderer:function (value, p, record){return String.format('{0}',record.data['desc_persona_rmte']);}
	       	     },
	   			type:'ComboRec',
	   			id_grupo:0,
	   			filters:{	
			        pfiltro:'per.nombre_completo1',
					type:'string'
				},
	   		   
	   			grid:true,
	   			form:true
	   	},
	   	{
	   			config:{
	   				sysorigen:'sis_ventas',
	       		    name:'id_sucursal',
	       		    label: 'Sucursal destino',
	   				origen:'SUCURSAL',
	   				allowBlank:false,
	   				fieldLabel:'Sucursal',
	   				gdisplayField:'desc_sucursal',//mapea al store del grid
	   				gwidth:200,
		   			renderer:function (value, p, record){return String.format('{0}',record.data['desc_sucursal']);}
	       	     },
	   			type:'ComboRec',
	   			id_grupo:0,
	   			filters:{	
			        pfiltro:'suc.descripcion#suc.codigo',
					type:'string'
				},
	   		   
	   			grid:true,
	   			form:true
	   	},		
	   	{
			config:{
	       		    name:'id_persona_dest',
	   				origen:'PERSONA',
	   				allowBlank:false,
	   				fieldLabel:'Destinatario',
	   				gdisplayField:'desc_persona_dest',
	   				gwidth:200,
		   			renderer:function (value, p, record){return String.format('{0}',record.data['desc_persona_dest']);}
	       	     },
	   			type:'ComboRec',
	   			id_grupo:0,
	   			filters:{	
			        pfiltro:'per1.nombre_completo1',
					type:'string'
				},
	   		   
	   			grid:true,
	   			form:true
	   	},	
		
		{
			config:{
				name: 'observaciones',
				fieldLabel: 'Observaciones',
				allowBlank: true,
				anchor: '100%',
				gwidth: 200,
				maxLength:2000
			},
				type:'TextArea',
				filters:{pfiltro:'envmer.observaciones',type:'string'},
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
				filters:{pfiltro:'envmer.estado_reg',type:'string'},
				id_grupo:1,
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
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
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
				filters:{pfiltro:'envmer.fecha_reg',type:'date'},
				id_grupo:1,
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
				id_grupo:1,
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
				filters:{pfiltro:'envmer.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Envío de Mercadería',
	ActSave:'../../sis_ventas/control/Envio/insertarEnvio',
	ActDel:'../../sis_ventas/control/Envio/eliminarEnvio',
	ActList:'../../sis_ventas/control/Envio/listarEnvio',
	id_store:'id_envio',
	fields: [
		{name:'id_envio', type: 'numeric'},
		{name:'fecha', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_persona_dest', type: 'numeric'},
		{name:'codigo', type: 'string'},
		{name:'observaciones', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_sucursal', type: 'numeric'},
		{name:'medio', type: 'string'},
		{name:'id_persona_rmte', type: 'numeric'},
		{name:'id_proveedor', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_proveedor', type: 'string'},
		{name:'desc_persona_rmte', type: 'string'},
		{name:'desc_persona_dest', type: 'string'},
		{name:'desc_sucursal', type: 'string'}
		
	],
	sortInfo:{
		field: 'id_envio',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	south:{
		  url:'../../../sis_ventas/vista/pedido_det/PedidoDetEnv.php',
		  title:'Detalle Envío', 
		  height:'50%',
		  cls:'PedidoDetEnv'
	},
})
</script>
		
		