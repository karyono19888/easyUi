<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDF extends FPDF
{    
    public $pemilik='';
    public $akhir    = FALSE;
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
        $this->Cell(20,4,'  F-Hr-41',0,0,'L');
        $this->Ln(4);
        $this->Cell(166,4,'',0,0,'L');
        $this->Cell(20,4,'  Rev : 04 19-Nov-16',0,0,'L');
        //$pdf->Image('assets/images/logo.jpg', 30, 5,80,11.2);
        $this->Ln(7);
        $this->SetFont('Arial','B',15);
        $this->Cell(0,7,'MATRIKS KOMPETENSI',0,0,'C');
        $this->Ln(13);
        
    }  
    function Footer() {
        
        // Go to 1.5 cm from bottom
        $this->SetY(-72);
        //$pdf->SetXY(8, 213);
        $this->SetFont('Arial','B',8);
        if($this->akhir) {
        $this->Cell(199,5,'Ket :',0,0,'L');
        $this->Ln(5);
        $this->Cell(25,5,'Gambar',0,0,'L');
        $this->Cell(30,5,'Angka',0,0,'L');
        $this->Ln(5);
        $this->Cell(20,5,'',0,0,'L');
        $this->Image('assets/images/A.jpg',11,235,5,4);
        $this->Cell(20,5,'86~100',0,0,'L');
        $this->Cell(10,5,'4',0,0,'L');
        $this->Cell(30,5,'Sangat Menguasai / mahir, bisa memberikan pelatihan / mengajar',0,0,'L');
        $this->Ln(5);
        $this->Cell(20,5,'',0,0,'L');
        $this->Image('assets/images/B.jpg',11,240,4.5,4);
        $this->Cell(20,5,'71~85',0,0,'L');
        $this->Cell(10,5,'3',0,0,'L');
        $this->Cell(30,5,'Menguasai, bisa menganalisa penyebab masalah, bisa menjelaskan',0,0,'L');
        $this->Ln(5);
        $this->Cell(20,5,'',0,0,'L');
        $this->Image('assets/images/C.jpg',11,245,5,4);
        $this->Cell(20,5,'65~70',0,0,'L');
        $this->Cell(10,5,'2',0,0,'L');
        $this->Cell(30,5,'Cukup menguasai pengetahuan dasar penggunaan/ perbaikan, dapat bekerja di area tsb (tanpa pengawasan)',0,0,'L');
        $this->Ln(5);
        $this->Cell(20,5,'',0,0,'L');
        $this->Image('assets/images/D.jpg',11,250,4,4);
        $this->Cell(20,5,'1~64',0,0,'L');
        $this->Cell(10,5,'1',0,0,'L');
        $this->Cell(30,5,'Tidak menguasai pengetahuan dasar penggunaan/perbaikan, dalam masa training',0,0,'L');
        $this->Ln(5);
        $this->Cell(20,5,'',0,0,'L');
        $this->Image('assets/images/E.jpg',11,255,4,4);
        $this->Cell(20,5,'0',0,0,'L');
        $this->Cell(10,5,'0',0,0,'L');
        $this->Cell(30,5,'Belum mendapatkan pelatihan',0,0,'L');
        $this->Ln(6);
        $this->Cell(120,6,'',0,0,'C');
        $this->Cell(20,6,'Cikarang,',0,0,'C');
        $this->Cell(30,7,  tgl2($this->pemilik),0,0,'L');
       //$this->Cell(30,6,'28 September 2018',0,0,'L');
        $this->Ln(6);
        $this->Cell(115,5,'',0,0,'C');
        $this->Cell(50,5,'DISETUJUI,',1,0,'C');
        $this->Cell(30,5,'DIBUAT,',1,0,'C');
        $this->Ln(5);
        $this->Cell(115,14,'',0,0,'C');
        $this->Cell(25,14,'',1,0,'C');
		$this->Cell(25,14,'',1,0,'C');
        $this->Cell(30,14,'',1,0,'C');
        $this->Ln(14);
        $this->Cell(115,5,'',0,0,'C');
        $this->Cell(25,5,'Mgr. HRD',1,0,'C');
		$this->Cell(25,5,'General Manager',1,0,'C');
        $this->Cell(30,5,'Manager',1,0,'C');
        
        //$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
   } 
    }
   
}

// definisi class
$pdf = new PDF('P','mm','A4'); // A% = 148 x 210
// variable awal
date_default_timezone_set('Asia/Jakarta');
$pdf->SetMargins(8,6,9);
//$pdf->AliasNbPages();
$pdf->SetAutoPageBreak('on', 72); //margin bottom set to 0
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

function grafik($nilai){
    if($nilai>='86'){
        return 'A';
    }
    else if($nilai>='71'){
        return 'V';
    }
    else if($nilai>='65'){
        return 'R';
    }
    else if($nilai>='1'){
        return 'D';
    }
    else if($nilai=='0'){
        return 'E';
    }
    else{
        return '-';
    }
       
}

function konversi($persen){
    if($persen>='86'){
        return '4';
    }
    else if($persen>='71'){
        return '3';
    }
    else if($persen>='65'){
        return '2';
    }
    else if($persen>='1'){
        return '1';
    }
    else{
        return '0';
    }
       
}


function senpengal ($experience,$stdpengalaman){
	if ($stdpengalaman==0){
		return 100;
	}
	else if ($experience==0){ 
		return 0;
	}
	else {
		$hasil_peng=($experience/$stdpengalaman)*100;
		if ($hasil_peng>=100){
			return 100;     
		}
		else {
			return $hasil_peng;
		}
	}	
}

function pendidikan ($act_pend, $std_pen){
    $hasil_edu=($act_pend/$std_pen)*100;
    if ($hasil_edu>=100){
        return '100%';     
    }
    else {
        return $hasil_edu;
    }
}

function persen($hasil,$target){
	if($target==0){
		return 0;
	}
	else{
		$persen=($hasil/$target)*100;
         if ($persen>=100){
             return 100;
         }
         else {
             return round ($persen,0);
         }
	}
   
}

function persenexp($act,$std){
	if($std==0){
		return 100;
	}
	else{
            $persenexp=($act/($std*12))*100;
            if ($persenexp>=100){
                return 100;
            }
            else {
                return round ($persenexp,0);
            }
	}
   
}

function pengalaman ($pemilik,$masuk){
   $date2 = date_create(date('Y-m-d'));
   //$date2 = $pdf->pemilik;
   $date1 = date_create($masuk);
   $interval = date_diff($date1, $date2);
   return $pemilik+$interval->y;
}

function tgl2($date){
    setlocale (LC_TIME, 'INDONESIAN');
    $st = strftime( "%d %B %Y", strtotime($date));
    //return strtoupper($st);
    return $st;
}

function convertmonth($month){
    if($month<12){
        return $month.' Bln';
    }
    else if($month%12==0){
        $tahun = $month/12;
        return $tahun.' Th';
    }
    else{
        $tahun = floor($month/12);
        $bulan = $month%12;
        return $tahun.'Th  '.$bulan.'Bln';
    }
    
   
}


function konversipen($angka){
    if($angka=='1'){
        return 'SD';
    }
    else if($angka=='2'){
        return 'SMP';
    }
    else if($angka=='3'){
        return 'SMK';
    }
    else if($angka=='4'){
        return 'D1';
    }
    else if($angka=='5'){
        return 'D3';
    }
    else if($angka=='6'){
        return 'S1';
    }
    else if($angka=='7'){
        return 'S2';
    }
    else{
        return '';
    }
       
}


$noUrut = 1;
$height = 6 ;
$font   = 'Arial';
$size   = 8;
$tot_A  = 0;
$tot_B  = 0;
$tot_C  = 0;
$pdf->AddPage();
//$tgl    =date('d F Y');
const TEMPIMGLOC = 'assets/images/tempimg.jpg';
foreach($header->result() as $data)
{

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(22,5,'NAMA',0,0,'L');
        $pdf->Cell(5,5,':',0,0,'C');
        $pdf->Cell(25,5,$data->m_emply_name,0,0,'L');
        
        $dataPieces = explode(',',$data->m_emply_image_img);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);
        //  Check if image was properly decoded
        if( $decodedImg!==false ){
            //  Save image to a temporary location
            if( file_put_contents(TEMPIMGLOC,$decodedImg)!==false ){
                $pdf->Image(TEMPIMGLOC, 166, 22, 22, 28);
            }
        }
        
        $pdf->Ln(6);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(22,5,'TGL MASUK',0,0,'L');
        $pdf->Cell(5,5,':',0,0,'C');
        $pdf->Cell(25,5,tgl($data->m_emply_start),0,0,'L');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(22,5,'DEPARTEMEN',0,0,'L');
        $pdf->Cell(5,5,':',0,0,'C');
        $pdf->Cell(25,5,$data->departemen_induk.' / '.$data->bagian,0,0,'L');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(22,5,'JABATAN',0,0,'L');
        $pdf->Cell(5,5,':',0,0,'C');
        $pdf->Cell(25,5,$data->m_jabatan_nama,0,0,'L');
        $pdf->Ln(7);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7,5,'','LTR',0,'C');
        $pdf->Cell(70,5,'','LTR',0,'C');
        $pdf->Cell(15,5,'','LTR',0,'C');
        $pdf->Cell(90,5,'Tahun','TR',0,'C');
        $pdf->Ln(5);
        $pdf->Cell(7,5,'No','LR',0,'C');
        $pdf->Cell(70,5,'JOB. SPEC','LR',0,'C');
        $pdf->Cell(15,5,'Standar','LR',0,'C');
        $pdf->Cell(30,5,$data->filedA,'TLRB',0,'C');
        $pdf->Cell(30,5,$data->filedB,'TRB',0,'C');
        $pdf->Cell(30,5,$data->filedC,'TRB',0,'C');
        //$pdf->Cell(30,5,'','TRB',0,'C');
        $pdf->Ln(5);
        $pdf->Cell(7,5,'','LRB',0,'C');
        $pdf->Cell(70,5,'','LRB',0,'C');
        $pdf->Cell(15,5,'','LRB',0,'C');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(15,5,'Aktual','LRB',0,'C');
        $pdf->Cell(15,5,'%','RB',0,'C');
        $pdf->Cell(15,5,'Aktual','LRB',0,'C');
        $pdf->Cell(15,5,'%','RB',0,'C');
        $pdf->Cell(15,5,'Aktual','LRB',0,'C');
       // $pdf->Cell(15,5,'','LRB',0,'C');
        $pdf->Cell(15,5,'%','RB',0,'C');
       // $pdf->Cell(15,5,'','RB',0,'C');
        $pdf->Ln(5);
       $pdf->Cell(7,6,'I','LRB',0,'C');
        $pdf->Cell(70,6,'Pendidikan','LRB',0,'L');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Ln(6);
        
        foreach($edu->result() as $pen)
            {
                $pdf->SetFont($font,'',$size);
                $pdf->Cell(7,6,'','LRB',0,'C');
                $pdf->Cell(70,6,'','LRB',0,'L');
                $pdf->Cell(15,$height,konversipen($pen->Std_edu),'LRB',0,'C');
                $pdf->Cell(15,$height,konversipen($pen->A),1,0,'C');
                $pdf->Cell(15,$height,round(pendidikan($pen->A,$pen->Std_edu)).' %',1,0,'C');
                $pdf->Cell(15,$height,konversipen($pen->B),1,0,'C');
                $pdf->Cell(15,$height,round(pendidikan($pen->B,$pen->Std_edu)).' %',1,0,'C');
                $pdf->Cell(15,$height,konversipen($pen->C),1,0,'C');
                $pdf->Cell(15,$height,round(pendidikan($pen->C,$pen->Std_edu)).' %',1,1,'C');
            }

        $pdf->Cell(7,6,'II','LRB',0,'C');
        $pdf->Cell(70,6,'Pengalaman','LRB',0,'L');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Ln(6);
        
        foreach($exp->result() as $pengal)
            {
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(7,6,'','LRB',0,'C');
                $pdf->Cell(70,6,'','LRB',0,'L');
                $pdf->Cell(15,$height,$pengal->m_jobspec_pengalaman_min. 'Th','LRB',0,'C');
                $pdf->Cell(15,$height,convertmonth($pengal->A),1,0,'C');
                $pdf->Cell(15,$height,persenexp($pengal->A,$pengal->m_jobspec_pengalaman_min).' %',1,0,'C');
                $pdf->Cell(15,$height,convertmonth($pengal->B),1,0,'C');
                $pdf->Cell(15,$height,persenexp($pengal->B,$pengal->m_jobspec_pengalaman_min).' %',1,0,'C');
                $pdf->Cell(15,$height,convertmonth($pengal->C),1,0,'C');
                $pdf->Cell(15,$height,persenexp($pengal->C,$pengal->m_jobspec_pengalaman_min).' %',1,1,'C');
            }
      
        $pdf->Cell(7,6,'III','LRB',0,'C');
        $pdf->Cell(70,6,'Skill','LRB',0,'L');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','RB',0,'C');
        $pdf->Ln(6);
   foreach($detail->result() as $proses)
        {
            $pdf->SetFont($font,'',$size);
            $pdf->Cell(7,$height,$noUrut,1,0,'C');
            $pdf->Cell(70,$height,$proses->m_materi_nama,1,0,'L');
            $pdf->AddFont('icomoon','','icomoon.php');
            $pdf->SetFont('icomoon','',11); 
            $pdf->Cell(15,$height,grafik($proses->m_standar_nilai_min),1,0,'C');        
            $pdf->Cell(15,$height,grafik($proses->A),1,0,'C');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(15,$height,persen(konversi($proses->A),konversi($proses->m_standar_nilai_min)).' %',1,0,'C');
            $pdf->AddFont('icomoon','','icomoon.php');
            $pdf->SetFont('icomoon','',11);
            $pdf->Cell(15,$height,grafik($proses->B),1,0,'C');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(15,$height,persen(konversi($proses->B),konversi($proses->m_standar_nilai_min)).' %',1,0,'C');
            $pdf->AddFont('icomoon','','icomoon.php');
            $pdf->SetFont('icomoon','',11);
            $pdf->Cell(15,$height,grafik($proses->C),1,0,'C');
            //$pdf->Cell(15,$height,'',1,0,'C');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(15,$height,persen(konversi($proses->C),konversi($proses->m_standar_nilai_min)).' %',1,1,'C');
            //$pdf->Cell(15,$height,'',1,1,'C');
            
            $tot_A = persen(konversi($proses->A),konversi($proses->m_standar_nilai_min))+$tot_A;
            $tot_B = persen(konversi($proses->B),konversi($proses->m_standar_nilai_min))+$tot_B;
            $tot_C = persen(konversi($proses->C),konversi($proses->m_standar_nilai_min))+$tot_C;
            
            $noUrut++;
        }

        $pdf->Cell(7,6,'','LRB',0,'C');
        $pdf->Cell(70,6,'Rata-rata','LRB',0,'L');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,round($tot_A/($noUrut-1),0).' %','RB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,round($tot_B/($noUrut-1),0).' %','RB',0,'C');
        $pdf->Cell(15,6,'','LRB',0,'C');
        $pdf->Cell(15,6,round($tot_C/($noUrut-1),0).' %','RB',0,'C');
        $pdf->Ln(6);
        
}     
        
$row = $cetak->first_row();
$pdf->pemilik=$row->Tanggal;
$pdf->akhir = true; 

$pdf->Output("Quotation Request & RFQ.pdf","I");
unlink(TEMPIMGLOC);