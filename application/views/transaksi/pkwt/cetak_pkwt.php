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
    $this->Text(17.9,28.5,'Hal '.$this->PageNo().' / {nb}');
    // Image
    $this->Image('assets/images/confidential_1.jpg', 11, 27.7,6,1.5);
}

}

// definisi class
$fpdf = new PDF();
// variable awal
date_default_timezone_set('Asia/Jakarta');
//$fpdf->FPDF("P", "cm", "A4");
$fpdf = new PDF('P', 'cm', 'A4'); // A% = 148 x 210
$fpdf->SetMargins(1.5,4.5,1.5);
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
    $st = strftime( "%y", $tgl);
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
    if ($jab == 1 || $jab == 2 || $jab == 3 || $jab == 8 ){
        return '';
    } else {
        return 'ii.';
    }        
}

function pasal4_1_a_ii_2($jab)
{
    if ($jab == 1 || $jab == 2 || $jab == 3 || $jab == 8){
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
foreach($pkwt->result() as $data)
{
//Awal Pembuatan Variable Yang Akan Ditampilkan

$judul      = kwt3($data->pkwt_kk).'PERJANJIAN KERJA WAKTU TERTENTU';
$no_pkwt    = 'No. : '.$data->pkwt_id.'/PKWT/HRD-GA/'.Romawi($data->pkwt_sign).'/'.fty($data->pkwt_sign);
$paragrap_1 = kwt1($data->pkwt_kk).'Perjanjian Kerja Waktu Tertentu '.tampil_no($data->pkwt_kk, $no_pkwt).' (selanjutnya disebut "'.kwt2($data->pkwt_kk).'") '.'ini dibuat dan ditandatangani di Cikarang pada hari ini '.fh($data->pkwt_sign).', tanggal '.ft($data->pkwt_sign).', oleh dan antara:';
$I          = $company.' , suatu perseroan terbatas yang didirikan menurut hukum Negara Republik Indonesia, berkedudukan di Jl. Raya Serang Cibarusah Rt 010/02 Cikarang 17550 dalam hal ini diwakili oleh Bpk. Nuri Ahmadi SH sebagai  Manager HRD selaku kuasa dari Bapak Rudy Teo selaku Direktur Utama '.$company.' berdasarkan Surat Kuasa tertanggal 01/09/2020 No.002/SK/DIR/STS/IX/2020 oleh karenanya sah bertindak untuk dan atas nama '.$company.' (selanjutnya disebut sebagai PIHAK PERTAMA);';
$II         = 'Dalam hal ini bertindak untuk dan atas namanya sendiri, selanjutnya dalam PKWT ini disebut sebagai PIHAK KEDUA.';
$IIbawah    = awal_bawah($data->pkwt_kk);
$pasal1_1   = $data->m_jabatan_nama.' / '.$data->dept_name;
$pasal2_1   = kwt2($data->pkwt_kk).' berlaku untuk jangka waktu '.selisih_hari($data->pkwt_start, $data->pkwt_end).' ('.ucwords(Terbilang(selisih_hari($data->pkwt_start, $data->pkwt_end))).' ) '.bultah(selisih($data->pkwt_start, $data->pkwt_end)).' terhitung mulai tanggal '.ft($data->pkwt_start).' sampai dengan tanggal '.ft($data->pkwt_end).' ("Tanggal Pengakhiran"), dengan batas maksimal waktu kontrak kerja sesuai perundangan-undangan ketenagakerjaan yang berlaku dan peraturan pelaksanaannya.';
$pasal2_2   = pasal2_2($data->pkwt_kk);
$pasal2_3   = pasal2_3($data->pkwt_kk);
$pasal2_3_c = pasal2_3_c($data->pkwt_kk);
$pasal4_1_a_i = 'Upah pokok yang dibayarkan PIHAK PERTAMA Selama terikat hubungan kerja kepada PIHAK KEDUA adalah sebesar Rp. '.upah2($data->salary_amt,$data->pkwt_spc_salary).' ,- '.'( '.ucwords(terbilang(upah3($data->salary_amt,$data->pkwt_spc_salary))).rupiah($data->salary_amt,$data->pkwt_spc_salary).' )'.' per bulan.';
//$pasal4_1_a_i = 'Upah pokok yang dibayarkan PIHAK PERTAMA Selama terikat hubungan kerja kepada PIHAK KEDUA adalah sebesar Rp.                                                                                                            (                                                                                                                            ) per bulan.';
$pasal8_1   = pasal8_1($data->pkwt_kk);

//Akhir Pembuatan Variable Yang Akan Ditampilkan

// Start Title
$fpdf->Ln(0);
$fpdf->SetFont('Arial','B',12);
$fpdf->Cell(0,0.5,$judul,0,0,'C');
$fpdf->Ln();
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,$no_pkwt,0,0,'C');
// Paragraph 1
$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->MultiCell(0,0.5,$paragrap_1,0,'J');
// I
$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'I.',0,0,'L');
$fpdf->MultiCell(0,0.5,$I,0,'J');
// II
$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'II.',0,0,'L');
$fpdf->Cell(4,0.5,'Nama',0,0,'L');
$fpdf->Cell(0.5,0.5,':',0,0,'C');
$fpdf->Cell(0,0.5,$data->m_emply_name,0,0,'L');

$fpdf->Ln();
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(4,0.5,'Jenis kelamin',0,0,'L');
$fpdf->Cell(0.5,0.5,':',0,0,'C');
$fpdf->Cell(0,0.5,$data->m_emply_sex,0,0,'L');

$fpdf->Ln();
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(4,0.5,'Kawin / belum kawin',0,0,'L');
$fpdf->Cell(0.5,0.5,':',0,0,'C');
$fpdf->Cell(0,0.5,$data->m_emply_marital,0,0,'L');

$fpdf->Ln();
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(4,0.5,'Tempat / tgl lahir',0,0,'L');
$fpdf->Cell(0.5,0.5,':',0,0,'C');
$fpdf->Write(0.5,$data->m_emply_bop);
$fpdf->Write(0.5,' / ');
$fpdf->Write(0.5,ft($data->m_emply_bod));


$fpdf->Ln();
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(4,0.5,'No. KTP',0,0,'L');
$fpdf->Cell(0.5,0.5,':',0,0,'C');
$fpdf->Cell(0,0.5,$data->m_emply_ktp,0,0,'L');

$fpdf->Ln();
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(4,0.5,'Alamat',0,0,'L');
$fpdf->Cell(0.5,0.5,':',0,0,'C');
$fpdf->MultiCell(0,0.5,$data->m_emply_add,0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,$II,0,'J');

$fpdf->Ln(0.5);
$fpdf->MultiCell(0,0.5,'(PIHAK PERTAMA dan PIHAK KEDUA secara sendiri-sendiri selanjutnya disebut sebagai "PIHAK" dan secara bersama-sama selanjutnya disebut sebagai "PARA PIHAK").',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,huruf_a($data->pkwt_kk),0,0,'L');
$fpdf->MultiCell(0,0.5,isi_a($data->pkwt_kk, $data->sign_1, $data->sign_2, $data->id_1, $data->id_2, $data->start_1, $data->start_2, $data->end_1, $data->end_2, $data->manual_1, $data->manual_2),0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,huruf_b($data->pkwt_kk),0,0,'L');
$fpdf->MultiCell(0,0.5,isi_b($data->pkwt_kk, $data->id_1, $data->sign_1, $data->start_1, $data->end_1, $data->manual_1),0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,huruf_c($data->pkwt_kk),0,0,'L');
$fpdf->MultiCell(0,0.5,isi_c($data->pkwt_kk),0,'J');

$fpdf->Ln(jarak_1($data->pkwt_kk));

$fpdf->Ln(0.5);
$fpdf->MultiCell(0,0.5,$IIbawah,0,'J');

// HAL 1

// PASAL 1  
$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 1',0,0,'C');
$fpdf->Ln();
$fpdf->Cell(0,0.5,'RUANG LINGKUP DAN JASA',0,0,'C');
// PASAL 1-1
$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA setuju dan sepakat menerima PIHAK KEDUA bekerja di '.$company.' dan PIHAK KEDUA setuju dan sepakat bekerja di '.$company.' dengan Jabatan/Bagian sebagai berikut:',0,'J');

$fpdf->Ln();
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(4,0.5,'Jabatan/Bagian',0,0,'L');
$fpdf->Cell(0.5,0.5,':',0,0,'C');
$fpdf->Cell(0,0.5,$pasal1_1,0,0,'L');

$fpdf->Ln();
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(4,0.5,'Lokasi Tugas',0,0,'L');
$fpdf->Cell(0.5,0.5,':',0,0,'C');
$fpdf->Cell(0,0.5,'Pabrik  dan/atau di luar Pabrik '.$company,0,0,'L');
// PASAL 1-2
$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PARA PIHAK sepakat bahwa PIHAK PERTAMA berhak untuk memindahkan PIHAK KEDUA ke posisi pekerjaan lainnya, sebagaimana dibutuhkan oleh '.$company.', jika menurut pertimbangan PIHAK PERTAMA, PIHAK KEDUA dianggap memenuhi kualifikasi pekerjaan untuk jabatan/jenis pekerjaan lain tersebut dan sesuai dengan kemampuan (skill) PIHAK KEDUA.',0,'J');
//PASAL 1-3
$fpdf->Ln(0.5);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(3)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA bersedia untuk ditempatkan dan atau mutasi atau rotasi ke bagian lain yang dipandang sesuai dengan kebutuhan '.$company.'.',0,'J');
// PASAL 1-4
$fpdf->Ln(0.5);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(4)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA setuju menerima dan sanggup melaksanakan semua tugas dan kewajiban sehubungan dengan pekerjaan yang diberikan oleh PIHAK PERTAMA sebagaimana dimaksud pasal ini.',0,'J');
// PASAL 2
$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 2',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'JANGKA WAKTU PKWT',0,0,'C');
// PASAL 2-1
$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,$pasal2_1,0,'J');
// PASAL 2-2
$fpdf->Ln(0.5);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,$pasal2_2,0,'J');
// PASAL 2-3
$fpdf->Ln(0.5);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,$pasal2_3_c,0,0,'L');
$fpdf->MultiCell(0,0.5,$pasal2_3,0,'J');
// PASAL 3
$fpdf->Ln(jarak_2($data->pkwt_kk));
$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 3',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'HARI KERJA DAN JAM KERJA',0,0,'C');
// PASAL 3-1
$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
//$fpdf->MultiCell(0,0.5,'Jam kerja di '.$company.' adalah '.$data->workday_hour.', apabila jam kerja melebihi ketentuan dihitung jam kerja lembur.',0,'J');
$fpdf->MultiCell(0,0.5,'Jam kerja di '.$company.' adalah :',0,'J');
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'a. 7 (tujuh) jam sehari atau 40 (empat puluh) jam seminggu atau 6 (enam) hari kerja, dan atau',0,'J');
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'b. 8 (delapan) jam sehari atau 40 (empat puluh) jam seminggu atau 5 (lima) hari kerja.',0,'J');
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila jam kerja melebihi ketentuan dihitung jam kerja lembur.',0,'J');
// PASAL 3-2
$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA dengan ini setuju dan menyepakati serta wajib mematuhi ketentuan hari kerja dan jam kerja yang telah diatur oleh PIHAK PERTAMA untuk melaksanakan lingkup pekerjaan sebagaimana yang ditetapkan dalam  Pasal 1 '.kwt2($data->pkwt_kk).' yaitu sebagai berikut :',0,'J');

$fpdf->Ln(jarak_atas_tabel($data->pkwt_kk, $data->workday_I_top, $data->workday_P_top, $data->workday_II_top));
//Start Table
$fpdf->Ln(0.5);
$fpdf->BasicTable(array('Shift', 'Hari', 'Jam Kerja', 'Istirahat'),$fpdf->LoadData(jadwal($data->workday_path)));
//End Table
$fpdf->Ln(jarak_bawah_tabel($data->pkwt_kk, $data->workday_I_bottom, $data->workday_P_bottom, $data->workday_II_bottom));

// PASAL 3-3
$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(3)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila dibutuhkan oleh PIHAK PERTAMA, PIHAK KEDUA dapat diminta untuk melakukan pekerjaan diluar hari dan jam kerja yang telah ditentukan/ melakukan lembur dengan adanya persetujuan dari PIHAK KEDUA.',0,'J');
// PASAL 3-4
$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(4)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PARA PIHAK setuju bahwa PIHAK PERTAMA dapat merubah hari kerja dan jam kerja sebagaimana yang telah ditetapkan pada ayat (1) diatas dan akan disesuaikan dengan Undang-undang ketenagakerjaan yang berlaku di Indonesia yang mengatur mengenai waktu kerja dimana pelaksanaannya akan dituangkan melalui Surat Keputusan Direksi dan merupakan bagian yang tidak dapat dipisahkan dari '.kwt2($data->pkwt_kk).' ini.',0,'J');

/////////////
// PASAL 4
$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 4',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'UPAH DAN TUNJANGAN LAINNYA',0,0,'C');
// PASAL 4-1
$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Selama terikat hubungan kerja, PIHAK PERTAMA memberikan kepada PIHAK KEDUA upah dan tunjangan-tunjangan sebagai berikut:',0,'J');
// PASAL 4-1-A
$fpdf->Ln(0);
$fpdf->Cell(1.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'a.',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA membayar upah kepada PIHAK KEDUA terdiri dari:',0,'J');
// PASAL 4-1-A-I
$fpdf->Ln(0);
$fpdf->Cell(2.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'i.',0,0,'L');
$fpdf->MultiCell(0,0.5,$pasal4_1_a_i,0,'J');
// PASAL 4-1-A-II
$fpdf->Ln(0.5);
$fpdf->Cell(2.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,pasal4_1_a_ii_1($data->pkwt_post),0,0,'L');
$fpdf->MultiCell(0,0.5,pasal4_1_a_ii_2($data->pkwt_post),0,'J');

// PASAL 4-2
$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Tunjangan dan fasilitas yang diberikan PIHAK PERTAMA kepada PIHAK KEDUA adalah sebagai berikut:',0,'J');
// PASAL 4-2-A
$fpdf->Ln(0);
$fpdf->Cell(1.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'a.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Tunjangan Tetap',0,'J');
// PASAL 4-2-A-I
$fpdf->Ln(0);
$fpdf->Cell(2.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'i.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Tunjangan Jabatan',0,'J');
$fpdf->Ln(0);
$fpdf->Cell(3.5,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA membayar tunjangan jabatan kepada PIHAK KEDUA yang menjabat jabatan tertentu dan besarnya tunjangan jabatan diatur dalam surat Keputusan Direksi.',0,'J');
// PASAL 4-2-A-II
$fpdf->Ln(0.5);
$fpdf->Cell(2.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'ii.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Tunjangan Hari Raya (THR).',0,'J');
$fpdf->Ln(0);
$fpdf->Cell(3.5,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'Besarnya Tunjangan Hari Raya (THR) adalah 1 (satu) bulan upah pokok berikut tunjangan tetap apabila masa kerja PIHAK KEDUA 12 (dua belas) bulan atau lebih. Namun apabila masa kerja PIHAK KEDUA kurang dari 12 (dua belas) bulan tetapi sudah 1 (satu) bulan atau lebih, maka Tunjangan Hari Raya (THR) akan diberikan secara proporsional.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(3.5,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'Pembayaran Tunjangan Hari Raya (THR) dilakukan selambat-lambatnya 1  (satu) minggu sebelum  Hari Raya.',0,'J');
// PASAL 4-2-B
$fpdf->Ln(0.5);
$fpdf->Cell(1.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'b.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Tunjangan Tidak Tetap dan Fasilitas',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(2.5,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'Tunjangan tidak tetap yang dibayarkan oleh PIHAK PERTAMA kepada PIHAK KEDUA adalah sebagai berikut:',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(2.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'i.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Tunjangan Shift dengan ketentuan sebagai berikut:',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(4,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'-',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA membayar tunjangan shift dengan jam kerja Shift 2 (dua)   kepada PIHAK KEDUA  sebesar Rp. 2.000 ( Dua Ribu Rupiah) per hadir.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(4,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'-',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA membayar tunjangan shift dengan jam kerja Shift 3 (tiga)   kepada PIHAK KEDUA  sebesar Rp. 3.000 ( Tiga Ribu Rupiah) per hadir.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(2.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'ii.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Tunjangan Transport',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(3.5,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA membayar tunjangan transport sebesar Rp.7.500 (Tujuh Ribu Lima Ratus Rupiah) per hadir kepada PIHAK KEDUA yang  tidak dapat menikmati  fasilitas yang telah disediakan oleh PIHAK PERTAMA sesuai dengan Perjanjian Kerja Bersama.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(2.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'iii.',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA memberikan fasilitas BPJS kepada PIHAK KEDUA sesuai dengan Peraturan Perundang-undangan dan Perjanjian Kerja Bersama yang berlaku.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(2.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'iv.',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA menyediakan fasilitas makan sekali pada setiap hari kerja.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(3)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Diluar dari ketentuan Pasal 4 ayat 1 '.kwt2($data->pkwt_kk).' diatas, PIHAK PERTAMA tidak berkewajiban untuk memberikan tunjangan maupun fasilitas lainnya kepada PIHAK KEDUA kecuali diatur lain oleh peraturan perundang-undangan.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(4)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA berhak mendapatkan pendapatan dan tunjangan sebagaimana disebutkan dalam Pasal 4 '.kwt2($data->pkwt_kk).' ini sejak PIHAK KEDUA mulai bekerja aktif.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(5)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Pembayaran upah dan tunjangan jabatan diberikan kepada PIHAK KEDUA setiap akhir bulan berjalan. Apabila tanggal pembayaran tersebut jatuh pada hari sabtu, minggu atau libur nasional, maka pembayaran akan dilakukan sebelum hari libur tersebut.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(6)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Pembayaran upah lembur dan tunjangan-tunjangan lainnya diberikan kepada PIHAK KEDUA setiap tanggal 15 pada bulan berikutnya. Apabila tanggal pembayaran tersebut jatuh pada hari sabtu, minggu atau libur nasional, maka pembayaran akan dilakukan sebelum hari libur tersebut.',0,'J');

//$fpdf->Ln(0.5);
//$fpdf->Cell(0.75,0.5,'(7)',0,0,'L');
//$fpdf->MultiCell(0,0.5,'Upah ditinjau ulang setiap awal tahun dengan mempertimbangkan UMR sesuai SK Gubernur Jawa Barat yang berlaku pada saat tahun berjalan.',0,'J');

/////////////

$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 5',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'PEDOMAN, TATA TERTIB KERJA DAN LAINNYA',0,0,'C');

$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,kwt2($data->pkwt_kk).' ini tunduk kepada Keputusan Menteri Tenaga Kerja Dan Transmigrasi Republik Indonesia Nomor KEP.100/MEN/VI/2004 dan/atau ketentuan hukum lainnya.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA wajib melakukan tugas yang diberikan dan ditentukan oleh PIHAK PERTAMA.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(3)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA wajib dan akan selalu mematuhi serta mentaati segala peraturan perusahaan yang berlaku di PIHAK PERTAMA, maupun peraturan-peraturan lain yang ditetapkannya.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(4)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA tidak bertanggung jawab atas janji lisan atau tulisan yang diberikan oleh siapapun yang isinya tidak sesuai dengan syarat-syarat yang tercantum dalam '.kwt2($data->pkwt_kk).' ini.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(5)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Selama jangka waktu '.kwt2($data->pkwt_kk).' ini belum berakhir, PIHAK KEDUA tidak dibenarkan melakukan kerja rangkap di perusahaan lain manapun, kecuali jika telah mendapat persetujuan secara tertulis dari PIHAK PERTAMA.',0,'J');

/////////////

$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 6',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'KERAHASIAAN',0,0,'C');

$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA wajib untuk menjaga kerahasiaan serta tidak diperkenankan untuk memberikan informasi tanpa persetujuan secara tertulis terlebih dahulu dari PIHAK PERTAMA atas data-data, informasi, spesifikasi, bahan-bahan atau dokumen lain dalam bentuk apapun yang diketahui oleh PIHAK KEDUA karena hubungan kerjanya dengan PIHAK PERTAMA ("Informasi Rahasia") kepada pihak ketiga manapun.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Dengan tidak mengurangi ketentuan ayat 6.1 diatas, PIHAK KEDUA setuju dan menjamin PIHAK PERTAMA bahwa PIHAK KEDUA tidak akan menyebarluaskan atau melakukan publikasi dengan cara apapun juga atas setiap Informasi Rahasia yang diterima sejak ditandatanganinya '.kwt2($data->pkwt_kk).' ini dan akan tetap berlaku setelah berakhirnya '.kwt2($data->pkwt_kk).' ini. Untuk tujuan tersebut PIHAK KEDUA tidak akan melakukan penggandaan dan/atau penyebarluasan atas Informasi Rahasia tanpa persetujuan secara tertulis dari PIHAK PERTAMA, kecuali kepada pihak-pihak yang berkaitan dengan pelaksanaan pekerjaan sebagaimana diatur dalam '.kwt2($data->pkwt_kk).' ini.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(3)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA berkewajiban untuk memegang teguh kerahasiaan PIHAK PERTAMA, terutama yang dipercayakan secara khusus kepada PIHAK KEDUA. Untuk setiap pelanggaran kerahasiaan sebagaimana dimaksud di atas, PIHAK KEDUA berkewajiban untuk memberikan ganti rugi kepada Perusahaan seluruh kerugian, ongkos/biaya yang timbul sehubungan dengan pelanggaran kerahasiaan tersebut dan PIHAK PERTAMA berhak untuk menjatuhkan sanksi sampai dengan sanksi terberat dan melakukan tindakan hukum dalam bentuk apapun terhadap PIHAK KEDUA.',0,'J');

////////

$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 7',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'HAK CUTI',0,0,'C');

$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA belum berhak mendapatkan cuti sebelum masa kerja 1 (satu) tahun.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK PERTAMA berhak menunda cuti PIHAK KEDUA apabila ada tugas/pekerjaan yang harus diselesaikan oleh PIHAK KEDUA.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(3)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Hak Cuti tidak dapat diuangkan.',0,'J');

////// 

$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 8',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'BERAKHIRNYA '.kwt2($data->pkwt_kk),0,0,'C');

$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,kwt2($data->pkwt_kk).' ini akan berakhir secara otomatis pada Tanggal Pengakhiran dan PIHAK PERTAMA berhak untuk tidak melakukan '.$pasal8_1.' tersebut.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'Dalam hal ini kedua belah pihak setuju dan sepakat bahwa secara otomatis ikatan hubungan kerja antara PIHAK PERTAMA dengan PIHAK KEDUA dianggap selesai dan PIHAK PERTAMA tidak mempunyai kewajiban untuk memberikan uang pesangon, uang penghargaan masa kerja, uang penggantian hak atau uang pisah atau membayar kompensasi dalam bentuk apapun kepada PIHAK KEDUA.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,kwt2($data->pkwt_kk).' ini  akan berakhir sebelum Tanggal Pengakhiran, apabila terjadi peristiwa-peristiwa:',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'a.',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA tidak berhasil mencapai standar performa kerja yang telah ditetapkan oleh PIHAK PERTAMA;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'b.',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA membocorkan rahasia dan strategi perusahaan kepada pihak lain;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'c.',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA melakukan pelanggaran terhadap ketentuan-ketentuan, tata tertib, perusahaan sebagaimana diatur dalam peraturan perusahaan ataupun keputusan/ ketetapan PIHAK PERTAMA;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'d.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila karena sesuatu hal PIHAK KEDUA secara sepihak untuk mengundurkan diri sebelum jangka waktu PKWT berakhir;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'e.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Diputuskan oleh Perusahaan atas dasar adanya perbuatan-perbuatan yang merugikan Perusahaan dan atau adanya pelanggaran baik terhadap ketentuan-ketentuan dalam perjanjian ini dan atau terhadap ketentuan-ketentuan dalam Peraturan Perusahaan atau Pedoman Sangsi dan Tata Tertib Perusahaan;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'f.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila ternyata PIHAK KEDUA telah memberikan keterangan - keterangan yang tidak benar mengenai dirinya kepada pihak pertama baik surat lamarannnya maupun pada saat wawancara, maka PIHAK PERTAMA berhak memutuskan Perjanjian kerja ini secara sepihak tanpa adanya tuntutan apapun, kecuali upah yang belum dibayarkan pada bulan itu;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'g.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila ada perpindahan tempat kerja ke anak perusahaan atau afiliasi dari PIHAK PERTAMA, maka PIHAK PERTAMA akan mengajukan Perjanjian baru kepada PIHAK KEDUA dan PIHAK PERTAMA akan menyelesaikan hubungan kerja dengan PIHAK KEDUA sesuai ketentuan yang berlaku;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'h.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila PIHAK KEDUA meninggal dunia maka PIHAK PERTAMA tidak berkewajiban membayar upah kepada PIHAK KEDUA;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'i.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Terjadi peristiwa bencana alam, bencana non alam( wabah penyakit), perang, kerusuhan sosial, gangguan keamanan yang mengakibatkan '.kwt2($data->pkwt_kk).' ini tidak mungkin lagi untuk dilanjutkan.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(3)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila PIHAK PERTAMA mengakhiri '.kwt2($data->pkwt_kk).' ini sebelum Tanggal Pengakhiran atau berakhirnya hubungan kerja bukan dikarenakan alasan Pasal 8 ayat 2 huruf h dan i , maka PIHAK PERTAMA wajib memenuhi seluruh ketentuan ganti kerugian yang diatur dalam ketentuan di bidang ketenagakerjaan yang berlaku di Indonesia.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(4)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila PIHAK KEDUA mengakhiri '.kwt2($data->pkwt_kk).' sebelum Tanggal Pengakhiran sebagaimana yang telah ditetapkan dalam Pasal 2 ayat (1) '.kwt2($data->pkwt_kk).' maka PIHAK KEDUA wajib mengajukan pengunduran diri dengan membuat pemberitahuan tertulis kepada PIHAK PERTAMA selambat-lambatnya 1 (satu) bulan sebelumnya dan PIHAK KEDUA wajib untuk membayar ganti rugi kepada PIHAK PERTAMA sebesar upah sisa masa kontrak / '.kwt2($data->pkwt_kk).' kepada PIHAK PERTAMA sebagaimana diatur dalam ketentuan ketenagakerjaan yang berlaku di Indonesia kecuali PIHAK PERTAMA menentukan kebijakan lainnya sepanjang  tidak bertentangan dengan ketentuan peraturan perundang-undangan yang berlaku.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->MultiCell(0,0.5,'Sehubungan dengan pengunduran diri PIHAK KEDUA diatas, PIHAK PERTAMA tidak berkewajiban membayar upah untuk sisa waktu yang telah diperjanjikan.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(5)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Sehubungan dengan pengakhiran '.kwt2($data->pkwt_kk).' diatas PIHAK KEDUA tidak berhak untuk mengajukan tuntutan-tuntutan, klaim, gugatan hukum dalam bentuk apapun baik secara perdata, pidana maupun perselisihan hubungan industrial kepada PIHAK PERTAMA, manajemen (Direksi dan/atau Komisaris), pemegang saham dan karyawan '.$company.' dikemudian hari.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(6)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Sehubungan dengan pengunduran diri PIHAK KEDUA diatas, PIHAK PERTAMA tidak berkewajiban untuk memberikan Surat Referensi Kerja kepada PIHAK KEDUA dan PIHAK KEDUA tidak berhak untuk meminta Surat Referensi Kerja kepada PIHAK PERTAMA.',0,'J');

/////////////

$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 9',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'PERNYATAAN DAN JAMINAN PIHAK KEDUA',0,0,'C');

$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA dengan ini menyatakan dan menjamin hal-hal sebagai berikut:',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'a.',0,0,'L');
$fpdf->MultiCell(0,0.5,'bahwa pada saat penandatanganan '.kwt2($data->pkwt_kk).' ini PIHAK KEDUA tidak terikat pada hubungan kerja dengan pihak manapun;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'b.',0,0,'L');
$fpdf->MultiCell(0,0.5,'bahwa seluruh informasi, data-data dan dokumen yang disampaikan PIHAK KEDUA kepada PIHAK PERTAMA pada saat rekruitmen karyawan merupakan informasi, data-data dan dokumen yang sebenarnya dan PIHAK KEDUA menjamin keasliannya dokumen-dokumen tersebut;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'c.',0,0,'L');
$fpdf->MultiCell(0,0.5,'PIHAK KEDUA akan melaksanakan dan mentaati seluruh ketentuan dalam '.kwt2($data->pkwt_kk).', Peraturan Perusahaan dan keputusan/ketetapan PIHAK PERTAMA;',0,'J');

$fpdf->Ln(0);
$fpdf->Cell(0.75,0.5,'',0,0,'L');
$fpdf->Cell(0.75,0.5,'d.',0,0,'L');
$fpdf->MultiCell(0,0.5,'Sehubungan dengan pengakhiran Pembaharuan '.kwt2($data->pkwt_kk).' PIHAK KEDUA menjamin tidak akan mengajukan tuntutan-tuntutan, klaim, gugatan hukum dalam bentuk apapun baik secara perdata, pidana maupun perselisihan hubungan industrial kepada PIHAK PERTAMA, manajemen (Direksi dan/atau Komisaris), pemegang saham dan karyawan '.$company.' dikemudian hari.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila pernyataan dan jaminan PIHAK KEDUA diatas terbukti tidak benar, maka PIHAK PERTAMA berhak untuk melakukan tindakan/sanksi sampai dengan sanksi Pemutusan Hubungan Kerja (PHK) terhadap PIHAK KEDUA dan berhak untuk menuntut ganti kerugian atau melakukan tindakan hukum dalam bentuk apapun terhadap PIHAK KEDUA.',0,'J');

/////////////

$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 10',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'PENYELESAIAN PERSELISIHAN HUBUNGAN INDUSTRIAL',0,0,'C');

$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Apabila di kemudian hari terjadi perselisihan hubungan industrial dalam pelaksanaan ketentuan-ketentuan dari '.kwt2($data->pkwt_kk).' ini, maka PARA PIHAK sepakat untuk terlebih dahulu menyelesaikan perselisihan hubungan industrial tersebut secara musyawarah untuk mufakat.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Dalam hal penyelesaian secara musyawarah untuk mufakat sebagaimana dimaksud dalam ayat (1) diatas tidak tercapai, maka PARA PIHAK menyelesaikan perselisihan hubungan industrial melalui prosedur penyelesaian hubungan industrial yang diatur dalam ketentuan di bidang ketenagakerjaan yang berlaku di Indonesia.',0,'J');

/////////////

$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(0,0.5,'Pasal 11',0,0,'C');

$fpdf->Ln(0.5);
$fpdf->Cell(0,0.5,'KETENTUAN LAIN - LAIN',0,0,'C');

$fpdf->Ln(1);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.75,0.5,'(1)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Segala ketentuan dan syarat-syarat '.kwt2($data->pkwt_kk).' ini berlaku serta mengikat bagi PARA PIHAK yang menandatangani '.kwt2($data->pkwt_kk).'.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(2)',0,0,'L');
$fpdf->MultiCell(0,0.5,kwt2($data->pkwt_kk).' ini tidak dapat diubah, diganti atau dilepaskan kecuali berdasarkan persetujuan tertulis yang ditandatangani oleh PARA PIHAK atau kuasanya yang sah.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(3)',0,0,'L');
$fpdf->MultiCell(0,0.5,'PARA PIHAK sepakat bahwa hal-hal yang belum diatur dalam '.kwt2($data->pkwt_kk).' ini akan diatur secara tertulis di dalam suatu Addendum '.kwt2($data->pkwt_kk).' serta ditandatangani oleh PARA PIHAK dan merupakan satu kesatuan serta merupakan bagian yang tidak terpisahkan dari '.kwt2($data->pkwt_kk).' ini.',0,'J');

$fpdf->Ln(0.5);
$fpdf->Cell(0.75,0.5,'(4)',0,0,'L');
$fpdf->MultiCell(0,0.5,'Segala bentuk lampiran-lampiran dalam '.kwt2($data->pkwt_kk).' merupakan satu kesatuan serta merupakan bagian yang tidak terpisahkan dari '.kwt2($data->pkwt_kk).' ini.',0,'J');

/////////////

$fpdf->Ln(0.5);
$fpdf->MultiCell(0,0.5,'Demikian '.kwt2($data->pkwt_kk).' ditandatangani oleh kedua belah pihak dalam keadaan sehat jasmani dan rohani, tanpa paksaan dari pihak lain.',0,'J');


$fpdf->Ln(0.5);
$fpdf->MultiCell(0,0.5,kwt2($data->pkwt_kk).' ini di buat oleh PIHAK PERTAMA dan PIHAK KEDUA dalam rangkap 2 (dua) yang masing-masing mempunyai kekuatan hukum yang sama dan masing-masing PIHAK akan memperoleh asli 1 (satu) salinan '.kwt2($data->pkwt_kk).' ini.',0,'J');


/////////////

$fpdf->Ln(0.5);
$fpdf->SetFont('Arial','B',10);
$fpdf->Cell(7.5,0.5,'PIHAK PERTAMA',0,0,'L');
$fpdf->Cell(5.5,0.5,'PIHAK KEDUA',0,0,'C');

$fpdf->Ln(3);
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(9,0.5,'______________________________',0,0,'L');
$fpdf->Cell(9,0.5,'______________________________',0,0,'L');

$fpdf->Ln(0.5);
$fpdf->Cell(9,0.5,'Nama: Nuri Ahmadi SH',0,0,'L');
$fpdf->Cell(9,0.5,'Nama: '.$data->m_emply_name,0,0,'L');

$fpdf->Ln(0.5);
$fpdf->Cell(9,0.5,'Jabatan: Manager HRD',0,0,'L');

/*
$fpdf->Ln(2.5);
$fpdf->SetFont('Arial','U',10);
$fpdf->Cell(8.7,0.5,'( Ir. Bambang T. )',0,0,'L');
$fpdf->Cell(8.7,0.5,'( Ir. Bambang T. )',0,0,'L');
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.3,0.5,'(',0,0,'L');
$fpdf->SetFont('Arial','U',10);
$fpdf->Cell(5.5,0.5,$data->emply_name,0,0,'C');
$fpdf->SetFont('Arial','',10);
$fpdf->Cell(0.3,0.5,')',0,0,'R');
 * 
 * 
 */
 
/* wATERMARK
$fpdf->Ln(1);
$fpdf->SetFont('Arial','B',25);
$fpdf->SetTextColor(187 ,180 ,179);
$fpdf->Cell(10 , 1.5, 'CONFIDENTIAL 1', 1,'R', 'R');
// Akhir Catatan dan kotak TTD
*/
/* setting posisi footer 3 cm dari bawah */
//$fpdf->SetY(-1);

/* setting font untuk footer */
//$fpdf->SetFont('Arial','',10);

/* setting cell untuk waktu pencetakan */ 
//$fpdf->Cell(9.5, 0.5, 'Printed on : '.date('d/m/Y H:i').' | Created by : Anton Sofyan',0,'LR','L');

/* setting cell untuk page number */
//$fpdf->SetY(-15);
//$fpdf->Cell(0, 10, 'Page '.$fpdf->PageNo().'/{nb}',0,0,'C');
//$fpdf->Cell(9.5, 0.5, 'Page '.$fpdf->PageNo().'/{nb}',0,0,'R');

/* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */
}

$fpdf->Output("penilaian_karyawan.pdf","I");
?>