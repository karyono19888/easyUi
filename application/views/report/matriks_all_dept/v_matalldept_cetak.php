<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDF extends FPDF
{    

   function Header()
    {
        
        $this->Image('assets/images/logo.jpg', 10, 5,80,11.2);
        $this->SetFont('Times','B',8);
        $this->Cell(166,4,'',0,0,'L');
        $this->Cell(20,4,'',0,0,'L');
        $this->Ln(4);
        $this->Cell(166,4,'',0,0,'L');
        $this->Cell(20,4,'',0,0,'L');
        //$pdf->Image('assets/images/logo.jpg', 30, 5,80,11.2);
        $this->Ln(7);
        $this->SetFont('Arial','B',15);
        $this->Cell(0,7,'MATRIKS KOMPETENSI ALL DEPARTEMEN',0,0,'C');
        $this->Ln(14);
        $this->SetFont('Arial','B',8);
        $this->Cell(7,7,'NO',1,0,'C');
        $this->Cell(50,7,'NAMA DEPARTEMEN',1,0,'C');
        $this->Cell(50,7,'RATA RATA',1,1,'C');

        
    }  
         
}

// definisi class
$pdf = new PDF('P','mm','A4'); // A% = 148 x 210
// variable awal
date_default_timezone_set('Asia/Jakarta');
$pdf->SetMargins(8,6,9);
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak('on', 82); //margin bottom set to 0
//$pdf->SetLineWidth(0.5);


function kosong($per){
    if($per==0){
        return '';
    }
    
}
function tgl($date){
    if($date=='0000-00-00'){
        return '';
    }
    else{
        setlocale (LC_TIME, 'INDONESIAN');
        $st = strftime( "%d-%b-%Y", strtotime($date));
        //return strtoupper($st);
        return $st;
    }    
}

function tgl2($date){
    setlocale (LC_TIME, 'INDONESIAN');
    $st = strftime( "%d %B %Y", strtotime($date));
    //return strtoupper($st);
    return $st;
}

$noUrut = 1;
$height = 7 ;
$font   = 'Arial';
$size   = 8;
$tgl    =date('d F Y');


$pdf->AddPage();
       
 foreach($detail->result() as $proses)
        {
            $pdf->SetFont($font,'',$size);
            $pdf->Cell(7,$height,$noUrut,1,0,'C');
            $pdf->Cell(50,$height,$proses->departemen_nama,1,0,'C');
            $pdf->Cell(50,$height,round($proses->rata),1,1,'C');

            $noUrut++;
        }

$pdf->Output("MATRIKS KOMPETENSI ALL DEPT.pdf","I");