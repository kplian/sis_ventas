<?php
/**
*@package pXP
*@file gen-ACTPedidoDet.php
*@author  (admin)
*@date 05-11-2013 06:34:29
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

require_once(dirname(__FILE__).'/../reportes/pxpReport/ReportWriter.php');
require_once(dirname(__FILE__).'/../reportes/RCodigoBarras.php');
require_once(dirname(__FILE__).'/../reportes/pxpReport/DataSource.php');

class ACTPedidoDet extends ACTbase{    
			
	function listarPedidoDet(){
		$this->objParam->defecto('ordenacion','id_pedido_det');
		$this->objParam->defecto('dir_ordenacion','asc');
		
		//Filtros
		if($this->objParam->getParametro('id_pedido')!=''){
			$this->objParam->addFiltro("detped.id_pedido = ".$this->objParam->getParametro('id_pedido'));	
		}
		if($this->objParam->getParametro('id_pedido_det')!=''){
			$this->objParam->addFiltro("detped.id_pedido_det = ".$this->objParam->getParametro('id_pedido_det'));	
		}
		if($this->objParam->getParametro('id_envio')!=''){
			$this->objParam->addFiltro("detped.id_envio = ".$this->objParam->getParametro('id_envio'));	
		}
		if($this->objParam->getParametro('estado')!=''){
			$this->objParam->addFiltro("detped.estado = ''".$this->objParam->getParametro('estado')."''");	
		}

		//Llamada al modelo
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPedidoDet','listarPedidoDet');
		} else{
			$this->objFunc=$this->create('MODPedidoDet');
			
			$this->res=$this->objFunc->listarPedidoDet($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPedidoDet(){
		$this->objFunc=$this->create('MODPedidoDet');	
		if($this->objParam->insertar('id_pedido_det')){
			$this->res=$this->objFunc->insertarPedidoDet($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPedidoDet($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPedidoDet(){
			$this->objFunc=$this->create('MODPedidoDet');	
		$this->res=$this->objFunc->eliminarPedidoDet($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function reporteCodigoBarras() {
		$dataSource = new DataSource();
		
		//Obtención de los datos del registro de PEdidoDet a partir del id_pedido_det
		
		$this->objParam->addFiltro("detped.id_pedido_det = ".$this->objParam->getParametro('id_pedido_det'));
		$this->objFunc = $this->create('MODPedidoDet');
		$datos = $this->objFunc->listarPedidoDet($this->objParam);
		$fila = $datos->getDatos();
		//var_dump($fila);
		
		//Se setea el datasource
		$dataSource->putParameter('codigo', $fila[0]['codigo']);
		
		//Generación del reporte
		$reporte = new RCodigoBarras();
		$reporte->setDataSource($dataSource);
		$nombreArchivo = 'pedido_det_codigo_barras_'.rand(0, 100000).'.pdf';  
		$reportWriter = new ReportWriter($reporte, dirname(__FILE__).'/../../reportes_generados/'.$nombreArchivo);
		$reportWriter->writeReport(ReportWriter::PDF);
		
		$mensajeExito = new Mensaje();
		$mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado',
										'Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->res = $mensajeExito;
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarEnvioDet(){
		$this->objFunc=$this->create('MODPedidoDet');	
		$this->res=$this->objFunc->insertarEnvioDet($this->objParam);			
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarEnvioDet(){
		$this->objFunc=$this->create('MODPedidoDet');	
		$this->res=$this->objFunc->eliminarEnvioDet($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function listarProducto(){
		$this->objParam->defecto('ordenacion','id_pedido_det');
		$this->objParam->defecto('dir_ordenacion','asc');
		
		//Llamada al modelo
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPedidoDet','listarProdcuto');
		} else{
			$this->objFunc=$this->create('MODPedidoDet');
			
			$this->res=$this->objFunc->listarProducto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function listarPedidoDetIdent(){
		$this->objParam->defecto('ordenacion','id_pedido_det');
		$this->objParam->defecto('dir_ordenacion','asc');
		
		//Filtros
		if($this->objParam->getParametro('id_pedido')!=''){
			$this->objParam->addFiltro("detped.id_pedido = ".$this->objParam->getParametro('id_pedido'));	
		}
		if($this->objParam->getParametro('id_pedido_det')!=''){
			$this->objParam->addFiltro("detped.id_pedido_det = ".$this->objParam->getParametro('id_pedido_det'));	
		}
		if($this->objParam->getParametro('id_envio')!=''){
			$this->objParam->addFiltro("detped.id_envio = ".$this->objParam->getParametro('id_envio'));	
		}
		if($this->objParam->getParametro('estado')!=''){
			$this->objParam->addFiltro("detped.estado = ''".$this->objParam->getParametro('estado')."''");	
		}

		if($this->objParam->getParametro('estado1')!=''){
			$this->objParam->addFiltro("detped.estado in (''".$this->objParam->getParametro('estado1')."'',''".$this->objParam->getParametro('estado2')."'')");	
		}
		
		//Llamada al modelo
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPedidoDet','listarPedidoDetIdent');
		} else{
			$this->objFunc=$this->create('MODPedidoDet');
			$this->res=$this->objFunc->listarPedidoDetIdent($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function gestionarWF(){
		$this->objFunc=$this->create('MODPedidoDet');	
		$this->res=$this->objFunc->gestionarWF($this->objParam);			
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>