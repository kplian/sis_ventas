<?php
/**
*@package pXP
*@file gen-ACTEnvio.php
*@author  (admin)
*@date 21-11-2013 19:20:49
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTEnvio extends ACTbase{    
			
	function listarEnvio(){
		$this->objParam->defecto('ordenacion','id_envio');
		$this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEnvio','listarEnvio');
		} else{
			$this->objFunc=$this->create('MODEnvio');
			
			$this->res=$this->objFunc->listarEnvio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarEnvio(){
		$this->objFunc=$this->create('MODEnvio');	
		if($this->objParam->insertar('id_envio')){
			$this->res=$this->objFunc->insertarEnvio($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarEnvio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarEnvio(){
			$this->objFunc=$this->create('MODEnvio');	
		$this->res=$this->objFunc->eliminarEnvio($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>