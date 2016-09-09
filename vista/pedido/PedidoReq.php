<?php
/**
*@package pXP
*@file PedidoReq
*@author  rcm
*@date 20-09-2011 10:22:05
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PedidoReq = {
	require:'../../../sis_ventas/vista/pedido/Pedido.php',
	requireclase:'Phx.vista.Pedido',
	title:'Pedido',
	nombreVista: 'pedidoReq',
	
	constructor: function(config) {
		Phx.vista.PedidoReq.superclass.constructor.call(this,config);
		this.addButton('btnFin',{text:'Siguiente',iconCls: 'badelante',disabled:true,handler:this.gestionarWF,tooltip: '<b>Continuar con estado siguiente</b>'});
        
		this.store.baseParams={tipo_interfaz:this.nombreVista};
		this.load({params:{start:0, limit:this.tam_pag}});
		//Eventos
		this.iniciarEventos();
	},
 
	 preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
      Phx.vista.PedidoReq.superclass.preparaMenu.call(this,n);  
          
          if(data['estado']=='borrador'){
             this.getBoton('btnFin').enable();
          }
          else{
               this.getBoton('btnFin').disable();
               this.getBoton('edit').disable();
               //this.getBoton('new').disable();
               this.getBoton('del').disable();
          }
        return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.PedidoReq.superclass.liberaMenu.call(this);
        if(tb){
            this.getBoton('btnFin').disable();
        }
       return tb
    },
    
    onButtonEdit: function(){
    	Phx.vista.PedidoReq.superclass.onButtonEdit.call(this);
    	this.Cmp.saldo.setValue(this.calcularSaldo(this.Cmp.precio_total.getValue(),this.Cmp.monto_pagado.getValue()));
    }
};
</script>
