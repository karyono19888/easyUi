<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDF extends FPDF
{    
   public $pemilik  = '';
   public $akhir    = FALSE;
 //  public $dept     = '';
   public $period   = '';
   public $thn      = '';
   function Header()
    {
        //$this->AddFont('BAVAND','','BAVAND.php');
       // $this->SetFont('BAVAND','',13); 
       // $this->Cell(16,3,'Hikari',0,0,'L');
       // $this->Ellipse(12.5,7.6,9,3.2);
        //$this->SetFont('Times','B',10);
       // $this->Cell(249,4,'  PT. HIKARI METALINDO PRATAMA',0,0,'L');
        $this->Image('assets/images/saga_logo.jpg', 10, 5,80,11.2);
        $this->SetFont('Times','B',8);
        $this->Cell(265,4,'',0,0,'L');
        $this->Cell(20,4,'  F-Hr-52',0,0,'L');
        $this->Ln(4);
        $this->Cell(265,4,'',0,0,'L');
        $this->Cell(20,4,'  Rev : 01 2-Jan-19',0,0,'L');
        //$pdf->Image('assets/images/logo.jpg', 30, 5,80,11.2);
        $this->Ln(7);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,7,'SCHEDULE PELATIHAN',0,0,'C');
        $this->Ln(8);
        $this->SetFont('Arial','B',11);
        $this->Cell(280,6,  periode($this->period),0,0,'C');
        $this->Ln(6);
        $this->Cell(125,6,'',0,0,'L');
        $this->Cell(15,6,'TAHUN',0,0,'L');
        $this->Cell(25,6,$this->thn,0,0,'L');
        $this->Ln(10);
        $this->SetFont('Arial','B',8);
        $this->Cell(52,7,'Training 1',1,0,'C');
        $this->Cell(52,7,'Training 2',1,0,'C');
        $this->Cell(20,14,'TEMPAT',1,0,'C');
        $this->Cell(30,14,'INSTRUKTUR',1,0,'C');
        $this->Cell(40,14,'MATERI',1,0,'C');
        $this->Cell(50,14,'PESERTA',1,0,'C');
        $this->Cell(25,14,'DEPT',1,0,'C');
        $this->Cell(20,14,'AKTUAL',1,0,'C');
        $this->Ln(7);
        $this->Cell(20,7,'TGL',1,0,'C');
        $this->Cell(32,7,'WAKTU',1,0,'C');
        $this->Cell(20,7,'TGL',1,0,'C');
        $this->Cell(32,7,'WAKTU',1,1,'C');
        
    }  
   function Footer() {
        $this->SetY(-45);
        $this->SetFont('Arial','B',8);
        //Page number
        if($this->akhir) {
            $this->Cell(190,7,'',0,0,'C');
            $this->Cell(30,7,'Cikarang,',0,0,'C');
            $this->Cell(30,7,  tgl2($this->pemilik),0,0,'L');
            $this->Ln(10);
            $this->Cell(210,7,'',0,0,'C');
            $this->Cell(30,7,'DIKETAHUI,',1,0,'C');
            $this->Cell(30,7,'DIBUAT,',1,0,'C');
            $this->Ln(7);
            $this->Cell(210,17,'',0,0,'C');
            $this->Cell(30,17,'',1,0,'C');
            $this->Cell(30,17,'',1,0,'C');
            $this->Ln(17);
            $this->Cell(210,7,'',0,0,'C');
            $this->Cell(30,7,'Spv HRD,',1,0,'C');
            $this->Cell(30,7,'Staff HRD,',1,0,'C');
        }
    } 
   
}

// definisi class
$pdf = new PDF('L','mm','A4'); // A% = 148 x 210
// variable awal
date_default_timezone_set('Asia/Jakarta');
$pdf->SetMargins(5,6,9);
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak('on', 45); //margin bottom set to 0
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

function periode($per){
    if($per==1){
        return 'PERIODE JANUARI - JUNI';
    }
    else{
        return 'PERIODE JULI - DESEMBER';
    }
} 

function emptytime($jam){
    if($jam=='00:00:00'){
        return '';
    }
    else{
        return $jam;
    }
}  
    

$noUrut = 1;
$height = 7 ;
$font   = 'Arial';
$size   = 8;
$tgl    =date('d F Y');

$jdl = $header->first_row(); 
$pdf->period    = $jdl->t_proposal_periode;
$pdf->thn       = $jdl->t_proposal_tahun;
$pdf->AddPage();
 
 foreach($detail->result() as $proses)
        {
            $pdf->SetFont($font,'',$size);;
            $pdf->Cell(20,$height,tgl($proses->t_schedule_tgl),1,0,'C');
            $pdf->Cell(16,$height,$proses->t_schedule_waktu_dari,1,0,'C');
            $pdf->Cell(16,$height,$proses->t_schedule_waktu_sampai,1,0,'C');
            $pdf->Cell(20,$height,tgl($proses->t_schedule_tgl2),1,0,'C');
            $pdf->Cell(16,$height,emptytime($proses->t_schedule_waktu_dari2),1,0,'C');
            $pdf->Cell(16,$height,emptytime($proses->t_schedule_waktu_sampai2),1,0,'C');
            $pdf->Cell(20,$height,$proses->m_tempat_nama,1,0,'C');
            $pdf->Cell(30,$height,$proses->t_proposal_instruktur,1,0,'C');
            $pdf->Cell(40,$height,$proses->m_materi_nama,1,0,'C');
            $pdf->Cell(50,$height,$proses->m_emply_name,1,0,'C');
            $pdf->Cell(25,$height,$proses->departemen_nama,1,0,'C');
            $pdf->Cell(20,$height,tgl($proses->t_schedule_aktual),1,1,'C');


            $noUrut++;
        }
        
   
        $row = $cetak->first_row();
        $pdf->pemilik=$row->Tanggal;     
        $pdf->akhir = true;   


$pdf->Output("Schedule.pdf","I");