<?php
/**
*@package pXP
*@file EnvioEst.php
*@author  rcm
*@date 28/11/2013
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EnvioEst = {
	require:'../../../sis_ventas/vista/envio/Envio.php',
	requireclase:'Phx.vista.Envio',
	title:'Estados Envíos',
	nombreVista: 'envioEst',
	
	constructor: function(config) {
		Phx.vista.EnvioEst.superclass.constructor.call(this,config);
        this.iniciarEventos();
		this.store.baseParams={tipo_interfaz:this.nombreVista};
		this.load({params:{start:0, limit:this.tam_pag}});
	},
 
	preparaMenu:function(n){
    	var data = this.getSelectedData();
      	var tb =this.tbar;
    	Phx.vista.EnvioEst.superclass.preparaMenu.call(this,n);  
          
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
        var tb = Phx.vista.EnvioEst.superclass.liberaMenu.call(this);
        if(tb){
            this.getBoton('btnFin').disable();
        }
       return tb
    },
    
    onButtonEdit: function(){
    	Phx.vista.EnvioEst.superclass.onButtonEdit.call(this);
    	this.Cmp.saldo.setValue(this.calcularSaldo(this.Cmp.precio_total.getValue(),this.Cmp.monto_pagado.getValue()));
    }
};
</script>
