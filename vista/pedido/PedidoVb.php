<?php
/**
*@package pXP
*@file MovimientoVb.php
*@author  RCM
*@date 20/11/2013
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PedidoVb = {
	//bedit:false,
    bnew:false,
    bsave:false,
    //bdel:false,
	require:'../../../sis_ventas/vista/pedido/Pedido.php',
	requireclase:'Phx.vista.Pedido',
	title:'Visto Bueno Pedido',
	nombreVista: 'pedidoVb',
	
	constructor: function(config) {
	    this.maestro=config.maestro;
		Phx.vista.PedidoVb.superclass.constructor.call(this,config);
    	this.addButton('ini_estado',{argument: {operacion: 'inicio'},text:'Dev. a Borrador',iconCls: 'batras',disabled:true,handler:this.retroceder,tooltip: '<b>Retorna el Pedido al estado inicial</b>'});
	    this.addButton('ant_estado',{argument: {operacion: 'anterior'},text:'Anterior',iconCls: 'batras',disabled:true,handler:this.retroceder,tooltip: '<b>Pasar al Anterior Estado</b>'});
	    //Botón de finalización
    	this.addButton('btnFin',{text:'Siguiente',iconCls: 'badelante',disabled:true,handler:this.gestionarWF,tooltip: '<b>Continuar con estado siguiente</b>'});
	    //Oculta botones 
	    this.getBoton('edit').hide();
	    this.getBoton('del').hide();
	    
	    this.store.baseParams={tipo_interfaz:this.nombreVista};
	    this.load({params:{start:0, limit:this.tam_pag}});
	},
     
  	preparaMenu:function(n){
	  var tb = Phx.vista.PedidoVb.superclass.preparaMenu.call(this);
      var data = this.getSelectedData();
	  this.getBoton('ant_estado').enable();
	  this.getBoton('btnFin').enable();
	  this.getBoton('ini_estado').enable();

      return tb 
     }, 
     
     liberaMenu:function(){
        var tb = Phx.vista.PedidoVb.superclass.liberaMenu.call(this);
        this.getBoton('btnFin').disable();
        this.getBoton('ini_estado').disable();
        this.getBoton('ant_estado').disable();

        return tb
    },    
       
	retroceder: function(resp){
		var d= this.sm.getSelected().data;
		Phx.CP.loadingShow(); 
		Ext.Ajax.request({
			url:'../../sis_ventas/control/Pedido/gestionarWF',
		  	params:{
		  		id_pedido:d.id_pedido,
		  		operacion:resp.argument.operacion,
		  		//id_funcionario_wf:data.wf_id_funcionario,
		  		//id_tipo_estado: data.wf_id_tipo_estado,
		  		obs: this.txtObs.getValue()
		      },
		      success:this.successWF,
		      failure: this.conexionFailure,
		      timeout:this.timeout,
		      scope:this
		});
		
	}

};
</script>
