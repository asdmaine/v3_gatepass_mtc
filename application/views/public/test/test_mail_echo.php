<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div>
        <h2>GATEPASS REQUEST</h2>
        <h2>Pesan ini dikirim ke <?= $Gatepass[0]->{$as . "_mail"} ?></h2>
        <table border="1">
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
                    <td style="padding:10px 20px;" colspan="2"><?= $Gatepass[0]->tanggal_gatepass ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;" colspan="2">Keperluan</td>
                    <td style="padding:10px 20px;" colspan="2"><?= $Gatepass[0]->keperluan ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;" colspan="2">Penjelasan Keperluan</td>
                    <td style="padding:10px 20px;" colspan="2"><?= $Gatepass[0]->penjelasan_keperluan ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;" colspan="2">Perkiraan Jam Keluar</td>
                    <td style="padding:10px 20px;" colspan="2"><?= $Gatepass[0]->est_time_out ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;" colspan="2">Perkiraan Jam Masuk</td>
                    <td style="padding:10px 20px;" colspan="2"><?= $Gatepass[0]->est_time_in ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">requestedby</td>
                    <td style="padding:10px 20px;"><?= $Gatepass[0]->requested_name  ?></td>
                    <td style="padding:10px 20px;"><?= $Gatepass[0]->tanggal_gatepass_dibuat ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">recommendedby</td>
                    <td style="padding:10px 20px;"><?= $Gatepass[0]->recommended_name  ?></td>
                    <td style="padding:10px 20px;"><?php if($Gatepass[0]->status_recommended == 1){echo 'accepted';}else if($Gatepass[0]->status_recommended == 0){echo 'waiting';}else{echo 'rejected';} ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">approvedby</td>
                    <td style="padding:10px 20px;"><?= $Gatepass[0]->approved_name  ?></td>
                    <td style="padding:10px 20px;"><?php if($Gatepass[0]->status_approved == 1){echo 'accepted';}else if($Gatepass[0]->status_approved == 0){echo 'waiting';}else{echo 'rejected';} ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px;">acknowledgedby</td>
                    <td style="padding:10px 20px;"><?= $Gatepass[0]->acknowledged_name  ?></td>
                    <td style="padding:10px 20px;"><?php if($Gatepass[0]->status_acknowledged == 1){echo 'accepted';}else if($Gatepass[0]->status_acknowledged == 0){echo 'waiting';}else{echo 'rejected';} ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <a style="display: inline-block; background-color: green; color: #fff; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.25rem;"
        href="#terima">Terima</a>
    <a style="display: inline-block; background-color: red; color: #fff; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.25rem;"
        href="#tolak">Tolak</a>

</body>

</html>