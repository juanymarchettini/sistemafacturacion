<?php
	App::import('Vendor', 'TCPDF/tcpdf');
// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'img/pdf/logo.png';
        $this->Image($image_file, 10, 10, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(60,9,'',0,1);
        $this->Cell(0, 0, 'LISTA DE PRECIOS '.date('d-m-Y') , 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        
		$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(137, 137, 137));
		$this->Line(10, 30, 202, 30, $style);
		

    }

    // Page footer
    public function Footer() {
        // Position at 12 mm from bottom
        $this->SetY(-12);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 0, 'Email: overallbb@hotmail.com - Tel: 291 -156451450 - www.tiendaoverall.com.ar -   '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TiendaOverall.com.ar');
$pdf->SetTitle('Lista de Precios');
$pdf->SetSubject('TiendaOverall.com.ar');
$pdf->SetKeywords('Overall, Saphirus, aromatizadores, fragancia, perfumes');

// set default header data

$pdf->setFooterData('Las Heras 164 - Bahía Blanca - Te: 0291-4552514 - email: servicio@electrofisiologia.com.ar',array(0,64,0), array(0,64,128));



// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, PDF_MARGIN_TOP+5 , 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 9, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect


// Set some content to print



$pdf->Ln(5);

$pacientehtml='<p>(**) Los precios son por el total de productos de la categoria</p>';
$pacientehtml.='<p>Todos los precios estan sujetos a cambios sin previo aviso</p>';

$pdf->writeHTML($pacientehtml,1);
//$pdf->writeHTMLCell(0, 10, '', '', $pacientehtml, 0, 1, 0, true, 'L', true);

$pdf->Ln(3);

// GENERACIÓN DE LA TABLA

$pdf->SetFillColor(100, 100, 255);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0, 0, 255);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');




        
foreach ($categorias as $catseccion) {
	$pdf->SetFillColor(100, 100, 255);
	$pdf->SetTextColor(255);
	$pdf->SetDrawColor(0, 0, 255);
	$pdf->SetFont('', 'B');
	$pdf->Cell(64, 7, $catseccion['Categoria']['nombre'], 1, 0, 'L', 1);
	
	if (empty($catseccion['Subcategoria'])){
		 // GENERO LOS LABEL DESDE HASTA
		 foreach ($catseccion['Preciosproducto'] as $labelrangos) {
		 	$pdf->Cell(18, 7, $labelrangos['descripcion'], 1, 0, 'C', 1);
		 }
		 $pdf->Ln();
		 
		 $pdf->SetFillColor(255, 255, 255);
		 $pdf->SetTextColor(3);
		 $pdf->SetDrawColor(0, 0, 0);	
		 $pdf->SetFont('', '');

		 if (!empty($catseccion['Categoria']['descripcion'])){
		 	$pdf->Cell(190, 7, 'NOTA IMPORTANTE: '.$catseccion['Categoria']['descripcion'], 1, 0, 'L', 1);
		 	$pdf->Ln();
		 }
		 $pdf->SetTextColor(0);
		 $pdf->Cell(64, 7, $catseccion['Categoria']['nombre'], 1, 0, 'L', 1);
		 foreach ($catseccion['Preciosproducto'] as $precios) {
		 	$pdf->Cell(18, 7, '$'.$precios['precio'], 1, 0, 'C', 1);
		 }
	}else{
		$printlabel=true;
		foreach ($catseccion['Subcategoria'] as $subcategoria) {
			if ($subcategoria['disponible'] == true){
				// GENERO LOS LABEL DESDE HASTA
				if ($printlabel){
					foreach ($subcategoria['Preciosproducto'] as $labelrangos) {
						$pdf->Cell(18, 7, $labelrangos['descripcion'], 1, 0, 'C', 1);	
					}
					if (!empty($catseccion['Categoria']['descripcion'])){
						$pdf->Ln();
						$pdf->SetFillColor(255, 255, 255);
						$pdf->SetTextColor(0);
						$pdf->SetDrawColor(0, 0, 0);	
						$pdf->SetFont('', '');
					 	$pdf->Cell(190, 7,'NOTA IMPORTANTE: '.$catseccion['Categoria']['descripcion'], 1, 0, 'L', 1);
					 	
					 }
				}
				 $printlabel=false;
				 $pdf->Ln();
				 $pdf->SetFillColor(255, 255, 255);
				 $pdf->SetTextColor(0);
				 $pdf->SetDrawColor(0, 0, 0);	
				 $pdf->SetFont('', '');
				 
				 $pdf->Cell(64, 7, $subcategoria['nombre'], 1, 0, 'L', 1);
				 foreach ($subcategoria['Preciosproducto'] as $precios) {
				 	$pdf->Cell(18, 7, '$'.$precios['precio'], 1, 0, 'C', 1);
				 }
			}
		}
	}

	$pdf->Ln();	
		
}







// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Lista de Precios'.'-'.date('d-m-Y').'.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
?>