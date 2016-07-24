<?php
/**
*@package pXP
*@file gen-MODProducto.php
*@author  (admin)
*@date 15-11-2013 23:40:58
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODProducto extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarProducto(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_producto_sel';
		$this->transaccion='VEN_PROD_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_producto','int4');
		$this->captura('precio_unit','numeric');
		$this->captura('altura','numeric');
		$this->captura('ancho','numeric');
		$this->captura('descripcion','text');
		$this->captura('codigo','varchar');
		$this->captura('largo','numeric');
		$this->captura('procedencia','varchar');
		$this->captura('nro_serie','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_unidad_medida_peso','int4');
		$this->captura('marca','varchar');
		$this->captura('id_unidad_medida_long','int4');
		$this->captura('id_item','int4');
		$this->captura('peso','numeric');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
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
			
	function insertarProducto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_producto_ime';
		$this->transaccion='VEN_PROD_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('precio_unit','precio_unit','numeric');
		$this->setParametro('altura','altura','numeric');
		$this->setParametro('ancho','ancho','numeric');
		$this->setParametro('descripcion','descripcion','text');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('largo','largo','numeric');
		$this->setParametro('procedencia','procedencia','varchar');
		$this->setParametro('nro_serie','nro_serie','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_unidad_medida_peso','id_unidad_medida_peso','int4');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('id_unidad_medida_long','id_unidad_medida_long','int4');
		$this->setParametro('id_item','id_item','int4');
		$this->setParametro('peso','peso','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarProducto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_producto_ime';
		$this->transaccion='VEN_PROD_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_producto','id_producto','int4');
		$this->setParametro('precio_unit','precio_unit','numeric');
		$this->setParametro('altura','altura','numeric');
		$this->setParametro('ancho','ancho','numeric');
		$this->setParametro('descripcion','descripcion','text');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('largo','largo','numeric');
		$this->setParametro('procedencia','procedencia','varchar');
		$this->setParametro('nro_serie','nro_serie','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_unidad_medida_peso','id_unidad_medida_peso','int4');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('id_unidad_medida_long','id_unidad_medida_long','int4');
		$this->setParametro('id_item','id_item','int4');
		$this->setParametro('peso','peso','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarProducto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_producto_ime';
		$this->transaccion='VEN_PROD_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_producto','id_producto','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>