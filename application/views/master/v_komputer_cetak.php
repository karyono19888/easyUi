<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//global $judul;
//$judul = $pta->first_row();
//$asa = 'kkk';
class PDF extends FPDF
{    
    var $cin;
    function Header()
    {
        $this->SetFont('Arial','B',17);
        $this->Cell(0,7,'DAFTAR ASSET KOMPUTER '.$this->cin,0,0,'C');
        $this->Ln(14);
        $this->SetFont('Arial','B',11);
        $this->Cell(10,7,'NO',1,0,'C');
        $this->Cell(30,7,'HOSTNAME',1,0,'C');
        $this->Cell(30,7,'DEPARTEMEN',1,0,'C');
        $this->Cell(30,7,'NAMA USER',1,0,'C');
        $this->Cell(30,7,'TGL MASUK',1,0,'C');
        $this->Cell(30,7,'TGL KELUAR',1,0,'C');
        $this->Cell(40,7,'KETERANGAN',1,1,'C');
    }
}

// definisi class
$pdf = new PDF('P','mm','A4'); // A% = 148 x 210
// variable awal
date_default_timezone_set('Asia/Jakarta');
$pdf->SetMargins(5,5,10);
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak('on', 5); //margin bottom set to 0
//$pdf->SetLineWidth(0.5);

$judul = $pta->first_row();
$pdf->cin=$judul->Pt;

$noUrut                 = 1;
$height = 7 ;
$font   = 'Arial';
$size   = 10;
$pdf->AddPage();
foreach($rows->result() as $data)
{
    $pdf->SetFont($font,'',$size);
    $pdf->Cell(10,$height,$noUrut,1,0,'C');
    $pdf->Cell(30,$height,$data->m_komputer_hostname,1,0,'C');
    $pdf->Cell(30,$height,$data->m_departemen_dept,1,0,'C');
    $pdf->Cell(30,$height,$data->m_komputer_user,1,0,'C');
    $pdf->Cell(30,$height,$data->m_komputer_masuk,1,0,'C');
    $pdf->Cell(30,$height,$data->m_komputer_keluar,1,0,'C');
    $pdf->Cell(40,$height,$data->m_komputer_keterangan,1,1,'C');
    
    $noUrut++;
}


$pdf->Output("Daftar Asset Komputer.pdf","I");

// End of file v_po_card_print.php 
// Location: ./application/views/transaksi/po/v_po_card_print.php