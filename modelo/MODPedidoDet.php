<?php
/**
*@package pXP
*@file gen-MODPedidoDet.php
*@author  (admin)
*@date 05-11-2013 06:34:29
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPedidoDet extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPedidoDet(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_pedido_det_sel';
		$this->transaccion='VEN_DETPED_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_pedido_det','int4');
		$this->captura('id_pedido','int4');
		$this->captura('id_item','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('id_envio','int4');
		$this->captura('codigo','varchar');
		$this->captura('estado','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('cantidad_sol','numeric');
		$this->captura('id_producto','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('observaciones','text');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_item','varchar');
		$this->captura('desc_proveedor','varchar');
		$this->captura('descripcion','text');
		$this->captura('precio_unit','numeric'); 
		$this->captura('nro_serie','varchar');
		$this->captura('marca','varchar');
		$this->captura('procedencia','varchar');
		$this->captura('peso','numeric');
		$this->captura('altura','numeric');
		$this->captura('ancho','numeric');
		$this->captura('largo','numeric');
		$this->captura('id_unidad_medida_peso','integer');
		$this->captura('id_unidad_medida_long','integer');
		$this->captura('desc_unidad_medida_peso','varchar');
		$this->captura('desc_unidad_medida_long','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		//echo $this->consulta;exit;
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarPedidoDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_pedido_det_ime';
		$this->transaccion='VEN_DETPED_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pedido','id_pedido','int4');
		$this->setParametro('id_item','id_item','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('cantidad_sol','cantidad_sol','numeric');
		$this->setParametro('estado_reg','estado_reg','varchar');
		
		
		$this->setParametro('descripcion','descripcion','text');
		$this->setParametro('precio_unit','precio_unit','numeric'); 
		$this->setParametro('nro_serie','nro_serie','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('procedencia','procedencia','varchar');
		$this->setParametro('peso','peso','numeric');
		$this->setParametro('altura','altura','numeric');
		$this->setParametro('ancho','ancho','numeric');
		$this->setParametro('largo','largo','numeric');
		$this->setParametro('id_unidad_medida_peso','id_unidad_medida_peso','integer');
		$this->setParametro('id_unidad_medida_long','id_unidad_medida_long','integer');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPedidoDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_pedido_det_ime';
		$this->transaccion='VEN_DETPED_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pedido_det','id_pedido_det','int4');
		$this->setParametro('id_pedido','id_pedido','int4');
		$this->setParametro('id_item','id_item','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('cantidad_sol','cantidad_sol','numeric');
		$this->setParametro('descripcion','descripcion','text');
		$this->setParametro('observaciones','observaciones','text');
		$this->setParametro('id_producto','id_producto','int4');
		$this->setParametro('precio_unit','precio_unit','numeric'); 
		$this->setParametro('nro_serie','nro_serie','varchar');
		$this->setParametro('marca','marca','varchar');
		$this->setParametro('procedencia','procedencia','varchar');
		$this->setParametro('peso','peso','numeric');
		$this->setParametro('altura','altura','numeric');
		$this->setParametro('ancho','ancho','numeric');
		$this->setParametro('largo','largo','numeric');
		$this->setParametro('id_unidad_medida_peso','id_unidad_medida_peso','integer');
		$this->setParametro('id_unidad_medida_long','id_unidad_medida_long','integer');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPedidoDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_pedido_det_ime';
		$this->transaccion='VEN_DETPED_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pedido_det','id_pedido_det','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function insertarEnvioDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_pedido_det_ime';
		$this->transaccion='VEN_DETENV_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_envio','id_envio','int4');
		$this->setParametro('id_pedido_det','id_pedido_det','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarEnvioDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ven.ft_pedido_det_ime';
		$this->transaccion='VEN_DETENV_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pedido_det','id_pedido_det','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function listarProducto(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_pedido_det_sel';
		$this->transaccion='VEN_PROD_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_pedido_det','int4');
		$this->captura('id_pedido','int4');
		$this->captura('id_item','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('id_envio','int4');
		$this->captura('codigo','varchar');
		$this->captura('estado','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('cantidad_sol','numeric');
		$this->captura('id_producto','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('observaciones','text');
		$this->captura('desc_item','varchar');
		$this->captura('desc_proveedor','varchar');
		$this->captura('descripcion','text');
		$this->captura('precio_unit','numeric'); 
		$this->captura('nro_serie','varchar');
		$this->captura('marca','varchar');
		$this->captura('procedencia','varchar');
		$this->captura('peso','numeric');
		$this->captura('altura','numeric');
		$this->captura('ancho','numeric');
		$this->captura('largo','numeric');
		$this->captura('pedido_codigo','varchar');
        $this->captura('desc_cliente','varchar');
        $this->captura('desc_sucursal','varchar');
		$this->captura('fecha','date');		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		//echo $this->consulta;exit;
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarPedidoDetIdent(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ven.ft_pedido_det_sel';
		$this->transaccion='VEN_PEDIDE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_pedido_det','int4');
		$this->captura('id_pedido','int4');
		$this->captura('id_item','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('id_envio','int4');
		$this->captura('codigo','varchar');
		$this->captura('estado','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('cantidad_sol','numeric');
		$this->captura('id_producto','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('observaciones','text');
		$this->captura('desc_item','varchar');
		$this->captura('desc_proveedor','varchar');
		$this->captura('descripcion','text');
		$this->captura('precio_unit','numeric'); 
		$this->captura('nro_serie','varchar');
		$this->captura('marca','varchar');
		$this->captura('procedencia','varchar');
		$this->captura('peso','numeric');
		$this->captura('altura','numeric');
		$this->captura('ancho','numeric');
		$this->captura('largo','numeric');
		$this->captura('desc_sucursal_dest','varchar');
		$this->captura('desc_sucursal','varchar');
		$this->captura('destinatario','varchar');
		$this->captura('desc_cliente','varchar');
		$this->captura('nro_pedido','varchar');
		$this->captura('fecha','date');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		//echo $this->consulta;exit;
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

	function gestionarWF(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ven.ft_pedido_det_ime';
        $this->transaccion='VEN_DETPED_WF';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
        $this->setParametro('id_pedido_det','id_pedido_det','int4');
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