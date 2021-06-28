<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDF extends FPDF
{  
    public $pemilik  = '';
    public $akhir    = FALSE;
    public $materi   = '';
    public $t_evaluasi_tgl_test_tertulis  = '';
    function Header()
    {
         //$this->AddFont('BAVAND','','BAVAND.php');
       // $this->SetFont('BAVAND','',13); 
       // $this->Cell(16,3,'Hikari',0,0,'L');
       // $this->Ellipse(15.5,7.6,9,3.2);
       // $this->SetFont('Times','B',10);
        //$this->Cell(150,4,'  PT. HIKARI METALINDO PRATAMA',0,0,'L');
        $this->Image('assets/images/saga_logo.jpg', 10, 5,80,11.2);
        $this->SetFont('Times','B',8);
        $this->Cell(166,4,'',0,0,'L');
        $this->Cell(20,4,'  F-Hr-24',0,0,'L');
        $this->Ln(4);
        $this->Cell(166,4,'',0,0,'L');
        $this->Cell(20,4,'  Rev : 08 2-Mei-14',0,0,'L');
        //$pdf->Image('assets/images/logo.jpg', 30, 5,80,11.2);
        $this->Ln(7);
        $this->SetFont('Arial','B',15);
        $this->Cell(0,7,'HASIL TEST PELATIHAN',0,0,'C');
        $this->Ln(14);
        $this->SetFont('Arial','B',8);
        $this->Cell(17,7,'MATERI',0,0,'L');
        $this->Cell(5,7,':',0,0,'C');
        $this->Cell(25,7,$this->materi,0,0,'L');
        $this->Ln(7);
        $this->SetFont('Arial','B',8);
        $this->Cell(17,7,'TANGGAL',0,0,'L');
        $this->Cell(5,7,':',0,0,'C');
        $this->Cell(25,7,tgl($this->t_evaluasi_tgl_test_tertulis),0,0,'L');
        $this->Ln(10);
        $this->SetFont('Arial','B',8);
        $this->Cell(7,7,'NO',1,0,'C');
        $this->Cell(60,7,'NAMA',1,0,'C');
        $this->Cell(40,7,'BAGIAN',1,0,'C');
        $this->Cell(20,7,'NILAI',1,0,'C');
        $this->Cell(30,7,'LULUS/GAGAL',1,0,'C');
        $this->Cell(30,7,'KETERANGAN',1,1,'C');
        
    } 
    
    function Footer() {
        $this->SetY(-50);
        $this->SetFont('Arial','B',8);
        //Page number
        if($this->akhir) {
            $this->Ln(7);
            $this->SetFont('Arial','B',8);
            $this->Cell(140,7,'',0,0,'C');
            $this->Cell(20,7,'Cikarang,',0,0,'C');
            $this->Cell(30,7,  tgl2($this->pemilik),0,0,'L');
            //$row = $cetak->first_row();
            //$this->Cell(30,7,  tgl2($row->Tanggal),0,0,'L');
            //$this->Cell(30,7,  tgl2(date("Y-m-d")),0,0,'L');
            $this->Ln(9);
            $this->Cell(155,7,'',0,0,'C');
            $this->Cell(40,7,'DIBUAT,',1,0,'C');
            $this->Ln(7);
            $this->Cell(155,17,'',0,0,'C');
            $this->Cell(40,17,'',1,0,'C');
            $this->Ln(17);
            $this->Cell(155,7,'',0,0,'C');
            $this->Cell(40,7,'Neneng,',1,0,'C');
        }
    }
       
   
}

// definisi class
$pdf = new PDF('P','mm','A4'); // A% = 148 x 210
// variable awal
date_default_timezone_set('Asia/Jakarta');
$pdf->SetMargins(8,6,9);
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak('on', 5); //margin bottom set to 0
//$pdf->SetLineWidth(0.5);

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

function status($sts,$eval){
    if($sts<=$eval){
        return 'LULUS';
    }
    else{
        return 'GAGAL';
    }
}

$noUrut = 1;
$height = 7 ;
$font   = 'Arial';
$size   = 8;
$tgl    =date('d F Y');

$jdl = $header->first_row(); //
$pdf->materi                            = $jdl->m_materi_nama;
$pdf->t_evaluasi_tgl_test_tertulis      = $jdl->t_evaluasi_tgl_test_tertulis;
$pdf->AddPage();

   foreach($detail->result() as $proses)
        {
            $pdf->SetFont($font,'',$size);
            $pdf->Cell(7,$height,$noUrut,1,0,'C');
            $pdf->Cell(60,$height,$proses->m_emply_name,1,0,'C');
            $pdf->Cell(40,$height,$proses->departemen_nama,1,0,'C');
            $pdf->Cell(20,$height,$proses->t_evaluasi_pengetahuan_materi,1,0,'C');
            $pdf->Cell(30,$height,$proses->status,1,0,'C');
            $pdf->Cell(30,$height,$proses->t_evaluasi_keterangan,1,1,'C');


            $noUrut++;
        }
        $row = $cetak->first_row();
        $pdf->pemilik=$row->Tanggal;     
        $pdf->akhir = true;     
    

$pdf->Output("Quotation Request & RFQ.pdf","I");