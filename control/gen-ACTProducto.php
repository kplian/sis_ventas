<?php
/**
*@package pXP
*@file gen-ACTProducto.php
*@author  (admin)
*@date 15-11-2013 23:40:58
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTProducto extends ACTbase{    
			
	function listarProducto(){
		$this->objParam->defecto('ordenacion','id_producto');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODProducto','listarProducto');
		} else{
			$this->objFunc=$this->create('MODProducto');
			
			$this->res=$this->objFunc->listarProducto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarProducto(){
		$this->objFunc=$this->create('MODProducto');	
		if($this->objParam->insertar('id_producto')){
			$this->res=$this->objFunc->insertarProducto($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarProducto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarProducto(){
			$this->objFunc=$this->create('MODProducto');	
		$this->res=$this->objFunc->eliminarProducto($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>