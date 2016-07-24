<?php
/**
*@package pXP
*@file gen-MODEnvio.php
*@author  (admin)
*@date 21-11-2013 19:20:49
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODEnvio extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarEnvio(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_envio_sel';
		$this->transaccion='VEN_ENVMER_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_envio','int4');
		$this->captura('fecha','date');
		$this->captura('id_persona_dest','int4');
		$this->captura('codigo','varchar');
		$this->captura('observaciones','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_sucursal','int4');
		$this->captura('medio','varchar');
		$this->captura('id_persona_rmte','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_proveedor','varchar');
		$this->captura('desc_persona_rmte','text');
		$this->captura('desc_persona_dest','text');
		$this->captura('desc_sucursal','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarEnvio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_envio_ime';
		$this->transaccion='VEN_ENVMER_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_persona_dest','id_persona_dest','int4');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('observaciones','observaciones','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('medio','medio','varchar');
		$this->setParametro('id_persona_rmte','id_persona_rmte','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarEnvio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_envio_ime';
		$this->transaccion='VEN_ENVMER_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_envio','id_envio','int4');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_persona_dest','id_persona_dest','int4');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('observaciones','observaciones','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('medio','medio','varchar');
		$this->setParametro('id_persona_rmte','id_persona_rmte','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarEnvio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_envio_ime';
		$this->transaccion='VEN_ENVMER_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_envio','id_envio','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>