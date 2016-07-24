<?php
require_once dirname(__FILE__).'/pxpReport/Report.php';

 class CustomReport extends TCPDF {
	
	private $dataSource;
	
	public function setDataSource(DataSource $dataSource) {
		$this->dataSource = $dataSource;
	}
	
	public function getDataSource() {
		return $this->dataSource;
	}
	
	public function Header() {
		/*$height = 20;
		$x = $this->GetX();
		$y = $this->GetY();
		$this->SetXY($x, $y);
		$this->Cell(40, $height, '', 1, 0, 'C', false, '', 0, false, 'T', 'C');
		$this->Image(dirname(__FILE__).'/logo-ypfb-logistica.png', 16, 12, 36);
		
		$this->SetFontSize(14);
		$this->SetFont('','B');
		
		$this->Cell(105, $height/2, 'REGISTRO', 1, 2, 'C', false, '', 0, false, 'T', 'C');        
        $this->Cell(105,$height/2, 'Ficha Técnica',1,0,'C',false,'',0,false,'T','C');
        
        $this->setXY($x+145,$y);
        $this->SetFont('','');
        $this->Cell(40, $height, '', 1, 0, 'C', false, '', 0, false, 'T', 'C');
        
        
        $this->SetFontSize(7);
        
        $width1 = 17;
        $width2 = 23;
        $this->SetXY($x+145, $y);
        $this->setCellPaddings(2);
        $this->Cell($width1, $height/4, 'Código:', "B", 0, '', false, '', 0, false, 'T', 'C');
        $this->SetFont('','B');
        $this->Cell($width2, $height/4, 'GMAN-RG-SM-006', "B", 0, 'C', false, '', 0, false, 'T', 'C');
        
        $this->SetFont('','');
        $y += 5;
        $this->SetXY($x+145, $y);
        $this->setCellPaddings(2);
        $this->Cell($width1, $height/4, 'Revisión:', "B", 0, '', false, '', 0, false, 'T', 'C');
        $this->SetFont('','B');
        $this->Cell($width2, $height/4, '1.0', "B", 0, 'C', false, '', 0, false, 'T', 'C');
        
        $this->SetFont('','');
        $y += 5;
        $this->SetXY($x+145, $y);
        $this->setCellPaddings(2);
        $this->Cell($width1, $height/4, 'Fecha Emision:', "B", 0, '', false, '', 0, false, 'T', 'C');
        $this->SetFont('','B');
        $this->Cell($width2, $height/4, '26/05/2012', "B", 0, 'C', false, '', 0, false, 'T', 'C');
        
        $this->SetFont('','');
        $y += 5;
        $this->SetXY($x+145, $y);
        $this->setCellPaddings(2);
        $this->Cell($width1, $height/4, 'Página:', "B", 0, '', false, '', 0, false, 'T', 'C');
        $this->SetFont('','B');
        $this->Cell($width2, $height/4,  '                  '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), "B", 0, 'C', false, '', 0, false, 'T', 'C');*/
        
	}
	
	public function Footer() {
		/*$this->SetFontSize(5.5);
		$this->setY(-10);
		$ormargins = $this->getOriginalMargins();
		$this->SetTextColor(0, 0, 0);
		//set style for cell border
		$line_width = 0.85 / $this->getScaleFactor();
		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$ancho = round(($this->getPageWidth() - $ormargins['left'] - $ormargins['right']) / 3);
		$this->Ln(2);
		$cur_y = $this->GetY();
		//$this->Cell($ancho, 0, 'Generado por XPHS', 'T', 0, 'L');
		$this->Cell($ancho, 0, 'Usuario: '.$_SESSION['_LOGIN'], '', 1, 'L');
		$pagenumtxt = 'Página'.' '.$this->getAliasNumPage().' de '.$this->getAliasNbPages();
		//$this->Cell($ancho, 0, '', '', 0, 'C');
		$fecha_rep = date("d-m-Y H:i:s");
		$this->Cell($ancho, 0, "Fecha impresión: ".$fecha_rep, '', 0, 'L');
		$this->Ln($line_width);*/
	}
	
	public function MultiRow($pMatriz,$pWidth,$pAlign,$pVisible=array(),$pConNumeracion=1) {
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)
		$page_start = $this->getPage();
		$y_start = $this->GetY();
		
		//Obtiene el total de filas 
		$totalFilas=count($pMatriz)-1;
		$fila=0;
		
		foreach ($pMatriz as $row) {
			//Obtiene el alto máximo de la celda de toda la fila
			$i=0;
			$nb=0;
			
			$x=$this->getX();
			$y=$this->getY();
			//var_dump($this->array_unshift_assoc($fila,'nro',$fila));exit;
			foreach ($row as $value) {
				$nb=max($nb,$this->getNumLines($value,$pWidth[$i]));
				$i++;
			}
			//Define el alto máximo
			$alto=3*$nb;
			$j=0;
			$tmp=$fila+1;
			if($pConNumeracion){
				$row=$this->array_unshift_assoc($row,'nro',$tmp);	
			}
			
			//Dibuja la fila
			foreach ($row as $value) {
				if($i>0){
					$this->setXY($x,$y);
				}
				
				//Verificación de borde
				if($fila==$totalFilas){
					if($value==''){
						$borde='LRB';
					} else{
						$borde='LRTB';
					}
				} else{
					if($value==''){
						$borde='LR';
					} else{
						$borde='LRT';
					}
				}
				// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)
				$this->MultiCell($pWidth[$j], $alto, $value, $borde, $pAlign[$j], 0, 0, '', '', true, 0);
				$j++;
				$x=$this->getX();
				//$this->Ln();	
			}
			$this->Ln();
			$fila++;
		}
	}

	public function array_unshift_assoc(&$arr, $key, $val){
	    $arr = array_reverse($arr, true);
	    $arr[$key] = $val;
	    return array_reverse($arr, true);
	}
}

Class RCodigoBarras extends Report {

	function write($fileName) {
		$pdf = new CustomReport(PDF_PAGE_ORIENTATION, PDF_UNIT, "LETTER", true, 'UTF-8', false);
		$pdf->setDataSource($this->getDataSource());
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 32, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(10);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		// $pdf->setLanguageArray($l);
		
		// add a page
		$pdf->AddPage();
		
		// define barcode style
		$style = array(
			'position' => '',
			'align' => '',
			'stretch' => true,
			'fitwidth' => false,
			'cellfitalign' => '',
			'border' => true,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			//'fgcolor' => array(0,0,128),
			//'bgcolor' => array(255,255,128),
			'text' => true,
			'label' => 'EL ROBLE SYSTEMS',
			'font' => 'helvetica',
			'fontsize' => 8,
			'stretchtext' => 4
		);
		
		//$pdf->write1DBarcode($this->getDataSource()->getParameter('codigo'), 'C128', '', '', '', 18, 0.4, $style, 'N');
		$pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0)));
		$pdf->write1DBarcode($this->getDataSource()->getParameter('codigo'), 'C39E+', '', '', 120, 25, 0.4, $style, 'N');
		
		
		$pdf->Output($fileName, 'F');
	}

}
?>