<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDF extends FPDF
{    
   public $pemilik  = '';
   public $akhir    = FALSE;
   public $dept     = '';
   public $materi   = '';
  // public $thn      = '';
   function Header()
    {
        
        $this->Image('assets/images/saga_logo.jpg', 10, 5,80,11.2);
        $this->SetFont('Times','B',8);
        $this->Cell(166,4,'',0,0,'L');
        $this->Cell(20,4,'  F-Hr-24',0,0,'L');
        $this->Ln(4);
        $this->Cell(166,4,'',0,0,'L');
        $this->Cell(20,4,'  Rev : 09 25-Maret-19',0,0,'L');
        //$pdf->Image('assets/images/logo.jpg', 30, 5,80,11.2);
        $this->Ln(7);
        $this->SetFont('Arial','B',15);
        $this->Cell(0,7,'FORM EVALUASI PELATIHAN',0,0,'C');
        $this->Ln(14);
        $this->SetFont('Arial','B',8);
        $this->Cell(17,7,'Departemen',0,0,'L');
        $this->Cell(5,7,':',0,0,'C');
        $this->Cell(25,7,$this->dept,'B',0,'L');
        $this->Ln(7);
        $this->SetFont('Arial','B',8);
        $this->Cell(17,7,'Materi',0,0,'L');
        $this->Cell(5,7,':',0,0,'C');
        $this->Cell(25,7,$this->materi,'B',0,'L');
        $this->Ln(10);
        $this->SetFont('Arial','B',8);
        $this->Cell(7,7,'','LTR',0,'C');
        $this->Cell(20,7,'','LTR',0,'C');
        $this->Cell(20,7,'Tgl Test','LTR',0,'C');
        $this->Cell(50,7,'','LTR',0,'C');
        $this->Cell(20,7,'Standar','LTR',0,'C');
        $this->Cell(20,7,'','LT',0,'C');
        $this->Cell(20,7,'Nilai','T',0,'C');
        $this->Cell(20,7,'','TR',0,'C');
        $this->Cell(22,7,'','LTR',1,'C');
        $this->Ln(-2);
        $this->Cell(7,7,'No','LR',0,'C');
        $this->Cell(20,7,'Tgl Pelatihan','LR',0,'C');
        $this->Cell(20,7,'Tertulis','LR',0,'C');
        $this->Cell(50,7,'Nama Peserta','LR',0,'C');
        $this->Cell(20,7,'Nilai','LR',0,'C');
        $this->Cell(20,7,'Pengetahuan','TLR',0,'C');
        $this->Cell(20,7,'Penerapan','TR',0,'C');
        $this->Cell(20,7,'Peningkatan','TR',0,'C');
        $this->Cell(22,7,'KETERANGAN','LR',1,'C');
        $this->Ln(-2);
        $this->Cell(7,7,'','LRB',0,'C');
        $this->Cell(20,7,'','LRB',0,'C');
        $this->Cell(20,7,'','LRB',0,'C');
        $this->Cell(50,7,'','LRB',0,'C');
        $this->Cell(20,7,'','LRB',0,'C');
        $this->Cell(20,7,'(A)','LRB',0,'C');
        $this->Cell(20,7,'(B)','RB',0,'C');
        $this->SetFont('Arial','B',6);
        $this->Cell(20,7,'(A*30%)+(B*70%)','RB',0,'C');
        $this->SetFont('Arial','B',8);
        $this->Cell(22,7,'','LRB',1,'C');
        
    }  
       function Footer() {
        $this->SetY(-82);
        $this->SetFont('Arial','B',8);
        //Page number
        if($this->akhir) {
        $this->Cell(199,6,'SKALA NILAI :','LTR',0,'L');
        $this->Ln(5);
        $this->Cell(13,6,'86 ~ 100','L',0,'L');
        $this->Cell(4,6,'=',0,0,'L');
        $this->Cell(160,6,'Sangat memuaskan / sangat menguasai / mahir, bisa memberikan pelatihan / mengajar',0,0,'L');
        $this->Cell(11,6,'= A',0,0,'C');
        $this->Cell(11,6,'= 4','R',0,'C');
        $this->Ln(5);
        $this->Cell(13,6,'71 ~ 85','L',0,'L');
        $this->Cell(4,6,'=',0,0,'L');
        $this->Cell(160,6,'Memuaskan /  menguasai / bisa menganalisa penyebab masalah/ bisa menjelaskan',0,0,'L');
        $this->Cell(11,6,'= B',0,0,'C');
        $this->Cell(11,6,'= 3','R',0,'C');
        $this->Ln(5);
        $this->Cell(13,6,'65 ~ 70','L',0,'L');
        $this->Cell(4,6,'=',0,0,'L');
        $this->Cell(160,6,'Cukup memuaskan / cukup mengetahui dasar penggunaan / perbaikan, dapat bekerja di area tersebut tanpa pengawasan',0,0,'L');
        $this->Cell(11,6,'= C',0,0,'C');
        $this->Cell(11,6,'= 2','R',0,'C');
        $this->Ln(5);
        $this->Cell(13,6,'1 ~ 64','L',0,'L');
        $this->Cell(4,6,'=',0,0,'L');
        $this->Cell(160,6,'Tidak menguasai pengetahuan dasar penggunaan / perbaikan, dalam masa training',0,0,'L');
        $this->Cell(11,6,'= D',0,0,'C');
        $this->Cell(11,6,'= 1','R',0,'C');    
        $this->Ln(5);
        $this->Cell(13,6,'0','LB',0,'L');
        $this->Cell(4,6,'=','B',0,'LB');
        $this->Cell(160,6,'Belum mendapatkan pelatihan','B',0,'L');
        $this->Cell(11,6,'= E','B',0,'C');
        $this->Cell(11,6,'= 0','RB',0,'C');
        $this->Ln(6);
        $this->SetFont('Arial','B',8);
        $this->Cell(199,6,'Catatan : Nilai peningkatan kinerja adalah hasil pembuatan','LTR',0,'L');
        $this->Ln(5);
        $this->Cell(199,15,'','LR',0,'L');
        $this->Ln(14);
        $this->SetFont('Arial','B',8);
        $this->Cell(140,7,'','L',0,'C');
        $this->Cell(20,7,'Cikarang,',0,0,'C');
        $this->Cell(30,7,  tgl2($this->pemilik),0,0,'L');
        $this->Cell(9,7,'','R',0,'L');
        $this->Ln(7);
        $this->Cell(10,6,'','L',0,'L');
        $this->Cell(30,6,'DIKETAHUI',0,0,'L');
        $this->Cell(80,6,'',0,0,'C');
        $this->Cell(31,6,'DISETUJUI,',0,0,'C');
        $this->Cell(20,6,'DIBUAT,',0,0,'C');
        $this->Cell(28,6,'','R',0,'C');
        $this->Ln(6);
        $this->Cell(120,10,'','L',0,'C');
        $this->Cell(20,10,'',0,0,'C');
        $this->Cell(59,10,'','R',0,'C');
        $this->Ln(10);
        $this->Cell(8,6,'','LB',0,'L');
        $this->Cell(30,6,'(Manager HRD)','B',0,'L');
        $this->Cell(80,6,'','B',0,'C');
        $this->Cell(30,6,'(Mgr. Dept Terkait)','B',0,'C');
        $this->Cell(30,6,'(Spv. Dept Terkait)','B',0,'C');
        $this->Cell(21,6,'','RB',0,'C');
        }
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

$jdl = $header->first_row();
$pdf->dept      = $jdl->departemen_nama;
$pdf->materi    = $jdl->m_materi_nama;
$pdf->AddPage();
        
 foreach($detail->result() as $proses)
        {
            $pdf->SetFont($font,'',$size);
            $pdf->Cell(7,$height,$noUrut,1,0,'C');
            $pdf->Cell(20,$height,tgl($proses->t_evaluasi_tgl_pelatihan),1,0,'C');
            $pdf->Cell(20,$height,tgl($proses->t_evaluasi_tgl_test_tertulis),1,0,'C');
            $pdf->Cell(50,$height,$proses->m_emply_name,1,0,'C');
            $pdf->Cell(20,$height,$proses->m_standar_nilai_range,1,0,'C');
            $pdf->Cell(20,$height,$proses->t_evaluasi_pengetahuan_materi,1,0,'C');
            $pdf->Cell(20,$height,$proses->t_evaluasi_penerapan_lap,1,0,'C');
            $pdf->Cell(20,$height,$proses->t_evaluasi_peningkatan_kinerja,1,0,'C');
            $pdf->Cell(22,$height,'',1,1,'C');


            $noUrut++;
        }
        $row = $cetak->first_row();
        $pdf->pemilik=$row->Tanggal;     
        $pdf->akhir = true; 
    
        


$pdf->Output("Quotation Request & RFQ.pdf","I");