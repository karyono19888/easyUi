<?php
class PDF extends FPDF
{
}
$fpdf = new PDF();
    /// Set Awal FPDF
date_default_timezone_set('Asia/Jakarta');
$fpdf = new PDF('P', 'cm', 'A4'); // A% = 148 x 210
$fpdf->SetMargins(1,0.5,1);
$fpdf->AliasNbPages();
$fpdf->AddPage();


    /// Awal Fungsi 
function ft($tgl)   // Fungsi format tanggal ( 04 Februari 2012 )
{
    setlocale (LC_TIME, 'INDONESIAN');
    $tgl = strtotime($tgl);
    $st = strftime( "%d %B %Y", $tgl);
    return $st;
}

function ft2($tgl)  // Fungsi format tanggal ( 04-02-2012 )
{
    setlocale (LC_TIME, 'INDONESIAN');
    $tgl = strtotime($tgl);
    $st = strftime( "%d-%m-%Y", $tgl);
    return $st;
}

function kontrak($k)    // Fungsi untuk memberi tanda 'X' di kotak kontrak
{
    if ($k == 'Kontrak'){
        return 'X';
    }else{
        return'';
    }
}

function percobaan($k)  // Fungsi untuk memberi tanda 'X' di kotak percobaan
{
    if ($k == 'Masa Percobaan'){
        return 'X';
    }else{
        return'';
    }
}

function mutasi($k)     // Fungsi untuk memberi tanda 'X' di kotak mutasi
{
    if ($k == 'Mutasi'){
        return 'X';
    }else{
        return'';
    }
}

function promosi($k)    // Fungsi untuk memberi tanda 'X' di kotak promosi
{
    if ($k == 'Promosi'){
        return 'X';
    }else{
        return'';
    }
}

function rotasi($k)     // Fungsi untuk memberi tanda 'X' di kotak rotasi
{
    if ($k == 'Rotasi'){
        return 'X';
    }else{
        return'';
    }
}

function masa($k)       // Fungsi memberikan nilai pada bagian masa
{
    if ($k == 'Kontrak'){
        return '';
    }elseif($k == 'Masa Percobaan'){
        return 'Percobaan';
    }elseif($k == 'Mutasi'){
        return 'Mutasi';
    }elseif($k == 'Promosi'){
        return 'Promosi';
    }else{
        return 'Rotasi';
    }
        
}

function awal_perpanjangan($s, $kk, $end)
{
    $pecah      = explode('-', $end);
    $th         = $pecah[0];
    $bl         = $pecah[1];
    $tg         = $pecah[2]; 
    
    if ($s == 'N') {
        return '-';
    }  elseif ($kk == 'II') {
        return '-';
    }  elseif ($kk == 'P') {       
        $pkwt_start2 = date( 'd-m-Y', mktime(0, 0, 0, $bl + 1, $tg + 1, $th));
        return $pkwt_start2;
    }  else {       
        $pkwt_start2 = date( 'd-m-Y', mktime(0, 0, 0, $bl, $tg + 1, $th));
        return $pkwt_start2;
    }    
}

function akhir_perpanjangan($s, $kk, $end)
{
    $pecah      = explode('-', $end);
    $th         = $pecah[0];
    $bl         = $pecah[1];
    $tg         = $pecah[2]; 
        
    if ($s == 'N') {
        return '-';
    }  elseif ($kk == 'II') {
        return '-';
    }  elseif ($kk == 'P') {       
        $pkwt_end2 = date( 'd-m-Y', mktime(0, 0, 0, $bl + 1, $tg, $th + 1));
        return $pkwt_end2;
    }  else {       
        $pkwt_end2 = date( 'd-m-Y', mktime(0, 0, 0, $bl, $tg, $th + 1));
        return $pkwt_end2;
    }    
}

function awal_jeda( $s, $kk, $end)
{
    $pecah      = explode('-', $end);
    $th         = $pecah[0];
    $bl         = $pecah[1];
    $tg         = $pecah[2];    

    if  ($kk != 'P') {
        return '-';
    }  else {        
        if ($s == 'N') {
            return '-';
        }  else {
            $awal_jeda = date( 'd-m-Y', mktime(0, 0, 0, $bl, $tg + 1, $th));
            return $awal_jeda;
        }
    }    
}

function akhir_jeda( $s, $kk, $end)
{
    $pecah      = explode('-', $end);
    $th         = $pecah[0];
    $bl         = $pecah[1];
    $tg         = $pecah[2];    

    if  ($kk != 'P') {
        return '-';
    }  else {        
        if ($s == 'N') {
            return '-';
        }  else {
            $akhir_jeda = date( 'd-m-Y', mktime(0, 0, 0, $bl + 1, $tg, $th));
            return $akhir_jeda;
        }
    }        
}

function Romawi($a)
{
    $x = strtotime($a);
    $y = strftime( "%m", $x);
    $n = number_format($y);
   
    $hasil = "";
    $iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX",'X',"XI","XII");
    if(array_key_exists($n,$iromawi)){
        $hasil = $iromawi[$n];
    }
    return $hasil;
} 

function fty($tgl)
{
    setlocale (LC_TIME, 'INDONESIAN');
    $tgl = strtotime($tgl);
    $st = strftime( "%y", $tgl);
    return $st;
}

function masa_berlaku($k, $start, $end)
{
    if ($k == 'Kontrak'){
        return 's/d';
    } else{
        return ft2($start).'   s/d   '.ft2($end);
    }    
}

function baru($k, $kk, $start, $end, $start_1, $end_1, $start_2, $end_2)
{   
    if ($k == 'Kontrak'){
        if ($kk === 'I'){
            return ft2($start).'   s/d   '.ft2($end);
        } elseif ($kk === 'P'){
            return ft2($start_1).'   s/d   '.ft2($end_1); 
        } else {
            return ft2($start_2).'   s/d   '.ft2($end_2);
        }
    } else{
        return 's/d';
    }
        
}

function perpanjangan($k, $kk, $start, $end, $start_1, $end_1)
{
    if ($k == 'Kontrak'){
        if ($kk === 'I'){
            return 's/d';
        } elseif ($kk === 'P'){
            return ft2($start).'   s/d   '.ft2($end); 
        } else {
            return ft2($start_1).'   s/d   '.ft2($end_1);
        } 
    } else{
        return 's/d';
    }
    
}

function pembaharuan($k, $kk, $start, $end)
{
    if ($k == 'Kontrak'){
        if ($kk === 'II'){
            return ft2($start).'   s/d   '.ft2($end);
        } else {
            return 's/d';
        }
    } else{
        return 's/d';
    }
    
}
    /// Akhir Fungsi

foreach($pkwt->result() as $data)
{

    /// Awal Definisi Variabel
$no_pkwt            = 'No. : '.$data->pkwt_id.'/PKWT/HRD-GA/'.Romawi($data->pkwt_sign).'/'.fty($data->pkwt_sign);
$kontrak            = kontrak($data->pkwt_status);
$percobaan          = percobaan($data->pkwt_status);
$mutasi             = mutasi($data->pkwt_status);
$promosi            = promosi($data->pkwt_status);
$rotasi             = rotasi($data->pkwt_status);

$nama               = $data->m_emply_name;
$masa               = masa($data->pkwt_status);
//$awal_kontrak       = ft2($data->pkwt_start);
//$akhir_kontrak      = ft2($data->pkwt_end);
$jabatan            = $data->m_jabatan_nama;
$bagian             = $data->dept_name;
//$kontrak_ke         = $data->pkwt_kk;
$tgl_masuk          = ft($data->m_emply_start);
//$awal_perpanjangan  = awal_perpanjangan($data->pkwt_cont, $data->pkwt_kk, $data->pkwt_end);
//$akhir_perpanjangan = akhir_perpanjangan($data->pkwt_cont, $data->pkwt_kk, $data->pkwt_end);
//$awal_jeda          = awal_jeda($data->pkwt_cont, $data->pkwt_kk, $data->pkwt_end);
//$akhir_jeda         = akhir_jeda($data->pkwt_cont, $data->pkwt_kk, $data->pkwt_end);
$mB                 = masa_berlaku($data->pkwt_status,$data->pkwt_start, $data->pkwt_end);
$kI                 = baru($data->pkwt_status,$data->pkwt_kk, $data->pkwt_start, $data->pkwt_end, $data->start_1, $data->end_1, $data->start_2, $data->end_2);
$kP                 = perpanjangan($data->pkwt_status,$data->pkwt_kk, $data->pkwt_start, $data->pkwt_end, $data->start_1, $data->end_1);    
$kII                = pembaharuan($data->pkwt_status,$data->pkwt_kk, $data->pkwt_start, $data->pkwt_end);
///Akhir Definisi Variabel

// Setting Font : String Family, String Style, Font size 
$fpdf->Image('assets/images/logo.jpg', 1, 1,7.5,1.2);
$fpdf->Ln();
$fpdf->Cell(15);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0,1,'F-Hr-19',0,0,'L');
$fpdf->Ln(0.5);
$fpdf->Cell(15);
$fpdf->Cell(0,1,'Rev : 06  2-Des-13',0,0,'L');

// Awal Header
$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',18);

$fpdf->Cell(0,1,'FORM EVALUASI KARYAWAN',0,0,'C');

$fpdf->Ln(0.6);

// Awal Header

//Awal Status

$fpdf->SetFont('Arial','B',10);

$fpdf->Cell(0,1,$no_pkwt,0,0,'C');

$fpdf->Ln();

$fpdf->Cell(2);

$fpdf->Cell(0.5,0.5,$kontrak,1,0,'C');
$fpdf->Cell(0.1);
$fpdf->Cell(0.5,0.5,'Kontrak',0,0,'L');

$fpdf->Cell(5);
$fpdf->Cell(0.5,0.5,$percobaan,1,0,'C');
$fpdf->Cell(0.5,0.5,'Masa Percobaan',0,0,'L');

$fpdf->Cell(6);
$fpdf->Cell(0.5,0.5,$mutasi,1,0,'C');
$fpdf->Cell(0.5,0.5,'Mutasi',0,0,'L');

$fpdf->Ln(0.6);

$fpdf->Cell(8.1);

$fpdf->Cell(0.5,0.5,$promosi,1,0,'C');
$fpdf->Cell(0.1);
$fpdf->Cell(0.5,0.5,'Promosi',0,0,'L');

$fpdf->Cell(5.9);
$fpdf->Cell(0.5,0.5,$rotasi,1,0,'C');
$fpdf->Cell(0.5,0.5,'Rotasi',0,0,'L');
//Akhir Status

// Awal Data karyawan
$fpdf->SetFont('Arial','B',10);
$fpdf->Ln(1.2);

$fpdf->Cell(0.5,0.5,'Nama',0,0,'L');
$fpdf->Cell(2.5);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
//$fpdf->Cell(1);
$fpdf->Cell(4.8,0.5,$nama,'B',0,'L');

$fpdf->Cell(0.8);
$fpdf->Cell(0.5,0.5,'Masa Berlaku....................*)',0,0,'L');
$fpdf->Text(12.6, 5.5,$masa);
$fpdf->Cell(4);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
$fpdf->Cell(4.8,0.5,$mB,'B',0,'C');
//$fpdf->Cell(2,0.5,$awal_kontrak,'B',0,'C');
//$fpdf->Cell(0.8,0.5,'s/d','B',0,'L');
//$fpdf->Cell(2,0.5,$akhir_kontrak,'B',0,'C');

$fpdf->Ln(0.6);

$fpdf->Cell(0.5,0.5,'Dept. / Bagian',0,0,'L');
$fpdf->Cell(2.5);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
$fpdf->SetFont('Arial','B',8);
$fpdf->Cell(2.2,0.5,$data->departemen,'B',0,'L');
$fpdf->Cell(0.4,0.5,'/','B',0,'C');
$fpdf->Cell(2.2,0.5,$bagian,'B',0,'L');

$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0.8);
$fpdf->Cell(0.5,0.5,'Kontrak Pertama',0,0,'L');
$fpdf->Cell(4);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
//$fpdf->Cell(1);
$fpdf->Cell(4.8,0.5,$kI,'B',0,'C');

$fpdf->Ln(0.6);

$fpdf->Cell(0.5,0.5,'Jabatan',0,0,'L');
$fpdf->Cell(2.5);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
//$fpdf->Cell(1);
$fpdf->Cell(4.8,0.5,$jabatan,'B',0,'L');

$fpdf->Cell(0.8);
$fpdf->Cell(0.5,0.5,'Kontrak Perpanjangan',0,0,'L');
$fpdf->Cell(4);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
//$fpdf->Cell(1);
$fpdf->Cell(4.8,0.5,$kP,'B',0,'C');
//$fpdf->Cell(0.8,0.5,'s/d','B',0,'L');
//$fpdf->Cell(2,0.5,$akhir_perpanjangan,'B',0,'C');

$fpdf->Ln(0.6);

$fpdf->Cell(0.5,0.5,'Tgl Masuk',0,0,'L');
$fpdf->Cell(2.5);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
//$fpdf->Cell(1);
$fpdf->Cell(4.8,0.5,$tgl_masuk,'B',0,'L');

$fpdf->Cell(0.8);
$fpdf->Cell(0.5,0.5,'Kontrak Pembaharuan',0,0,'L');
$fpdf->Cell(4);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
//$fpdf->Cell(1);
$fpdf->Cell(4.8,0.5,$kII,'B',0,'C');
//$fpdf->Cell(0.8,0.5,'s/d','B',0,'L');
//$fpdf->Cell(2,0.5,$akhir_perpanjangan,'B',0,'C');

$fpdf->Ln(0.6);
/*
$fpdf->Cell(9.1);
$fpdf->Cell(0.5,0.5,'Jeda',0,0,'L');
$fpdf->Cell(4);
$fpdf->Cell(0.5,0.5,':',0,0,'L');
//$fpdf->Cell(1);
$fpdf->Cell(2,0.5,$awal_jeda,'B',0,'C');
$fpdf->Cell(0.8,0.5,'s/d','B',0,'L');
$fpdf->Cell(2,0.5,$akhir_jeda,'B',0,'C');
*/
// Akhir Data karyawan
/* -------------- Header Halaman selesai ------------------------------------------------*/
// Awal Tabel
$fpdf->Ln(1);

$fpdf->SetFont('Arial','B',12);
$fpdf->Cell(1  , 0.7, 'No.'           , 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.7, 'DASAR PENILAIAN' , 1, 'LR', 'C');
$fpdf->Cell(2 , 0.7, 'Nilai **)' , 1, 'LR', 'C');

$fpdf->Ln();

$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(1  , 0.5, ''           , 1, 'LR', 'L');
$fpdf->Cell(15.9 , 0.5, 'UMUM' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '1', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Pengetahuan akan pekerjaan' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '2', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Inisiatif kerja' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '3', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Produktivitas & Efisiensi kerja' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '4', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Mutu kerja' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '5', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Komunikasi' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '6', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Kerjasama' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '7', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Tanggung jawab & Dedikasi' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '8', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Disiplin & Absensi' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '9', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Sikap kerja' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1  , 0.5, '10', 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, 'Penyesuaian lingkungan' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'L');
//// END TABLE

$fpdf->Ln();
$fpdf->Cell(1  , 0.5, ''  , 1, 'LR', 'C');
$fpdf->Cell(15.9 , 0.5, '' , 1, 'LR', 'L');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'C');
        
$fpdf->Ln();
$fpdf->SetFont('Arial','B',12);
$fpdf->Cell(16.9  , 0.5, 'JUMLAH'           , 'L', 'LR', 'R');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'C');

$fpdf->Ln();
$fpdf->Cell(16.9  , 0.5, 'RATA-RATA'           , 'LB', 'LR', 'R');
$fpdf->Cell(2 , 0.5, '' , 1, 'LR', 'C');

// Akhr Tabel

// Awal Keterangan

$fpdf->Ln(0.8);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.5,0.5,'Keterangan :',0,0,'L');
$fpdf->Cell(2.5);
$fpdf->Cell(13,0.5,'','B',0,'L');
$fpdf->Ln();
$fpdf->Cell(3);
$fpdf->Cell(13,0.5,'','B',0,'L');
$fpdf->Ln();
$fpdf->Cell(3);
$fpdf->Cell(13,0.5,'','B',0,'L');

// Akhir Keterangan

// Awal tabel skala dan standar

$fpdf->Ln(1);

$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(4  , 0.5, 'SKALA NILAI'           , 1, 'LR', 'C');
$fpdf->Cell(5.6);
$fpdf->Cell(9.3  , 0.5,'STANDAR NILAI KELULUSAN EVALUASI KARYAWAN', 1, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(2.5  , 0.5, 'Memuaskan'           , 1, 'LR', 'L');
$fpdf->Cell(1.5 , 0.5, '5' , 1, 'LR', 'C');
$fpdf->Cell(5.6);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(1.1  , 0.5,'No.', 1, 'LR', 'C');
$fpdf->Cell(4.4  , 0.5,'Keterangan', 1, 'LR', 'C');
$fpdf->Cell(3.8  , 0.5,'Nilai Rata-rata Min.', 1, 'LR', 'C');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(2.5  , 0.5, 'Baik'           , 1, 'LR', 'L');
$fpdf->Cell(1.5 , 0.5, '4' , 1, 'LR', 'C');
$fpdf->Cell(5.6);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1.1  , 0.5,'1', 1, 'LR', 'C');
$fpdf->Cell(4.4  , 0.5,'Kontrak', 1, 'LR', 'L');
$fpdf->Cell(3.8  , 0.5,'3 ( Cukup )', 1, 'LR', 'C');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(2.5  , 0.5, 'Cukup'           , 1, 'LR', 'L');
$fpdf->Cell(1.5 , 0.5, '3' , 1, 'LR', 'C');
$fpdf->Cell(5.6);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1.1  , 0.5,'2', 1, 'LR', 'C');
$fpdf->Cell(4.4  , 0.5,'Masa Percobaan', 1, 'LR', 'L');
$fpdf->Cell(3.8  , 0.5,'4  ( Baik )', 1, 'LR', 'C');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(2.5  , 0.5, 'Kurang'           , 1, 'LR', 'L');
$fpdf->Cell(1.5 , 0.5, '2' , 1, 'LR', 'C');
$fpdf->Cell(5.6);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1.1  , 0.5,'3', 1, 'LR', 'C');
$fpdf->Cell(4.4  , 0.5,'Promosi', 1, 'LR', 'L');
$fpdf->Cell(3.8  , 0.5,'4  ( Baik )', 1, 'LR', 'C');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(2.5  , 0.5, 'Sangat kurang'           , 1, 'LR', 'L');
$fpdf->Cell(1.5 , 0.5, '1' , 1, 'LR', 'C');
$fpdf->Cell(5.6);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1.1  , 0.5,'4', 1, 'LR', 'C');
$fpdf->Cell(4.4  , 0.5,'Mutasi', 1, 'LR', 'L');
$fpdf->Cell(3.8  , 0.5,'3 ( Cukup )', 1, 'LR', 'C');

$fpdf->Ln();
$fpdf->Cell(9.6);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(1.1  , 0.5,'5', 1, 'LR', 'C');
$fpdf->Cell(4.4  , 0.5,'Rotasi', 1, 'LR', 'L');
$fpdf->Cell(3.8  , 0.5,'3 ( Cukup )', 1, 'LR', 'C');

// Akhir Tabel Skala dan standar

// Awal Catatan dan kotak TTD
$fpdf->Ln(1.5);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(2.5  , 0.5, 'Catatan :', 0, 'LR', 'L');
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(9.5  , 0.5, '', 0, 'LR', 'L');
$fpdf->Cell(9.4  , 0.5, 'Cikarang,', 0, 'LR', 'L');

$fpdf->Ln();
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.5  , 0.5, '1.', 0, 'LR', 'L');
$fpdf->Cell(11.5  , 0.5, 'Apabila karyawan yang dievaluasi akan dipromosi/ ', 0, 'LR', 'L');
$fpdf->Cell(2.3  , 0.5, 'DIKETAHUI', 1, 'LR', 'C');
$fpdf->Cell(2.3  , 0.5, 'DISETUJUI', 1, 'LR', 'C');
$fpdf->Cell(2.3  , 0.5, 'DIBUAT', 1, 'LR', 'C');

$fpdf->Ln();
$fpdf->Cell(0.5  , 0.5, '', 0, 'LR', 'L');
$fpdf->Cell(11.5  , 0.5, 'mutasi/rotasi. Wajib melampirkan F-Hr-10 (usulan ', 0, 'LR', 'L');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
//$fpdf->Cell(2.5  , 0.5, 'YANG DINILAI', 1, 'LR', 'C');

$fpdf->Ln();
$fpdf->Cell(0.5  , 0.5, '', 0, 'LR', 'L');
$fpdf->Cell(11.5  , 0.5, 'promosi,mutasi,rotasi & data perubahan posisi)', 0, 'LR', 'L');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
//$fpdf->Cell(2.5  , 0.5, '', 'LR', 'C');
/*
$fpdf->Ln();
$fpdf->Cell(0.5  , 0.5, '', 0, 'LR', 'L');
//$fpdf->Cell(11.5  , 0.5, 'selain dasar penilaian umum', 0, 'LR', 'L');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
//$fpdf->Cell(2.5  , 0.5, '', 'LR', 'C');
*/
$fpdf->Ln();
$fpdf->Cell(0.5  , 0.5, '2.', 0, 'LR', 'L');
$fpdf->Cell(11.5  , 0.5, '*)   Diisi untuk pilihan evaluasi promosi,rotasi,mutasi & ', 0, 'LR', 'L');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
//$fpdf->Cell(2.5  , 0.5, '', 'LR', 'C');


$fpdf->Ln();
$fpdf->Cell(0.5  , 0.5, '', 0, 'LR', 'L');
$fpdf->Cell(11.5  , 0.5, '      masa percobaan.', 0, 'LR', 'L');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
$fpdf->Cell(2.3  , 0.5, '','LR', 'C');
//$fpdf->Cell(2.5  , 0.5, '', 'LR', 'C');


$fpdf->Ln();
$fpdf->Cell(0.5  , 0.5, '3.', 0, 'LR', 'L');
$fpdf->Cell(11.5  , 0.5, '**)  Nilai diisi tanpa koma', 0, 'LR', 'L');
$fpdf->SetFont('Arial','',9);
$fpdf->Cell(2.3  , 0.5, 'Mgr. HRD-GA', 1, 'LR', 'C');
$fpdf->Cell(2.3  , 0.5, 'Mgr. Terkait', 1, 'LR', 'C');
$fpdf->Cell(2.3  , 0.5, 'Spv. Terkait', 1, 'LR', 'C');
$fpdf->SetFont('Arial','',8);
//$fpdf->Cell(2.5  , 0.5, 'Karyawan Terakhir', 1,'LR', 'C');
/* wATERMARK
$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',25);
$fpdf->SetTextColor(187 ,180 ,179);
$fpdf->Cell(10 , 1.5, 'CONFIDENTIAL 1', 1,'R', 'R');
// Akhir Catatan dan kotak TTD
*/
/* setting posisi footer 3 cm dari bawah */
//$fpdf->SetY(-3);

/* setting font untuk footer */
//$fpdf->SetFont('Times','',10);

/* setting cell untuk waktu pencetakan */ 
//$fpdf->Cell(9.5, 0.5, 'Printed on : '.date('d/m/Y H:i').' | Created by : Anton Sofyan',0,'LR','L');

/* setting cell untuk page number */
//$fpdf->Cell(9.5, 0.5, 'Page '.$fpdf->PageNo().'/{nb}',0,0,'R');

/* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */
}
$fpdf->Output("penilaian_karyawan.pdf","I");
?>