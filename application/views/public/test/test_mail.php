<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$string = 'isi string';

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
    $mail->addAddress('sulthon.sdn@gmail.com', 'To '); // Ganti dengan alamat email penerima
    $mail->Subject = 'DSAW GATEPASS SYSTEM';
    $mail->isHTML(true);
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
        <table border="1">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:10px 20px;">Nama Pemohon </td>
                    <td style="padding:10px 20px;">'. $string .'</td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">Tanggal Gatepass</td>
                    <td style="padding:10px 20px;">"Tanggal Gatepass"</td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">Keperluan</td>
                    <td style="padding:10px 20px;">"Keperluan"</td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">Penjelasan Keperluan</td>
                    <td style="padding:10px 20px;">"Penjelasan Keperluan"</td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">Perkiraan Jam Keluar</td>
                    <td style="padding:10px 20px;">"Perkiraan Jam Keluar"</td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">Perkiraan Jam Masuk</td>
                    <td style="padding:10px 20px;">"Perkiraan Jam Masuk"</td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <a>Accept</a>
    <button>Reject</button>
</body>

</html>
    ';

    $mail->send();
    echo 'Email has been sent successfully';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>