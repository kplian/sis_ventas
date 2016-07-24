<?php
/**
*@package pXP
*@file gen-ACTSucursal.php
*@author  (admin)
*@date 05-11-2013 00:31:14
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSucursal extends ACTbase{    
			
	function listarSucursal(){
		$this->objParam->defecto('ordenacion','id_sucursal');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSucursal','listarSucursal');
		} else{
			$this->objFunc=$this->create('MODSucursal');
			
			$this->res=$this->objFunc->listarSucursal($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarSucursal(){
		$this->objFunc=$this->create('MODSucursal');	
		if($this->objParam->insertar('id_sucursal')){
			$this->res=$this->objFunc->insertarSucursal($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarSucursal($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarSucursal(){
			$this->objFunc=$this->create('MODSucursal');	
		$this->res=$this->objFunc->eliminarSucursal($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>