<?php
use setasign\Fpdi\Fpdi;



// initiate FPDI
$pdf = new Fpdi();

// pilih format template
$pdf->setSourceFile("src/assets/pdf/format_gatepass.pdf");


// ambil page 1
$tplId = $pdf->importPage(1);

// use the imported page and place it at point 5,5 with your preferred width in mm
// setting potrait dan ukuran a4
$pdf->AddPage('P', array(210, 297));

// $pdf->useTemplate($tplId, 0, 0, 210); 
// setting size format template
$pdf->useTemplate($tplId, 0, 0, 210, 297);

if($Gatepass[0]->status == 1){
  $pdf->Image(base_url('src/assets/img/accept.png'),100, 0, 100, 100);
}else{
  $pdf->Image(base_url('src/assets/img/reject.png'),100, 0, 100, 100);
}


// format text
$pdf->SetFont('Courier', 'B', 12);
$pdf->SetTextColor(0, 0, 255);


// tulis text

$pdf->SetXY(60, 50);
$pdf->Write(0, $Gatepass[0]->tanggal_gatepass);

if ($Gatepass[0]->keperluan == 'urusan_perusahaan') {
  $pdf->SetXY(19, 70);
  $text = 'X';
  $pdf->Write(0, $text);
} else if ($Gatepass[0]->keperluan == 'urusan_keluarga') {
  $pdf->SetXY(69, 70);
  $text = "X";
  $pdf->Write(0, $text);
} else if ($Gatepass[0]->keperluan == 'sakit') {
  $pdf->SetXY(115, 70);
  $text = "X";
  $pdf->Write(0, $text);
} else if ($Gatepass[0]->keperluan == 'lain-lain') {
  $pdf->SetXY(152.5, 70);
  $text = "X";
  $pdf->Write(0, $text);
}

$pdf->SetXY(19, 83);
$pdf->MultiCell(173, 6, $Gatepass[0]->penjelasan_keperluan, 0, 'L');


$pdf->SetXY(65, 153);
$pdf->Write(0, substr($Gatepass[0]->est_time_out, 0, 5));

$pdf->SetXY(154, 153);
$pdf->Write(0, substr($Gatepass[0]->est_time_in, 0, 5));

$pdf->SetXY(65, 225);
$pdf->Write(0, substr($Gatepass[0]->real_time_out, 0, 5));

$pdf->SetXY(148, 225);
$pdf->Write(0, substr($Gatepass[0]->real_time_in, 0, 5));




$char_limit = 35;
$pdf->SetXY(53, 170);
$pdf->MultiCell(52, 5, substr($Gatepass[0]->requestedby_pst_name, 0, $char_limit), 0, 'L');
$pdf->SetXY(53, 181);
$pdf->MultiCell(52, 5, substr($Gatepass[0]->recommended_name, 0, $char_limit), 0, 'L');
$pdf->SetXY(53, 192);
$pdf->MultiCell(52, 5, substr($Gatepass[0]->approved_name, 0, $char_limit), 0, 'L');
$pdf->SetXY(53, 203);
$pdf->MultiCell(52, 5, substr($Gatepass[0]->acknowledged_name, 0, $char_limit), 0, 'L');
$pdf->SetXY(65, 229);
$pdf->MultiCell(40, 5, substr($Gatepass[0]->securityout_name, 0, 12), 0, 'L');
$pdf->SetXY(148, 229);
$pdf->MultiCell(40, 5, substr($Gatepass[0]->securityin_name, 0, 12), 0, 'L');

$pdf->SetTextColor(255, 0, 0);
// requested signature
if (isset($Gatepass[0]->requested_signature)) {
  $pdf->Image($Gatepass[0]->requested_signature, 148, 174, 25, 0, 'PNG');
}

// recommended signature
if ($Gatepass[0]->status_recommended == 1) {
  if (isset($Gatepass[0]->recommended_signature)) {
    $pdf->Image($Gatepass[0]->recommended_signature, 148, 182, 25, 0, 'PNG');
  }
}else if($Gatepass[0]->status_recommended == 0) {

}
 else {
  $pdf->SetXY(148, 182);
  $pdf->Write(0, 'rejected');
 }
// approved signature
if ($Gatepass[0]->status_approved == 1) {
  if (isset($Gatepass[0]->approved_signature)) {
    $pdf->Image($Gatepass[0]->approved_signature, 148, 194, 25, 0, 'PNG');
  }
}else if($Gatepass[0]->status_approved == 0) {
 
}
 else {
  $pdf->SetXY(148, 194);
  $pdf->Write(0, 'rejected');
 }
if ($Gatepass[0]->status_acknowledged == 1) {
  // acknowledged signature
  if (isset($Gatepass[0]->acknowledged_signature)) {
    $pdf->Image($Gatepass[0]->acknowledged_signature, 148, 205, 25, 0, 'PNG');
  }
}else if($Gatepass[0]->status_acknowledged == 0) {
 
}
 else {
  $pdf->SetXY(148, 205);
  $pdf->Write(0, 'rejected');
 }
// security out signature
if (isset($Gatepass[0]->securityout_signature)) {
  $pdf->Image($Gatepass[0]->securityout_signature, 65, 232, 25, 0, 'PNG');
}

// security in signature
if (isset($Gatepass[0]->securityin_signature)) {
  $pdf->Image($Gatepass[0]->securityin_signature, 148, 232, 25, 0, 'PNG');
}

$pdf->AddPage('P', array(210, 297));

if (isset($Gatepass[0]->qrcode_64)) {
  $pdf->Image('data:image/png;base64,' . $Gatepass[0]->qrcode_64, 50, 15, 100, 0, 'PNG');
}

$pdf->SetFont('Courier', 'B', 25);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(72, 20);
$pdf->Write(0, $Gatepass[0]->qrcode);

$pdf->Output('DSAW_GATEPASS.pdf', 'I');







?>