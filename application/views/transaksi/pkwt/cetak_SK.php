<?php

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}
// Simple table
function BasicTable($header, $data)
{
    // Header
    $this->Cell(0.9);
    foreach($header as $col)
        $this->Cell(3.4,0.5,$col,1,0,'C');
    $this->Ln();
    // Data    
    foreach($data as $row)
    {
        $this->Cell(0.9);
        foreach($row as $col)
            $this->Cell(3.4,0.5,$col,1,0,'C');
        $this->Ln();
    }
}
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial Arial 10
    $this->SetFont('Arial','',10);;
    // Page number
   // $this->Text(17.9,28.5,'Hal '.$this->PageNo().' / {nb}');
    // Image
   // $this->Image('assets/images/confidential_1.jpg', 11, 27.7,6,1.5);
}

}

// definisi class
$fpdf = new PDF();
// variable awal
date_default_timezone_set('Asia/Jakarta');
//$fpdf->FPDF("P", "cm", "A4");
$fpdf = new PDF('P', 'cm', 'A4'); // A% = 148 x 210
$fpdf->SetMargins(1.5,3.2,1.5);
$fpdf->AliasNbPages();
$fpdf->AddPage();

$company = 'PT SAGATEKNINDO SEJATI';
/// Start Fungsi
//Format Hari 
function fh($tgl)
{
    setlocale (LC_TIME, 'INDONESIAN');
    $tgl = strtotime($tgl);
    $st = strftime( "%A", $tgl);
    return $st;
}
//Format Tanggal 
function ft($tgl)
{
    setlocale (LC_TIME, 'INDONESIAN');
    $tgl = strtotime($tgl);
    $st = strftime( "%d %B %Y", $tgl);
    return $st;
}
//Format Bulan
function ftm($tgl)
{
    setlocale (LC_TIME, 'INDONESIAN');
    $tgl = strtotime($tgl);
    $st = strftime( "%m", $tgl);
    return $st;
}
//Format Tahun
function fty($tgl)
{
    setlocale (LC_TIME, 'INDONESIAN');
    $tgl = strtotime($tgl);
    $st = strftime( "%Y", $tgl);
    return $st;
}
//Fungsi Selisih Bulan
function selisih($start, $end)
{
    $s = strtotime($start);
    $ms = strftime( "%m", $s);
    $ms1 = number_format($ms, 0);
    $ys = strftime( "%y", $s);
    $ys1 = number_format($ys, 0);
    
    $e = strtotime($end);
    $me = strftime( "%m", $e);
    $me1 = number_format($me, 0);
    $ye = strftime( "%y", $e);
    $ye1 = number_format($ye, 0);
    
    $hy = $ye1 - $ys1;
    $hm = $me1 - $ms1;
    
    if ($hy <1){
        return $hm;
    }elseif($hy <2){
        return $hm + 12;
    } else{
        return $hm + 24;
    }
}
function selisih_hari($start, $end)
{
	$datetime1 	= new DateTime($start);
	$datetime2 	= new DateTime($end);
	$difference = $datetime1->diff($datetime2);
	return round($difference->days / 30);
}
//Fungsi Selisih Tahun
function st($start, $end)
{
    $s      = strtotime($start);
    $ys     = strftime( "%y", $s);
    $ys1    = number_format($ys, 0);
    
    $e      = strtotime($end);
    $ye     = strftime( "%y", $e);
    $ye1    = number_format($ye, 0);
    
    return $ye1 - $ys1;
}
function st2($start, $end)
{
    $s = strtotime($start);
    $ms = strftime( "%m", $s);
    $ms1 = number_format($ms, 0);
    $ys = strftime( "%y", $s);
    $ys1 = number_format($ys, 0);
    
    $e = strtotime($end);
    $me = strftime( "%m", $e);
    $me1 = number_format($me, 0);
    $ye = strftime( "%y", $e);
    $ye1 = number_format($ye, 0);
    
    $hy = $ye1 - $ys1;
    $hm = $me1 - $ms1;
    
    if ($hy <1){
        return $hm;
    }else{
        return $hy;
    }
}
function bultah($dat)
{
	if($dat > 2)
		return "bulan";
	else
		return "tahun";
}	
//Fungsi Terbilang
function Terbilang($a)
{
    if ($a === null){
        return '-';
    }else{
        $x = $a;
    $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($x < 12)
        return " " . $abil[$x];
    elseif ($x < 20)
        return Terbilang($x - 10) . " belas";
    elseif ($x < 100)
        return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
    elseif ($x < 200)
        return " seratus" . Terbilang($x - 100);
    elseif ($x < 1000)
        return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
    elseif ($x < 2000)
        return " seribu" . Terbilang($x - 1000);
    elseif ($x < 1000000)
        return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
    elseif ($x < 1000000000)
        return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
    }
}
//Fungsi Tampil Rupiah
function rupiah($std, $spc)
{
    if (($std === NULL) && ($spc === NULL)){
        return '-';
    }else{ 
        return ' Rupiah';
    }
}
//Fungsi Romawi
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
//Fungsi Upah 1 
function upah2($std, $spc)
{
    if (($std ===null) && ($spc === null)){
        return '-';
    }  else if ($std === null){
        $y = number_format($spc, 0, ',','.');
        return $y;
    }  else {
        $y = number_format($std, 0, ',','.');
        return $y;
    }
}
//Fungsi Upah 2
function upah3($std, $spc)
{
    if (($std ===null) && ($spc === null)){
        return 0;
    }  else if ($std === null){        
        return $spc;
    }  else {
        return $std;
    }
}
//Fungsi Untuk Membedakan Jenis Perjanjian Tanpa Tulisan PKWT
function kwt1($kk)
{
    if ($kk === 'I'){
        return '';
    } else if ($kk === 'P'){
        return 'Perpanjangan ';
    } else {
        return 'Pembaharuan ';
    }
}
//Fungsi Untuk Membedakan Jenis Perjanjian Dengan Tulisan PKWT
function kwt2($kk)
{
    if ($kk === 'I'){
        return 'PKWT';
    } else if ($kk === 'P'){
        return 'Perpanjangan PKWT';
    } else {
        return 'Pembaharuan PKWT';
    }
}
//Fungsi Untuk Judul
function kwt3($kk)
{
    if ($kk === 'I'){
        return '';
    } else if ($kk === 'P'){
        return 'PERPANJANGAN ';
    } else {
        return 'PEMBAHARUAN ';
    }
}
//Fungsi Menampilkan Nomor PKWT Di Awal
function tampil_no($kk, $no)
{
    if ($kk === 'I'){
        return '';    
    } else {
        return $no;
    }
}

function huruf_a($kk)
{
    if ($kk === 'I'){
        return '';
    } else {
        return 'a.';
    }
}

function isi_a($kk, $sign_1, $sign_2, $id_1, $id_2, $start_1, $start_2, $end_1, $end_2, $manual_1, $manual_2)
{
    if ($kk === 'I'){
        return '';
    } else if ($kk === 'P'){
        if ($manual_1 != ''){
            return 'PARA PIHAK telah membuat dan menandatangani Perjanjian Kerja Waktu Tertentu Nomor: '.$manual_1.' tertanggal '.ft($start_1).' ("PKWT"). Jangka waktu PKWT tersebut telah berakhir pada tanggal '.ft($end_1).'.';
        } else {
            return 'PARA PIHAK telah membuat dan menandatangani Perjanjian Kerja Waktu Tertentu Nomor: '.$id_1.'/PKWT/HRD-GA/'.Romawi($sign_1).'/'.fty($sign_1).' tertanggal '.ft($start_1).' ("PKWT"). Jangka waktu PKWT tersebut telah berakhir pada tanggal '.ft($end_1).'.';
        }       
    } else {
        if ($manual_2 != ''){
            return 'PARA PIHAK telah membuat dan menandatangani Perjanjian Kerja Waktu Tertentu Nomor: '.$manual_2.' tertanggal '.ft($start_2).' ("PKWT"). Jangka waktu PKWT tersebut telah berakhir pada tanggal '.ft($end_2).'.';
        } else{
            return 'PARA PIHAK telah membuat dan menandatangani Perjanjian Kerja Waktu Tertentu Nomor: '.$id_2.'/PKWT/HRD-GA/'.Romawi($sign_2).'/'.fty($sign_2).' tertanggal '.ft($start_2).' ("PKWT"). Jangka waktu PKWT tersebut telah berakhir pada tanggal '.ft($end_2).'.';
        }
        
    }
}

function huruf_b($kk)
{
    if ($kk === 'I'){
        return '';
    } else {
        return 'b.';
    }
}

function isi_b($kk, $id_1, $sign_1, $start_1, $end_1, $manual_1)
{
    if ($kk === 'I'){
        return '';
    } elseif($kk === 'P'){
        return 'PIHAK PERTAMA setuju untuk memperpanjang PKWT dan PIHAK KEDUA setuju untuk menerima perpanjangan PKWT tersebut dengan jangka waktu Perpanjangan PKWT sebagaimana disepakati dalam dokumen Perpanjangan PKWT ini.';
    } else {
        if ($manual_1 != ''){
            return 'Selanjutnya PARA PIHAK telah membuat dan menandatangani Perpanjangan Perjanjian Kerja Waktu Tertentu Nomor: '.$manual_1.' tertanggal '.ft($start_1).' ("Perpanjangan PKWT"). Jangka waktu Perpanjangan PKWT tersebut telah berakhir pada tanggal '.ft($end_1).'.';
        } else{
            return 'Selanjutnya PARA PIHAK telah membuat dan menandatangani Perpanjangan Perjanjian Kerja Waktu Tertentu Nomor: '.$id_1.'/PKWT/HRD-GA/'.Romawi($sign_1).'/'.fty($sign_1).' tertanggal '.ft($start_1).' ("Perpanjangan PKWT"). Jangka waktu Perpanjangan PKWT tersebut telah berakhir pada tanggal '.ft($end_1).'.';
        }
        
    }
}

function huruf_c($kk)
{
    if ($kk === 'II'){
        return 'c.';
    } else {
        return '';
    }
}

function isi_c($kk)
{
    if ($kk === 'II'){
        return 'PIHAK PERTAMA setuju untuk memperbaharui PKWT yang terakhir dan telah memenuhi syarat jeda lebih dari 30 hari sebagaimana diatur dalam UU No. 13 tahun 2003 tentang Ketenagakerjaan. PIHAK KEDUA setuju untuk menerima pembaharuan PKWT yang terakhir tersebut dengan jangka waktu Pembaharuan PKWT sebagaimana disepakati dalam dokumen Pembaharuan PKWT ini.';
    } else {
        return '';
    }
}

function awal_bawah($kk)
{
    if ($kk === 'I'){
        return 'PARA PIHAK setuju dan sepakat untuk membuat PKWT dengan syarat-syarat dan ketentuan-ketentuan sebagaimana tersebut dalam pasal-pasal sebagai berikut :';
    } elseif ($kk === 'P') {
        return 'Berdasarkan hal-hal diatas maka PARA PIHAK setuju dan sepakat untuk membuat Perpanjangan PKWT dengan syarat-syarat dan ketentuan-ketentuan sebagaimana tersebut dalam pasal-pasal sebagai berikut:';   
    } else {
        return 'Berdasarkan hal-hal diatas maka PARA PIHAK setuju dan sepakat untuk membuat Pembaharuan PKWT dengan syarat-syarat dan ketentuan-ketentuan sebagaimana tersebut dalam pasal-pasal sebagai berikut:';
    }
}

function pasal2_2($kk)
{
    if ($kk === 'I'){
        return 'Setelah berakhirnya jangka waktu tersebut, jika PIHAK PERTAMA menilai PIHAK KEDUA dapat melaksanakan pekerjaannya dengan baik dan atas Perjanjian bersama maka PKWT ini dapat diperpanjang atau diperbaharui sesuai dengan ketentuan dalam Pasal 59 Undang-undang Nomor 13 tahun 2003 tentang Ketenagakerjaan.';
    } else if ($kk === 'P'){
        return 'Setelah berakhirnya jangka waktu tersebut, jika PIHAK PERTAMA menilai PIHAK KEDUA dapat melaksanakan pekerjaannya dengan baik dan atas kesepakatan bersama maka Perpanjangan PKWT ini dapat diperbaharui sesuai dengan ketentuan dalam Pasal 59 Undang-undang Nomor 13 tahun 2003 tentang Ketenagakerjaan.';
    } else {
        return 'Dokumen PKWT atau Perpanjangan PKWT merupakan satu kesatuan dan bagian yang tidak dapat dipisahkan dari Pembaharuan PKWT ini.';
    }
}

function pasal2_3($kk)
{
    if ($kk === 'I'){
        return 'Dokumen Perpanjangan PKWT atau Pembaharuan PKWT merupakan satu kesatuan dan bagian yang tidak dapat dipisahkan dari PKWT ini.';
    } else if ($kk === 'P'){
        return 'Dokumen PKWT atau Pembaharuan PKWT merupakan satu kesatuan dan bagian yang tidak dapat dipisahkan dari Perpanjangan PKWT ini.';
    } else {
        return '';
    }
}

function pasal2_3_c($kk)
{
    if ($kk === 'II'){
        return  '';
    } else {
        return '(3)';
    }        
}

function pasal4_1_a_ii_1($jab)
{
    if ($jab == 1 || $jab == 7 || $jab == 13 || $jab == 14 || $jab == 15){
        return '';
    } else {
        return 'ii.';
    }        
}

function pasal4_1_a_ii_2($jab)
{
    if ($jab == 1 || $jab == 7 || $jab == 13 || $jab == 14 || $jab == 15){
        return '';
    } else {
        return 'PIHAK PERTAMA berkewajiban membayarkan upah lembur kepada PIHAK KEDUA sesuai ketentuan Keputusan Menteri Tenaga Kerja Dan Transmigrasi Republik Indonesia Nomor KEP.102/MEN/VI/2004 dan/atau ketentuan hukum lainnya.';
    }        
}

function pasal8_1 ($kk)
{
    if ($kk === 'P'){
        return 'pembaharuan PKWT';
    } else {
        return 'perpanjangan atau pembaharuan PKWT';        
    }
}

function jadwal ($wd)
{  
    return 'assets/schedules/'.$wd;
}

function jarak_1($kk)
{
    if ($kk === 'I'){
        return -2;
    } elseif ($kk === 'P') {
        return -0.5;
    } else {
        return 0;
    }
}

function jarak_2($kk)
{
    if ($kk === 'II'){
        return -1;
    } else {
        return 0;
    }
}

function jarak_atas_tabel($kk, $I_top, $P_top, $II_top)
{
    if ($kk === 'I'){
        return $I_top;
    } elseif ($kk === 'P') {
        return $P_top;
    } else {
        return $II_top;
    }
}

function jarak_bawah_tabel($kk, $I_bottom, $P_bottom, $II_bottom)
{
    if ($kk === 'I'){
        return $I_bottom;
    } elseif ($kk === 'P') {
        return $P_bottom;
    } else {
        return $II_bottom;
    }
}

///End Fungsi

///Awal Data Ditampilkan
foreach ($pkwtsk->result() as $data) {
    //Awal Pembuatan Variable Yang Akan Ditampilkan
    $tgl_buat   = 'Cikarang  ' . ft($data->pkwt_tgl_terbit);
    $no_pkwt    =  $data->pkwt_id . '/STS-KT/' . Romawi($data->pkwt_sign) . '/' . fty($data->pkwt_sign);
    $no_pkwtp1    = $data->pkwt_id . '/PP-PKWT/HRD/' . Romawi($data->pkwt_sign) . '/' . fty($data->pkwt_sign);
    $paragrap1  = 'Merujuk ke surat Perjanjian Waktu Tertentu No. :' . $no_pkwtp1 . ' yang telah di tandatangani bersama antara pihak Perusahaan sengan Saudara tertanggal ' . ft($data->pkwt_sign) .
        ' dengan ini kami ingin memberitahukan bahwa jangka waktu perjanjian tersebut akan berakhir pada tanggal ' . ft($data->pkwt_end);
    $paragrap2  = 'Berdasarkan hal tersebut dan mengacu kepada Peraturan Perundang-undangan yang berlaku, kami bermaksud memperpanjang Perjanjian Kerja Waktu Tertentu dengan Saudara. Dengan demikian Perpanjangan Perjanjian Kerja Waktu Tertentu antara Perusahaan dengan Saudara akan dimulai dan ditandatangani pada tanggal ' . ft($data->pkwt_tgl_suratp3);
    $paragrap3  = 'Demikian pemberitahuan ini kami sampaikan';
    $paragrap4  = 'Atas perhatian dan kerjasamanya kami ucapkan terima kasih.';

    //Akhir Pembuatan Variable Yang Akan Ditampilkan

    // Start Title
    $fpdf->Ln(1);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->Cell(0, 1, 'SURAT KEPUTUSAN', 0, 0, 'C');
    $fpdf->Ln(1);
    $fpdf->SetFont('Arial', 'B', 10);
    $fpdf->Cell(0, 0.5, $no_pkwt, 0, 1, 'C');
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(0, 0.5, 'Tentang', 0, 0, 'C');
    $fpdf->Ln(1);
    $fpdf->SetFont('Arial', 'B', 10);
    $fpdf->Cell(0, 0.5, 'PENGANGKATAN KARYAWAN TETAP PT.SAGATEKNINDO SEJATI', 0, 0, 'C');
    $fpdf->Ln(0.5);
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(3, 0.5, 'Menimbang', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->Cell(0.3, 0.5, '1', 0, 0, 'C');
    $fpdf->MultiCell(15, 0.5, 'Menunjang Operasional Perusahaaan sekaligus memenuhi kebutuhan karyawan di Departemen  ' . $data->departemen, 0, 'L');
    $fpdf->Ln(0);
    $fpdf->Cell(3, 0.5, '', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->Cell(0.3, 0.5, '2', 0, 0, 'C');
    $fpdf->MultiCell(15, 0.5, 'Berdasarkan pengalaman dan penilaian yang objectif Sdr/i ' . strtoupper($data->m_emply_name) . ' telah memenuhi syarat untuk di angkat sebagai karyawan tetap', 0, 'L');
    $fpdf->Ln(0.2);
    $fpdf->Cell(3, 0.5, 'Mengingat', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->Cell(0.3, 0.5, '1', 0, 0, 'C');
    $fpdf->MultiCell(15, 0.5, 'Undang undang RI Nomor 13 Tahun 2003 tentang Ketenagakerjaan Pasal 63 ayat (2);', 0, 'L');
    $fpdf->Ln(0);
    $fpdf->Cell(3, 0.5, 'Mengingat', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->Cell(0.3, 0.5, '2', 0, 0, 'C');
    $fpdf->MultiCell(15, 0.5, 'Kebutuhan akan sumber daya manusia (SDM) di PT.SAGATEKNINDO SEJATI', 0, 'L');
    $fpdf->Ln(0.3);
    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->Cell(0, 0.5, 'MEMUTUSKAN', 0, 0, 'C');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->MultiCell(15, 0.5, '', 0, 'L');
    $fpdf->Ln(0.2);
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(3, 0.5, 'Menetapkan', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->MultiCell(15, 0.5, '', 0, 'L');
    $fpdf->Ln(0);
    $fpdf->Cell(3, 0.5, 'Pertama', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->MultiCell(15, 0.5, 'Dengan ini mengangkat Sdr/i  ' . strtoupper($data->m_emply_name), 0, 'L');
    $fpdf->Ln(0.5);
    $fpdf->Cell(3, 0.5, '', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->Cell(2, 0.5, 'Alamat', 0,0 ,'L');
    $fpdf->Cell(0.2, 0.5, ':', 0, 'C');
    $fpdf->MultiCell(12.5, 0.5, $data->m_emply_add ,0, 'L');
    $fpdf->Ln(1);
    $fpdf->Cell(3, 0.5, '', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->SetFont('Arial', 'B', 10);
    $fpdf->MultiCell(15.03, 0.5, 'Sebagai Karyawan Tetap PT. SAGATEKNINDO SEJATI pada bagian  '.$data->departemen, 0, 'L');
    $fpdf->Ln(0.5);
    $fpdf->Cell(3, 0.5, '', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(5, 0.5, 'Terhitung sejak tanggal ', 0, 'L');
    $fpdf->Cell(0.3, 0.5, ': ', 0, 'C');
    $fpdf->Cell(9, 0.5, ft($data->pkwt_tgl_berlaku_sk), 0, 'L');
    $fpdf->Ln(0.5);
    $fpdf->Cell(3, 0.5, '', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(5, 0.5, 'Jabatan', 0, 'L');
    $fpdf->Cell(0.3, 0.5, ': ', 0, 'C');
    $fpdf->Cell(9, 0.5,$data->m_jabatan_nama, 0, 'L');
    $fpdf->Ln(0.5);
    $fpdf->Cell(3, 0.5, '', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, '', 0, 0, 'C');
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(5, 0.5, 'NIK', 0, 'L');
    $fpdf->Cell(0.3, 0.5, ': ', 0, 'C');
    $fpdf->Cell(9, 0.5, $data->m_emply_nik, 0, 'L');
    $fpdf->Ln(1);
    $fpdf->Cell(3, 0.5, 'Kedua', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->MultiCell(15.03, 0.5, 'Gaji, tunjangan dan fasilitas di sesuaikan dengan jabatan dan peraturan yang berlaku', 0, 'L');
    $fpdf->Ln(0.5);
    $fpdf->Cell(3, 0.5, 'Ketiga', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->MultiCell(15.03, 0.5, 'Tugas dan kewajiban serta wewenang akan di atur lebih lanjut oleh Manager '.$data->departemen, 0, 'L');
    $fpdf->Ln(0.5);
    $fpdf->Cell(3, 0.5, 'Keempat', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->MultiCell(15.03, 0.5, 'Dalam melaksanakan tugas dan tanggung jawab Saudara bertanggung jawab kepada Manager '.$data->departemen, 0, 'L');
    $fpdf->Ln(0.5);
    $fpdf->Cell(3, 0.5, 'Kelima', 0, 0, 'L');
    $fpdf->Cell(0.3, 0.5, ':', 0, 0, 'C');
    $fpdf->MultiCell(15.03, 0.5, 'Surat keputusan ini ditetapkan untuk dapat dilaksanakan sebagaimana mestinya, apabila dalam ketetapan Surat Keputusan ini terdapat kesalahan/kekurangan, maka akan diperbaiki seperlunya di kemudian hari ', 0, 'L');



    /////////////

    $fpdf->Ln(1);
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(12, 0.5, '', 0, 0, 'R');
    $fpdf->Cell(6, 0.5, 'Cikarang '.ft($data->pkwt_tgl_buat_sk), 0, 0, 'C');
    $fpdf->Ln(0.5);
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(12, 0.5, '', 0, 0, 'C');
    $fpdf->Cell(6, 0.5, 'PT. Sagateknindo Sejati', 0, 0, 'C');

    $fpdf->Ln(2);
    $fpdf->SetFont('Arial', '', 10);
    $fpdf->Cell(0, 0.5, '______________________________', 0, 0, 'R');

    $fpdf->Ln(0.5);
    $fpdf->Cell(12, 0.5, '', 0, 0, 'C');
    $fpdf->Cell(6, 0.5, 'Nama: Nuri Ahmadi SH', 0, 0, 'C');

    $fpdf->Ln(0.5);
    $fpdf->Cell(12, 0.5, '', 0, 0, 'C');
    $fpdf->Cell(6, 0.5, 'Manager HRD', 0, 0, 'C');
}

$fpdf->Output("Surat Pemberitahuan Perpnajangan PKWT.pdf", "I");
