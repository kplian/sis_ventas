<?php
/**
*@package pXP
*@file gen-ACTPedido.php
*@author  (admin)
*@date 05-11-2013 06:34:26
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPedido extends ACTbase{    
			
	function listarPedido(){
		$this->objParam->defecto('ordenacion','id_pedido');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPedido','listarPedido');
		} else{
			$this->objFunc=$this->create('MODPedido');
			
			$this->res=$this->objFunc->listarPedido($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPedido(){
		$this->objFunc=$this->create('MODPedido');	
		if($this->objParam->insertar('id_pedido')){
			$this->res=$this->objFunc->insertarPedido($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPedido($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPedido(){
		$this->objFunc=$this->create('MODPedido');	
		$this->res=$this->objFunc->eliminarPedido($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function gestionarWF(){
		$this->objFunc=$this->create('MODPedido');	
		$this->res=$this->objFunc->gestionarWF($this->objParam);			
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>