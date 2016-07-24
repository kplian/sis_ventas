<?php
/**
*@package pXP
*@file gen-MODCliente.php
*@author  (admin)
*@date 05-11-2013 00:29:31
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCliente extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCliente(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_cliente_sel';
		$this->transaccion='VEN_CLIENT_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_cliente','int4');
		$this->captura('id_persona','int4');
		$this->captura('codigo_hash','varchar');
		$this->captura('nit_factura','varchar');
		$this->captura('estado','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_institucion','int4');
		$this->captura('codigo','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_persona','text');
		$this->captura('desc_institucion','varchar');
		$this->captura('persona_inst','varchar');
		
		$this->captura('doc_id','varchar');
		$this->captura('email','varchar');
		$this->captura('telefono1','varchar');
		$this->captura('telefono2','varchar');
		$this->captura('celular1','varchar');
		$this->captura('celular2','varchar');
		$this->captura('nombre_cliente','varchar');
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCliente(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_cliente_ime';
		$this->transaccion='VEN_CLIENT_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('codigo_hash','codigo_hash','varchar');
		$this->setParametro('nit_factura','nit_factura','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_institucion','id_institucion','int4');
		$this->setParametro('codigo','codigo','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCliente(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_cliente_ime';
		$this->transaccion='VEN_CLIENT_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cliente','id_cliente','int4');
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('codigo_hash','codigo_hash','varchar');
		$this->setParametro('nit_factura','nit_factura','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_institucion','id_institucion','int4');
		$this->setParametro('codigo','codigo','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCliente(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_cliente_ime';
		$this->transaccion='VEN_CLIENT_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cliente','id_cliente','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
				
}
?>