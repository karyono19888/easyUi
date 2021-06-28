<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('memory_limit', '-1');        
$this->load->library("PHPExcel");
$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getActiveSheet();

$sheet->setCellValue('A1','NOMOR');
$sheet->setCellValue('B1','RESPON');
$sheet->setCellValue('C1','JENIS');
$sheet->setCellValue('D1','USER');
$sheet->setCellValue('E1','DEPT');
$sheet->setCellValue('F1','URAIAN');
$sheet->setCellValue('G1','EXECUTOR');
$sheet->setCellValue('H1','DUEDATE');
$sheet->setCellValue('I1','TANGGAL CLOSE');
$sheet->setCellValue('J1','URAIAN PERBAIKAN');
$sheet->setCellValue('K1','TANGGAL PEMBUATAN');
$sheet->setCellValue('L1',  'SKOR');

$bar = 2;
$kol = -1;

foreach($detail->result() as $data) {
    
    //$sheet->setCellValueByColumnAndRow($kol,   $bar, 'entry');
    $sheet->setCellValueExplicitByColumnAndRow($kol+1, $bar, $data->t_spk_id, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+2, $bar, $data->t_spk_respontime, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+3, $bar, $data->t_spk_jenis, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+4, $bar, $data->t_spk_user, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+5, $bar, $data->departemen_nama, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+6, $bar, $data->t_spk_uraian, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+7, $bar, $data->t_spk_man, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+8, $bar, $data->t_spk_duedate, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+9, $bar, $data->t_spk_closed, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+10, $bar, $data->t_spk_perbaikan, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+11, $bar, $data->t_spk_tgl_pembuatan, PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicitByColumnAndRow($kol+12, $bar, $data->skor, PHPExcel_Cell_DataType::TYPE_STRING);
    
    $bar++;
}

// Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="SPK_IT.xls"');
    header('Cache-Control: max-age=0');

    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;

?>
