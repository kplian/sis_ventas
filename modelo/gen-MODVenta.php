<?php
/**
*@package pXP
*@file gen-MODVenta.php
*@author  (admin)
*@date 08-12-2013 03:17:19
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODVenta extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarVenta(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_venta_sel';
		$this->transaccion='VEN_VEN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_venta','int4');
		$this->captura('id_cliente','int4');
		$this->captura('id_moneda','int4');
		$this->captura('fac_nit','varchar');
		$this->captura('id_factura','int4');
		$this->captura('fac_nro_autoriz','varchar');
		$this->captura('fac_nro','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('nit_factura','int4');
		$this->captura('estado','varchar');
		$this->captura('fecha','date');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarVenta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_venta_ime';
		$this->transaccion='VEN_VEN_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cliente','id_cliente','int4');
		$this->setParametro('id_moneda','id_moneda','int4');
		$this->setParametro('fac_nit','fac_nit','varchar');
		$this->setParametro('id_factura','id_factura','int4');
		$this->setParametro('fac_nro_autoriz','fac_nro_autoriz','varchar');
		$this->setParametro('fac_nro','fac_nro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nit_factura','nit_factura','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('fecha','fecha','date');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarVenta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_venta_ime';
		$this->transaccion='VEN_VEN_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_venta','id_venta','int4');
		$this->setParametro('id_cliente','id_cliente','int4');
		$this->setParametro('id_moneda','id_moneda','int4');
		$this->setParametro('fac_nit','fac_nit','varchar');
		$this->setParametro('id_factura','id_factura','int4');
		$this->setParametro('fac_nro_autoriz','fac_nro_autoriz','varchar');
		$this->setParametro('fac_nro','fac_nro','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nit_factura','nit_factura','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('fecha','fecha','date');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarVenta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_venta_ime';
		$this->transaccion='VEN_VEN_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_venta','id_venta','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>