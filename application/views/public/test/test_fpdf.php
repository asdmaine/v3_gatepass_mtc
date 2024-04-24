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
$pdf->AddPage('P', array(210,297));

// $pdf->useTemplate($tplId, 0, 0, 210); 
// setting size format template
$pdf->useTemplate($tplId, 0, 0, 210,297); 



// format text
$pdf->SetFont('Courier','B',12); 
$pdf->SetTextColor(0,0,255); 


// tulis text

$pdf->SetXY(60, 50);
$text = "[tanggal]";
$pdf->Write(0, $text);

$pdf->SetXY(19, 70);
$text = "X";
$pdf->Write(0, $text);

$pdf->SetXY(69, 70);
$text = "X";
$pdf->Write(0, $text);

$pdf->SetXY(115, 70);
$text = "X";
$pdf->Write(0, $text);

$pdf->SetXY(152.5, 70);
$text = "X";
$pdf->Write(0, $text);

$pdf->SetXY(19, 83);
$pdf->MultiCell(173, 6, '[keperluanpenjelasan][keperluanpenjelasan][keperluanp
enjelasan][keperluanpenjelasan][keperluanpenjelasan][keperluanpenjelasan]', 0, 'L');

$pdf->SetXY(65, 153);
$text = "[00:00]";
$pdf->Write(0, $text);

$pdf->SetXY(154, 153);
$text = "[00:00]";
$pdf->Write(0, $text);

$pdf->SetXY(53, 170);
$text = "[requested]";
$pdf->Write(0, $text);

$pdf->SetXY(53, 187);
$text = "[recommended]";
$pdf->Write(0, $text);

$pdf->SetXY(53, 197);
$text = "[approved]";
$pdf->Write(0, $text);

$pdf->SetXY(53, 208);
$text = "[acknowledged]";
$pdf->Write(0, $text);

$pdf->SetXY(148, 174);
$text = "[sign 1]";
$pdf->Write(0, $text);

$pdf->SetXY(148, 187);
$text = "[sign 2]";
$pdf->Write(0, $text);

$pdf->SetXY(148, 197);
$text = "[sign 3]";
$pdf->Write(0, $text);

$pdf->SetXY(148, 208);
$text = "[sign 4]";
$pdf->Write(0, $text);

$pdf->SetXY(148, 225);
$text = "[00:00]";
$pdf->Write(0, $text);

$pdf->SetXY(148, 235);
$text = "[sign 5]";
$pdf->Write(0, $text);

$pdf->SetXY(65, 225);
$text = "[00:00]";
$pdf->Write(0, $text);

$pdf->SetXY(65, 235);
$text = "[security]";
$pdf->Write(0, $text);

// ambil gambar dari direktori
// $pdf->Image('img/sign.png', 148, 225, 25, 0);

// ambil gambar dari base64
$base64Image = "data:image/png;base64,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"; // Ganti dengan kode base64 gambar Anda
$pdf->Image($base64Image, 148, 225, 25, 0, 'PNG');



// $pdf->SetXY(51, 45); 
// $date = date('F dS, Y');
// $pdf->Write(0, $date);

// end tulis text




$outputFile = 'src/assets/pdf/output.pdf';
$pdf->Output($outputFile,'F');
echo "<script>window.open('welcome/show_pdf', '_blank')</script>";






?>
