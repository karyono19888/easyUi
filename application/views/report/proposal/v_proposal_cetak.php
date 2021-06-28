<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDF extends FPDF
{   
   public $pemilik  = '';
   public $akhir    = FALSE;
   public $dept     = '';
   public $period   = '';
   public $thn      = '';
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
        $this->Cell(20,4,'  F-Hr-09',0,0,'L');
        $this->Ln(4);
        $this->Cell(166,4,'',0,0,'L');
        $this->Cell(20,4,'  Rev : 01 5-Jan-09',0,0,'L');
        //$pdf->Image('assets/images/logo.jpg', 30, 5,80,11.2);
        $this->Ln(7);
        $this->SetFont('Arial','B',15);
        $this->Cell(0,7,'PROPOSAL KEBUTUHAN PELATIHAN',0,0,'C');
        $this->Ln(14);
        $this->SetFont('Arial','B',8);
        $this->Cell(17,7,'Departemen',0,0,'L');
        $this->Cell(5,7,':',0,0,'C');
        $this->Cell(25,7,$this->dept,0,0,'L');
        $this->Ln(7);
        $this->SetFont('Arial','B',8);
        $this->Cell(17,7,'Periode',0,0,'L');
        $this->Cell(5,7,':',0,0,'C');
        $this->Cell(28,7,periode($this->period,$this->thn),0,0,'L');
        $this->Ln(10);
        $this->SetFont('Arial','B',8);
        $this->Cell(7,7,'NO',1,0,'C');
        $this->Cell(25,7,'JENIS',1,0,'C');
        $this->Cell(50,7,'MATERI',1,0,'C');
        $this->Cell(50,7,'PESERTA',1,0,'C');
        $this->Cell(40,7,'INSTRUKTUR',1,0,'C');
        $this->Cell(25,7,'KETERANGAN',1,1,'C');
        
    }  
   function Footer() {
        $this->SetY(-45);
        $this->SetFont('Arial','B',8);
        //Page number
        if($this->akhir) {
            $this->Cell(120,7,'',0,0,'C');
            $this->Cell(20,7,'Cikarang,',0,0,'C');
            $this->Cell(30,7,  tgl2($this->pemilik),0,0,'L');
            $this->Ln(9);
            $this->Cell(115,7,'',0,0,'C');
            $this->Cell(40,7,'DISETUJUI,',1,0,'C');
            $this->Cell(20,7,'DIKETAHUI,',1,0,'C');
            $this->Cell(20,7,'DIBUAT,',1,0,'C');
            $this->Ln(7);
            $this->Cell(115,17,'',0,0,'C');
            $this->Cell(20,17,'',1,0,'C');
            $this->Cell(20,17,'',1,0,'C');
            $this->Cell(20,17,'',1,0,'C');
            $this->Cell(20,17,'',1,0,'C');
            $this->Ln(17);
            $this->Cell(115,7,'',0,0,'C');
            $this->Cell(20,7,'GM,',1,0,'C');
            $this->Cell(20,7,'Mgr.HRD,',1,0,'C');
            $this->Cell(20,7,'Mgr.Terkait,',1,0,'C');
            $this->Cell(20,7,'Spv.Terkait,',1,0,'C');
        }
    }
   
}

// definisi class
$pdf = new PDF('P','mm','A4'); // A% = 148 x 210
// variable awal
date_default_timezone_set('Asia/Jakarta');
$pdf->SetMargins(8,6,9);
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak('on', 45); //margin bottom set to 0
//$pdf->SetLineWidth(0.5);

function tgl($date){
    setlocale (LC_TIME, 'INDONESIAN');
    $st = strftime( "%d-%b-%Y", strtotime($date));
    //return strtoupper($st);
    return $st;
}

function tgl2($date){
    setlocale (LC_TIME, 'INDONESIAN');
    $st = strftime( "%d %B %Y", strtotime($date));
    //return strtoupper($st);
    return $st;
}

function periode($per, $tahun){
    if($per==1){
        return 'JANUARI - JUNI '.$tahun;
    }
    else{
        return ' JULI - DESEMBER '.$tahun;
    }
}

function cek_materi($baru, $lama){
	if($baru==$lama){
		return '';
	}
	else{
		return $baru;
		$materi = $baru; 
	}
}

$noUrut = 1;
$height = 7 ;
$font   = 'Arial';
$size   = 8;
$materi = '';
//$tgl    =date('d F Y');

$jdl = $header->first_row(); //
$pdf->dept      = $jdl->departemen_nama;
$pdf->period    = $jdl->t_proposal_periode;
$pdf->thn       = $jdl->t_proposal_tahun;
$pdf->AddPage();


foreach($detail->result() as $proses) {
    $pdf->SetFont($font,'',$size);
    $pdf->Cell(7,$height,$noUrut,1,0,'C');
    $pdf->Cell(25,$height,$proses->t_proposal_jenis,1,0,'C');
    $pdf->Cell(50,$height,cek_materi($proses->m_materi_nama,$materi),1,0,'C');
    $pdf->Cell(50,$height,$proses->m_emply_name,1,0,'C');
    $pdf->Cell(40,$height,$proses->t_proposal_instruktur,1,0,'C');
    $pdf->Cell(25,$height,$proses->t_proposal_keterangan,1,1,'C');
    $noUrut++;
}
        
$row = $cetak->first_row();
$pdf->pemilik=$row->Tanggal;     
$pdf->akhir = true;

$pdf->Output("Proposal Pelatihan.pdf","I");