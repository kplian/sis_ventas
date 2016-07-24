<?php
/**
*@package pXP
*@file gen-MODSucursal.php
*@author  (admin)
*@date 05-11-2013 00:31:14
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSucursal extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSucursal(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_sucursal_sel';
		$this->transaccion='VEN_VENRSUC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sucursal','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('codigo','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_sucursal_ime';
		$this->transaccion='VEN_VENRSUC_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('codigo','codigo','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_sucursal_ime';
		$this->transaccion='VEN_VENRSUC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('codigo','codigo','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_sucursal_ime';
		$this->transaccion='VEN_VENRSUC_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>