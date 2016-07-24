<?php
/**
*@package pXP
*@file PedidoDetIdent.php
*@author  rcm
*@date 20-09-2011 10:22:05
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PedidoDetIdent = {
	require:'../../../sis_ventas/vista/pedido_det/PedidoDetAbs.php',
	requireclase:'Phx.vista.PedidoDetAbs',
	title:'Detalle Envio',
	nombreVista: 'pedidoDetIdent',
	
	constructor:function(config){
		this.maestro=config.maestro;
		
		this.Atributos.splice(1,0,
			{
			config:{
				name: 'desc_sucursal_dest',
				fieldLabel: 'Sucursal Dest.',
				anchor: '80%',
				gwidth: 150
			},
			type:'TextField',
			filters:{pfiltro:'pedido.desc_sucursal_dest',type:'string'},
			id_grupo:0,
			grid:true
		});
		
		this.Atributos.splice(1,0,
			{
			config:{
				name: 'desc_sucursal',
				fieldLabel: 'Sucursal',
				anchor: '80%',
				gwidth: 150
			},
			type:'TextField',
			filters:{pfiltro:'pedido.desc_sucursal',type:'string'},
			id_grupo:0,
			grid:true
		});
		
		this.Atributos.splice(1,0,
			{
			config:{
				name: 'destinatario',
				fieldLabel: 'Destinatario',
				anchor: '80%',
				gwidth: 150
			},
			type:'TextField',
			filters:{pfiltro:'pedido.destinatario',type:'string'},
			id_grupo:0,
			grid:true
		});
		
		this.Atributos.splice(1,0,
			{
			config:{
				name: 'desc_cliente',
				fieldLabel: 'Cliente',
				anchor: '80%',
				gwidth: 150
			},
			type:'TextField',
			filters:{pfiltro:'pedido.desc_cliente',type:'string'},
			id_grupo:0,
			grid:true
		});
		
		this.Atributos.splice(1,0,
			{
			config:{
				name: 'nro_pedido',
				fieldLabel: 'Nro.Pedido',
				anchor: '80%',
				gwidth: 150
			},
			type:'TextField',
			filters:{pfiltro:'pedido.codigo',type:'string'},
			id_grupo:0,
			grid:true
		});
		
		this.Atributos.splice(1,0,
			{
			config:{
				name: 'fecha',
				fieldLabel: 'Fecha',
				anchor: '80%',
				gwidth: 90,
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'TextField',
			filters:{pfiltro:'pedido.fecha',type:'date'},
			id_grupo:0,
			grid:true
		});

		//llama al constructor de la clase padre
		Phx.vista.PedidoDetIdent.superclass.constructor.call(this,config);
		this.init();
		Ext.apply(this.store.baseParams,{estado1:'solicitado',estado2:'adquirido'})
		this.load({params:{start:0, limit:this.tam_pag}})
		
		//Eventos
		this.iniciarEventos();
		this.blockGroup(0);
		//Botones
		this.addButton('btnRepCodigoBarras', {
				text : 'Código Barras',
				iconCls : 'bassign',
				disabled : true,
				handler : this.repCodigoBarras,
				tooltip : '<b>Impresión de Código de Barras</b>'
			});
				 
		//Agrega botones para cambiar estados
	    this.addButton('btnEstadoAnt',{text:'Corregir',iconCls: 'batras',disabled:true,handler:this.onBtnEstadoAnt,tooltip: '<b>Corregir la identificación</b>'});
	    this.addButton('btnFin',{text:'Listo',iconCls: 'badelante',disabled:true,handler:this.onBtnFin,tooltip: '<b>Concluir la identificación del producto</b>'});
	    
	    //Crea ventana para cambio de estados
	    this.crearVentanaWF();
	},

	preparaMenu : function(tb) {
		Phx.vista.PedidoDetIdent.superclass.preparaMenu.call(this, tb);
		var data = this.getSelectedData();
		if(data.estado=='solicitado'){
			this.getBoton('btnEstadoAnt').disable();
			this.getBoton('btnFin').enable();
		} else if(data.estado=='adquirido'){
			this.getBoton('btnEstadoAnt').enable();
			this.getBoton('btnFin').disable();
		} 
		else {
			this.getBoton('btnEstadoAnt').disable();
			this.getBoton('btnFin').disable();
		}
		this.getBoton('btnRepCodigoBarras').enable();
	},
	liberaMenu : function() {
		Phx.vista.PedidoDetIdent.superclass.liberaMenu.call(this);
		this.getBoton('btnRepCodigoBarras').disable();
		this.getBoton('btnEstadoAnt').disable();
		this.getBoton('btnFin').disable();
	},
	bnew: false,
	bdel: false,
	ActSave:'../../sis_ventas/control/PedidoDet/identificarPedidoDet',
	ActList:'../../sis_ventas/control/PedidoDet/listarPedidoDetIdent',
	
	onBtnEstadoAnt: function(){
		this.operacion='anterior';
		this.gestionarWF();
	},
	onBtnFin: function(){
		this.operacion='siguiente';
		this.gestionarWF();
	}
	

};
</script>
