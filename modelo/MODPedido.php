<?php
/**
*@package pXP
*@file gen-MODPedido.php
*@author  (admin)
*@date 05-11-2013 06:34:26
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPedido extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPedido(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_pedido_sel';
		$this->transaccion='VEN_PEDIDO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_pedido','int4');
		$this->captura('id_sucursal','int4');
		$this->captura('id_cliente','int4');
		$this->captura('id_moneda','int4');
		$this->captura('forma_pago','varchar');
		$this->captura('estado','varchar');
		$this->captura('fecha','date');
		$this->captura('codigo','varchar');
		$this->captura('tipo_pago','varchar');
		$this->captura('monto_pagado','numeric');
		$this->captura('precio_total','numeric');
		$this->captura('estado_reg','varchar');
		$this->captura('destinatario','varchar');
		$this->captura('direccion','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_sucursal','varchar');
		$this->captura('desc_cliente','varchar');
		$this->captura('desc_moneda','varchar');
		$this->captura('id_sucursal_dest','int4');
		$this->captura('id_lugar','int4');
		$this->captura('telf_destinatario','varchar');
		$this->captura('obs_destinatario','varchar');
		$this->captura('desc_sucursal_dest','varchar');
		$this->captura('desc_lugar','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarPedido(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_pedido_ime';
		$this->transaccion='VEN_PEDIDO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_cliente','id_cliente','int4');
		$this->setParametro('id_moneda','id_moneda','int4');
		$this->setParametro('forma_pago','forma_pago','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('tipo_pago','tipo_pago','varchar');
		$this->setParametro('monto_pagado','monto_pagado','numeric');
		$this->setParametro('precio_total','precio_total','numeric');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('destinatario','destinatario','varchar');
		$this->setParametro('direccion','direccion','varchar');
		$this->setParametro('id_sucursal_dest','id_sucursal_dest','int4');
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('telef_destinatario','telef_destinatario','varchar');
		$this->setParametro('obs_destinatario','obs_destinatario','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPedido(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_pedido_ime';
		$this->transaccion='VEN_PEDIDO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pedido','id_pedido','int4');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_cliente','id_cliente','int4');
		$this->setParametro('id_moneda','id_moneda','int4');
		$this->setParametro('forma_pago','forma_pago','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('tipo_pago','tipo_pago','varchar');
		$this->setParametro('monto_pagado','monto_pagado','numeric');
		$this->setParametro('precio_total','precio_total','numeric');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('destinatario','destinatario','varchar');
		$this->setParametro('direccion','direccion','varchar');
		$this->setParametro('id_sucursal_dest','id_sucursal_dest','int4');
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('telef_destinatario','telef_destinatario','varchar');
		$this->setParametro('obs_destinatario','obs_destinatario','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPedido(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_pedido_ime';
		$this->transaccion='VEN_PEDIDO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pedido','id_pedido','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function gestionarWF(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ven.ft_pedido_ime';
        $this->transaccion='VEN_PEDIDO_WF';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
        $this->setParametro('id_pedido','id_pedido','int4');
        $this->setParametro('id_funcionario_usu','id_funcionario_usu','int4');
        $this->setParametro('operacion','operacion','varchar');
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('id_tipo_estado','id_tipo_estado','int4');
        $this->setParametro('obs','obs','text');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
			
}
?>