<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$string = 'isi string';
$mailto = 0;
if($as == 'requested'){
    $mailto = $Gatepass[0]->requested_mail;
}else if ($as == 'recommended'){
    $mailto = $Gatepass[0]->recommended_mail;
}else if ($as == 'approved'){
    $mailto = $Gatepass[0]->approved_mail;
}else if ($as == 'acknowledged'){
    $mailto = $Gatepass[0]->acknowledged_mail;
}
if($Gatepass[0]->recommendedby_pst_pnr != 0){
    if ($Gatepass[0]->status_recommended == 1) {
        $status_recommended = 'accepted';
      } else if ($Gatepass[0]->status_recommended == 0) {
        $status_recommended = 'waiting';
      } else {
        $status_recommended = 'rejected';
      }
}
if($Gatepass[0]->approvedby_pst_pnr != 0){
    if ($Gatepass[0]->status_approved == 1) {
        $status_approved = 'accepted';
      } else if ($Gatepass[0]->status_approved == 0) {
        $status_approved = 'waiting';
      } else {
        $status_approved = 'rejected';
      }
}
if ($Gatepass[0]->status_acknowledged == 1) {
  $status_acknowledged = 'accepted';
} else if ($Gatepass[0]->status_acknowledged == 0) {
  $status_acknowledged = 'waiting';
} else {
  $status_acknowledged = 'rejected';
}
if ($Gatepass[0]->status == 1) {
  $status_gatepass =  $this->lang->line('DITERIMA DENGAN QRCODE') . $Gatepass[0]->qrcode;
} else {
  $status_gatepass = 'REJECTED';
  if($Gatepass[0]->status_recommended == -1){
    $status_recommended = 'rejected';
    $status_approved = 'rejected';
    $status_acknowledged = 'rejected';
}else if($Gatepass[0]->status_approved == -1){
    $status_acknowledged = 'rejected';
}
}
try {
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com'; // Ganti dengan alamat SMTP server Anda
  $mail->SMTPAuth = true;
  $mail->Username = 'shdsulthon11@gmail.com'; // Ganti dengan email Anda
  $mail->Password = 'kkqe dgiu xdfd wgtu '; // Ganti dengan kata sandi email Anda
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587; // Port SMTP Gmail

  // Set PHPMailer untuk menggunakan mail() bawaan PHP
  // $mail->isMail();

  // Pengaturan email
  $mail->setFrom('shdsulthon11@gmail.com', 'Gatepass System'); // Ganti dengan alamat email dan nama Anda
  $mail->addAddress($mailto, 'To '); // Ganti dengan alamat email penerima
  $mail->Subject = 'NOTIFICATION FROM DSAW GATEPASS SYSTEM';
  $mail->isHTML(true);

  
  if ($as != 'requested') {
    $mail->Body = '
      <!DOCTYPE html>
  <html lang="en">
  
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  
  <body>
      <div>
          <h2>GATEPASS REQUEST</h2>
          <h2>Pesan ini dikirim ke email milik ' . $as .'</h2>
          <table border="1" width="75%">
              <thead>
                  <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                     
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Tanggal Gatepass</td>
                      <td style="padding:10px 20px;" colspan="2">' . $Gatepass[0]->tanggal_gatepass . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Keperluan</td>
                      <td style="padding:10px 20px;" colspan="2">' . $Gatepass[0]->keperluan . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Penjelasan Keperluan</td>
                      <td style="padding:10px 20px;" colspan="2">' . $Gatepass[0]->penjelasan_keperluan . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Perkiraan Jam Keluar</td>
                      <td style="padding:10px 20px;" colspan="2">' . substr($Gatepass[0]->est_time_out, 0, 5) . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Perkiraan Jam Masuk</td>
                      <td style="padding:10px 20px;" colspan="2">' . substr($Gatepass[0]->est_time_in, 0, 5) . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;">requestedby</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->requested_name . '</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->tanggal_gatepass_dibuat . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;">recommendedby</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->recommended_name . '</td>
                      <td style="padding:10px 20px;">' . $status_recommended . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;">approvedby</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->approved_name . '</td>
                      <td style="padding:10px 20px;">' . $status_approved . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;">acknowledgedby</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->acknowledged_name . '</td>
                      <td style="padding:10px 20px;">' . $status_acknowledged . '</td>
                  </tr>
              </tbody>
          </table>
      </div>
      <br>
      
      <a style="display: inline-block; background-color: green; color: #fff; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.25rem;"
      href="' .base_url("mail/approve_from_mail/".base64_encode(1)."/".base64_encode($as)."/".base64_encode($Gatepass[0]->qrcode)."/".base64_encode($Gatepass[0]->id_verifikasi)."/".base64_encode($Gatepass[0]->id_gatepass)."/".base64_encode($Gatepass[0]->id_remarks)). '">Terima</a>
  <a style="display: inline-block; background-color: red; color: #fff; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.25rem;"
      href="' .base_url("mail/approve_from_mail/".base64_encode(-1)."/".base64_encode($as)."/".base64_encode($Gatepass[0]->qrcode)."/".base64_encode($Gatepass[0]->id_verifikasi)."/".base64_encode($Gatepass[0]->id_gatepass)."/".base64_encode($Gatepass[0]->id_remarks)). '">Tolak</a>
  
  </body>
  
  </html>
      ';
  } else {
    $mail->Body = '
      <!DOCTYPE html>
  <html lang="en">
  
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  
  <body>
      <div>
      <h2>Pesan ini dikirim ke email milik ' . $as .'</h2>
      <table border="1">
          <table border="1" width="75%">
              <thead>
                  <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                     
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Tanggal Gatepass</td>
                      <td style="padding:10px 20px;" colspan="2">' . $Gatepass[0]->tanggal_gatepass . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Keperluan</td>
                      <td style="padding:10px 20px;" colspan="2">' . $Gatepass[0]->keperluan . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Penjelasan Keperluan</td>
                      <td style="padding:10px 20px;" colspan="2">' . $Gatepass[0]->penjelasan_keperluan . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Perkiraan Jam Keluar</td>
                      <td style="padding:10px 20px;" colspan="2">' . substr($Gatepass[0]->est_time_out, 0, 5) . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;" colspan="2">Perkiraan Jam Masuk</td>
                      <td style="padding:10px 20px;" colspan="2">' . substr($Gatepass[0]->est_time_in, 0, 5) . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;">requestedby</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->requested_name . '</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->tanggal_gatepass_dibuat . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;">recommendedby</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->recommended_name . '</td>
                      <td style="padding:10px 20px;">' . $status_recommended . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;">approvedby</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->approved_name . '</td>
                      <td style="padding:10px 20px;">' . $status_approved . '</td>
                  </tr>
                  <tr>
                      <td style="padding:10px 20px;">acknowledgedby</td>
                      <td style="padding:10px 20px;">' . $Gatepass[0]->acknowledged_name . '</td>
                      <td style="padding:10px 20px;">' . $status_acknowledged . '</td>
                  </tr>
              </tbody>
          </table>
      </div>
  </body>
  
  </html>
      ';
  }


  $mail->send();
  redirect($redirect);
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>