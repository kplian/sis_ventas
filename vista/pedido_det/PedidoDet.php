<?php
/**
*@package pXP
*@file gen-SistemaDist.php
*@author  (fprudencio)
*@date 20-09-2011 10:22:05
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PedidoDet = {
	require:'../../../sis_ventas/vista/pedido_det/PedidoDetAbs.php',
	requireclase:'Phx.vista.PedidoDetAbs',
	title:'Detalle Envio',
	nombreVista: 'pedidoDet',
	
	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.PedidoDet.superclass.constructor.call(this,config);
		this.grid.getTopToolbar().disable();
		this.grid.getBottomToolbar().disable();
		this.init();
		
		//Eventos
		this.iniciarEventos();
		
		//Botones
		this.addButton('btnRepCodigoBarras', {
				text : 'Código Barras',
				iconCls : 'bassign',
				disabled : true,
				handler : this.repCodigoBarras,
				tooltip : '<b>Impresión de Código de Barras</b>'
			});
	},
	loadValoresIniciales:function(){
		Phx.vista.PedidoDet.superclass.loadValoresIniciales.call(this);
		this.getComponente('id_pedido').setValue(this.maestro.id_pedido);		
	},
	onReloadPage:function(m){
		this.maestro=m;						
		this.store.baseParams={id_pedido:this.maestro.id_pedido};
		this.load({params:{start:0, limit:this.tam_pag}});
		//DEshabilita/HAbilita boton de nuevo y edición
		if(this.maestro.estado=='borrador'){
			this.getBoton('edit').show();
			this.getBoton('del').show();
			this.getBoton('new').show();
			this.getBoton('save').show();
		} else{
			this.getBoton('edit').hide();
			this.getBoton('del').hide();
			this.getBoton('new').hide();
			this.getBoton('save').hide();
		}			
	},
	preparaMenu : function(tb) {
		Phx.vista.PedidoDetAbs.superclass.preparaMenu.call(this, tb);
		this.getBoton('btnRepCodigoBarras').enable();
	},
	liberaMenu : function() {
		Phx.vista.PedidoDetAbs.superclass.liberaMenu.call(this);
		this.getBoton('btnRepCodigoBarras').disable();
	},
	onButtonEdit: function(){
		Phx.vista.PedidoDet.superclass.onButtonEdit.call(this);
		this.Cmp.relacion_peso_vol.setValue(this.calcularRelPrecioVol(this.Cmp.altura.getValue(),this.Cmp.largo.getValue(),this.Cmp.ancho.getValue()));
	}

	

};
</script>
