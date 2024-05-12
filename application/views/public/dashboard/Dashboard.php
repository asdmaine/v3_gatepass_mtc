<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    #sig-canvas {
      border: 2px solid #CCCCCC;
      cursor: crosshair;
    }
  </style>
</head>

<body>
  <?php
  if (isset($_GET['alert'])) {
    if ($_GET['alert'] == 'ditolak') {
      echo '<script>console.log("' . $this->lang->line('Akses ditolak') . '!")</script>';
      echo '<script>alert("' . $this->lang->line('Akses ditolak') . '!")</script>';
      echo '<script>
    setTimeout(function() {
        var newUrl = window.location.href.split("?")[0];
        window.history.replaceState({}, document.title, newUrl);
    }, 5000); // Menghapus parameter setelah 2 detik
</script>';
    }
    if ($_GET['alert'] == 'limit') {
      echo '<script>console.log("' . $this->lang->line('Anda sudah gatepass hari ini') . '!")</script>';
      echo '<script>alert("' . $this->lang->line('Anda sudah gatepass hari ini') . '!")</script>';
      echo '<script>
      setTimeout(function() {
          var newUrl = window.location.href.split("?")[0];
          window.history.replaceState({}, document.title, newUrl);
      }, 5000); // Menghapus parameter setelah 2 detik
  </script>';
    }
  }

  ?>

  <?php
  $bulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
  $gatepassAcceptData = array_fill(0, 12, 0);
  foreach ($diterima as $key) {
    $bulanIndex = $key->bulan - 1;
    $jumlah = $key->jumlah;
    $gatepassAcceptData[$bulanIndex] = $jumlah;
    echo 'diterima bulan : ' . $key->bulan . ', dengan jumlah : ' . $key->jumlah . '<br>';
  } ?>
  <?php
  $gatepassRejectData = array_fill(0, 12, 0);
  foreach ($ditolak as $key) {
    $bulanIndex = $key->bulan - 1;
    $jumlah = $key->jumlah;
    $gatepassRejectData[$bulanIndex] = $jumlah;
    echo 'ditolak bulan : ' . $key->bulan . ', dengan jumlah : ' . $key->jumlah . '<br>';
  } ?>
  <?php
  $gatepassRequestData = array_fill(0, 12, 0);
  foreach ($diajukan as $key) {
    $bulanIndex = $key->bulan - 1;
    $jumlah = $key->jumlah;
    $gatepassRequestData[$bulanIndex] = $jumlah;
    echo 'diajukan bulan : ' . $key->bulan . ', dengan jumlah : ' . $key->jumlah . '<br>';
  } ?>


  <?php
  $gatepassAcceptDataLast = array_fill(0, 12, 0);
  foreach ($diterimaLast as $key) {
    $bulanIndex = $key->bulan - 1;
    $jumlah = $key->jumlah;
    $gatepassAcceptDataLast[$bulanIndex] = $jumlah;
    echo 'diterima bulan : ' . $key->bulan . ', dengan jumlah : ' . $key->jumlah . '<br>';
  } ?>
  <?php
  $gatepassRejectDataLast = array_fill(0, 12, 0);
  foreach ($ditolakLast as $key) {
    $bulanIndex = $key->bulan - 1;
    $jumlah = $key->jumlah;
    $gatepassRejectDataLast[$bulanIndex] = $jumlah;
    echo 'ditolak bulan : ' . $key->bulan . ', dengan jumlah : ' . $key->jumlah . '<br>';
  } ?>
  <?php
  $gatepassRequestDataLast = array_fill(0, 12, 0);
  foreach ($diajukanLast as $key) {
    $bulanIndex = $key->bulan - 1;
    $jumlah = $key->jumlah;
    $gatepassRequestDataLast[$bulanIndex] = $jumlah;
    echo 'diajukan bulan : ' . $key->bulan . ', dengan jumlah : ' . $key->jumlah . '<br>';
  } ?>
  
  <main class="content px-4 py-4">
    <div class="container-fluid">
      <div class="mb-5 text-center text-uppercase">
        <!-- <h4>Dashboard</h4> -->
      </div>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-danger" id="btn-sig" data-toggle="modal" data-target="#ModalSignature">
        E-Signature
      </button>

      <div class="row mb-5 text-white">
        <div class="col-xl-4 col-md-6 col-sm-12 p-2">
          <div class="bg-primary d-flex flex-column p-4 shadow">
            <h3 class="mb-3"><?= $this->lang->line('Gatepass anda Bulan ini') ?> (<?= date('M') ?>)</h3>
            <h2 class="font-weight-bold mb-0 text-right"><?= $this_month ?></h2>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-12 p-2">
          <div class="bg-primary  d-flex flex-column p-4 shadow">
            <h3 class="mb-3"><?= $this->lang->line('Gatepass anda Bulan lalu') ?> (<?php $date = date('M', strtotime('-1 month'));
               echo $date; ?>)
            </h3>
            <h2 class="font-weight-bold mb-0 text-right"><?= $last_month ?></h2>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-12 p-2">
          <div class="bg-primary d-flex flex-column p-4 shadow">
            <h3 class="mb-3"><?= $this->lang->line('Gatepass anda Tahun ini') ?> (<?= date('Y') ?>)</h3>
            <h2 class="font-weight-bold mb-0 text-right"><?= $this_year ?></h2>
          </div>
        </div>


        <?php if (isset($this->logindata['hr'])) { ?>

          <!-- <div class="col-xl-4 col-md-6 col-sm-12 p-2">
            <div style="background: #30E8BF;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #FF8235, #30E8BF);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #FF8235, #30E8BF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            " class="d-flex flex-column p-4 shadow">
              <h3 class="mb-3"><?= $this->lang->line('Total Gatepass Karyawan Bulan ini') ?> (<?= date('M') ?>)</h3>
              <h2 class="font-weight-bold mb-0 text-right"><?= $all_this_month ?></h2>
            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-sm-12 p-2">
            <div class="d-flex flex-column p-4 shadow">
            <div style="background: #3a6186;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #89253e, #3a6186);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #89253e, #3a6186); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            " class="d-flex flex-column p-4 shadow">
              <h3 class="mb-3"><?= $this->lang->line('Total Gatepass Karyawan Bulan lalu') ?> (<?php $date = date('M', strtotime('-1 month'));
                 echo $date; ?>)
              </h3>
              <h2 class="font-weight-bold mb-0 text-right"><?= $all_last_month ?></h2>
            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-sm-12 p-2">
            <div
              style="background: #c2e59c;  /* fallback for old browsers */
              background: -webkit-linear-gradient(to right, #64b3f4, #c2e59c);  /* Chrome 10-25, Safari 5.1-6 */
              background: linear-gradient(to right, #64b3f4, #c2e59c); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */"
              class="d-flex flex-column p-4 shadow">
              <h3 class="mb-3"><?= $this->lang->line('Total Gatepass Karyawan Tahun ini') ?> (<?= date('Y') ?>)</h3>
              <h2 class="font-weight-bold mb-0 text-right"><?= $all_this_year ?></h2>
            </div>
          </div> -->


          <div class="col-md-6 col-sm-12 p-2">
            <div class="d-flex flex-column p-4 shadow">
              <h4 class="text-secondary text-center mb-4">Gatepass chart <?= date('Y') ?></h4>
              <canvas id="gatepassChart"></canvas>
              <script src="chart_script.js"></script>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 p-2">
            <div class="d-flex flex-column p-4 shadow">
              <h4 class="text-secondary text-center mb-4">Gatepass chart <?= date('Y') - 1 ?></h4>
              <canvas id="gatepassChartLast"></canvas>
              <script src="chart_script.js"></script>
            </div>
          </div>
        <?php } ?>
      </div>

      <hr>



      <!-- table-progress -->
      <div id="table-progress" class="row">
        <!-- konversi data progress -->
        <div class="table-responsive">
          <h6 class="text-center text-uppercase mb-3"><?= $this->lang->line('Progres Gatepass anda') ?></h6>
          <table class="table table-striped table-bordered">
            <thead class="text-center">
              <tr>
                <td scope="col">#</td>
                <td scope="col"><?= $this->lang->line('Tanggal') ?></td>
                <td scope="col"><?= $this->lang->line('Keperluan') ?></td>
                <td scope="col">Recommended by</td>
                <td scope="col">Approved by</td>
                <td scope="col">Acknowledged by</td>
                <td scope="col"><?= $this->lang->line('Aksi') ?></td>
              </tr>
            </thead>
            <tbody>
              <!-- SHOW -->
              <tr class="text">
                <?php foreach ($Progress as $pg) {

                  if (empty($pg->id_gatepass)) { ?>
                    <!-- <tr class="text">
                  <th class="text-center align-middle text-uppercase" colspan="7">no data to be shown</th>
                </tr> -->
                  <?php } else {
                    $recommended_name = $pg->recommended_name;
                    $approved_name = $pg->approved_name;
                    $acknowledged_name = $pg->acknowledged_name;
                    $verif_date_recommendedby = $pg->verif_date_recommendedby;
                    $verif_date_approvedby = $pg->verif_date_approvedby;
                    $verif_date_acknowledgedby = $pg->verif_date_acknowledgedby;
                    $status_recommended = $pg->status_recommended;
                    $status_approved = $pg->status_approved;
                    $status_acknowledged = $pg->status_acknowledged;
                    ?>
                    <th class="text-center align-middle">1</th>
                    <td class="text-center align-middle">
                      <?= $pg->tanggal_gatepass ?>
                    </td>
                    <td class="align-middle text-uppercase">
                      <?= $pg->keperluan ?>
                    </td>
                    <!-- RECOMMENDED -->
                    <td class="text-center">
                      <?php if ($status_recommended == 1) { ?>
                        <div class="btn btn-success" id="OpenModalInfo" data-content="<?php $content_recommended = 'Accepted by ' . $recommended_name . ' at ' . $verif_date_recommendedby;
                        echo $content_recommended; ?>">
                          Accepted</div>
                      <?php } elseif ($status_recommended == 0) {
                        $status_approved = 0;
                        $approved_name = $recommended_name;
                        $verif_date_approvedby = $verif_date_recommendedby;
                        $status_acknowledged = 0;
                        $acknowledged_name = $recommended_name;
                        $verif_date_acknowledgedby = $verif_date_recommendedby;
                        ?>
                        <div class="btn btn-secondary" id="OpenModalInfo" data-content="<?php $content_recommended = 'Still waiting ' . $recommended_name;
                        echo $content_recommended;
                        $content_approved = $content_recommended;
                        $content_acknowledged = $content_recommended; ?>">Waiting</div>
                      <?php } elseif ($status_recommended == -1) {
                        $status_approved = -1;
                        $approved_name = $recommended_name;
                        $verif_date_approvedby = $verif_date_recommendedby;
                        $status_acknowledged = -1;
                        $acknowledged_name = $recommended_name;
                        $verif_date_acknowledgedby = $verif_date_recommendedby;
                        ?>
                        <div class="btn btn-danger" id="OpenModalInfo" data-content="<?php $content_recommended = 'Rejected by ' . $recommended_name . ' at ' . $verif_date_recommendedby;
                        echo $content_recommended;
                        $content_approved = $content_recommended;
                        $content_acknowledged = $content_recommended; ?>">
                          Rejected</div>
                      <?php } ?>
                    </td>
                    <!-- END RECOMMENDED -->

                    <!-- APROVED -->
                    <td class="text-center">
                      <?php if ($status_approved == 1) { ?>
                        <div class="btn btn-success" id="OpenModalInfo" data-content="<?php $content_approved = 'Accepted by ' . $approved_name . ' at ' . $verif_date_approvedby;
                        echo $content_approved; ?>">
                          Accepted</div>
                      <?php } elseif ($status_approved == 0) {
                        $status_acknowledged = 0;
                        $acknowledged_name = $approved_name;
                        $verif_date_acknowledgedby = $verif_date_approvedby;
                        ?>
                        <div class="btn btn-secondary" id="OpenModalInfo" data-content="<?php $content_approved = 'Still waiting ' . $approved_name;
                        echo $content_approved;
                        $content_acknowledged = $content_approved; ?>">
                          Waiting</div>
                      <?php } elseif ($status_approved == -1) {
                        $status_acknowledged = -1;
                        $acknowledged_name = $approved_name;
                        $verif_date_acknowledgedby = $verif_date_approvedby;
                        ?>
                        <div class="btn btn-danger" id="OpenModalInfo" data-content="<?php $content_approved = 'Rejected by ' . $approved_name . ' at ' . $verif_date_approvedby;
                        echo $content_approved;
                        $content_acknowledged = $content_approved; ?>">
                          Rejected</div>
                      <?php } ?>
                    </td>
                    <!-- END APPROVED -->

                    <!-- ACKNOWLEDGED -->
                    <td class="text-center">
                      <?php if ($status_acknowledged == 0) { ?>
                        <div class="btn btn-secondary" id="OpenModalInfo" data-content="<?php $content_acknowledged = 'Still waiting ' . $acknowledged_name;
                        echo $content_acknowledged; ?>">
                          Waiting</div>
                      <?php } elseif ($status_acknowledged == 1) { ?>
                        <div class="btn btn-success" id="OpenModalInfo" data-content="<?php $content_acknowledged = 'Accepted by ' . $acknowledged_name . ' at ' . $verif_date_acknowledgedby;
                        echo $content_acknowledged; ?>">
                          Accepted</div>
                      <?php } elseif ($status_acknowledged == -1) { ?>
                        <div class="btn btn-danger" id="OpenModalInfo" data-content="<?php $content_acknowledged = 'Rejected by ' . $acknowledged_name . ' at ' . $verif_date_acknowledgedby;
                        echo $content_acknowledged; ?>">
                          Rejected</div>
                      <?php } ?>
                    </td>
                    <!-- END ACKNOWLEDGED -->
                    <td class="text-center spacing-2">
                      <div class="btn btn-info m-1" id="OpenModalProgress" data-tanggal="<?= $pg->tanggal_gatepass ?>"
                        data-keperluan="<?= $pg->keperluan ?>" data-penjelasan="<?= $pg->penjelasan_keperluan ?>"
                        data-est-time-out="<?= $pg->est_time_out ?>" data-est-time-in="<?= $pg->est_time_in ?>"
                        data-recommended="<?= $content_recommended ?>" data-approved="<?= $content_approved ?>"
                        data-acknowledged="<?= $content_acknowledged ?>"><i class="fa-solid fa-circle-info"></i></div>
                      <div class="btn btn-danger" data-toggle="modal" data-target="#ModalSure<?= $pg->id_gatepass ?>"><i
                          class="fa-solid fa-trash"></i></div>
                    </td>
                  </tr>
                  <!-- Modal sure-->
                  <div class="modal fade" id="ModalSure<?= $pg->id_gatepass ?>" data-backdrop="static" data-keyboard="false"
                    tabindex="-1" aria-labelledby="ModalSureLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="ModalSureLabel"><?= $this->lang->line('Apakah anda yakin?') ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <?= $this->lang->line('Anda akan kehilangan progres dari gatepass anda') ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary"
                            data-dismiss="modal"><?= $this->lang->line('Kembali') ?></button>
                          <a href="<?= base_url('submit/do_delete/' . $pg->id_gatepass) ?>"
                            class="btn btn-danger"><?= $this->lang->line('Hapus') ?></a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }
                } ?>
            </tbody>
          </table>
        </div>
      </div>
      <hr class="mb-5">
      <div id="table-today" class="row">
        <div class="table-responsive">
          <h6 class="text-center text-uppercase mb-3"><?= $this->lang->line('Gatepass anda hari ini') ?></h6>
          <table class="table table-bordered" style="width:100%">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th><?= $this->lang->line('Tanggal') ?></th>
                <th><?= $this->lang->line('Alasan') ?></th>
                <th>Status</th>
                <th><?= $this->lang->line('Aksi') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($History as $hs) {
                ?>
                <tr class="text">
                  <th class="text-center align-middle">
                    <?= $i ?>
                  </th>
                  <td class="text-center align-middle">
                    <?= $hs->tanggal_gatepass ?>
                  </td>
                  <td class="align-middle">
                    <?= $hs->keperluan ?>
                  </td>
                  <?php
                  if ($hs->status == -1) { ?>
                    <td class="text-center">
                      <div class="btn btn-danger">Rejected</div>
                    </td>
                  <?php } else { ?>
                    <td class="text-center">
                      <div class="btn btn-success">Accepted</div>
                    </td>
                  <?php } ?>
                  <td class="text-center">
                    <div class="btn btn-secondary m-1"
                      onclick="window.open('<?= base_url('pdf/detail/' . $hs->qrcode) ?>','_self');">
                      <i class="fa-solid fa-print"></i>
                    </div>
                  </td>
                </tr>
                <?php $i++;
              } ?>
            </tbody>
          </table>
        </div>
      </div>








      <!-- Modal Signature -->
      <div class="modal fade" id="ModalSignature" tabindex="-1" aria-labelledby="ModalSignatureLabel"
        data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title w-100 text-center" id="exampleModalLabel"><?= $this->lang->line('Set Signature') ?>
              </h5>
              <button id="x-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="sigField">
                <div class="row">
                  <div class="col-md-12">
                    <canvas id="sig-canvas" style="max-width: 100%;" width="420" height="160">

                    </canvas>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-success" id="sig-submitBtn"><?= $this->lang->line('Selesai') ?></button>
                    <button class="btn btn-secondary" id="sig-clearBtn"><?= $this->lang->line('Bersihkan') ?></button>
                  </div>
                </div>
                <br />
                <form action="<?= base_url('dashboard/upSignature') ?>" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <textarea id="sig-dataUrl" class="form-control" name="signature" rows="5" hidden
                        required></textarea>
                      <textarea class="form-control" name="pst_pnr" rows="5"
                        hidden><?= $this->logindata['user']['pst_pnr'] ?></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <h5>Signature anda :</h5>
                      <img id="sig-image" src="<?= $this->logindata['user']['signature'] ?>"
                        alt="Anda belum membuat signature, tolong buat signature terlebih dahulu"
                        style="max-width: 100%;" />
                    </div>
                  </div>
                  <p id="sig-alert" class="text-danger" style="display:none;">
                    <?= $this->lang->line('ekan Tombol Selesai terlebih dahulu') ?>
                  </p>

              </div>
            </div>
            <div class="modal-footer">
              <button id="sig-uploadBtn" type="submit" class="btn btn-primary px-5" hidden>Upload Signature</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>






  <!-- punya header -->
  </div>
  </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function () {
    var signSet = <?= $signSet ?>;
    if (signSet == 0) {
      document.getElementById("x-btn").style.display = 'none';
      document.getElementById("btn-sig").click();
    }


    var bulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
    var gatepassAcceptData = [];
    var gatepassRejectData = [];
    var gatepassRequestData = [];
    var gatepassAcceptDataLast = [];
    var gatepassRejectDataLast = [];
    var gatepassRequestDataLast = [];
    <?php foreach ($gatepassAcceptData as $index => $jumlah) { ?>
      gatepassAcceptData.push(<?php echo $jumlah; ?>);
    <?php } ?>
    <?php foreach ($gatepassRejectData as $index => $jumlah) { ?>
      gatepassRejectData.push(<?php echo $jumlah; ?>);
    <?php } ?>
    <?php foreach ($gatepassRequestData as $index => $jumlah) { ?>
      gatepassRequestData.push(<?php echo $jumlah; ?>);
    <?php } ?>
    <?php foreach ($gatepassAcceptDataLast as $index => $jumlah) { ?>
      gatepassAcceptDataLast.push(<?php echo $jumlah; ?>);
    <?php } ?>
    <?php foreach ($gatepassRejectDataLast as $index => $jumlah) { ?>
      gatepassRejectDataLast.push(<?php echo $jumlah; ?>);
    <?php } ?>
    <?php foreach ($gatepassRequestDataLast as $index => $jumlah) { ?>
      gatepassRequestDataLast.push(<?php echo $jumlah; ?>);
    <?php } ?>

    var ctx = document.getElementById('gatepassChart').getContext('2d');
    var ctxLast = document.getElementById('gatepassChartLast').getContext('2d');
    var combinedData = {
      labels: bulan,
      datasets: [
        {
          label: 'Gatepass Accept',
          backgroundColor: 'rgba(0, 128, 0, 0.2)',
          borderColor: 'rgba(0, 128, 0, 1)',
          borderWidth: 1,
          data: gatepassAcceptData
        },
        {
          label: 'Gatepass Reject',
          backgroundColor: 'rgba(255, 0, 0, 0.2)',
          borderColor: 'rgba(255, 0, 0, 1)',
          borderWidth: 1,
          data: gatepassRejectData
        },
        {
          label: 'Gatepass Request',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          data: gatepassRequestData
        }
      ]
    };
    var myChart = new Chart(ctx, {
      type: 'line',
      data: combinedData,
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    combinedDataLast = {
      labels: bulan,
      datasets: [
        {
          label: 'Gatepass Accept',
          backgroundColor: 'rgba(0, 128, 0, 0.2)',
          borderColor: 'rgba(0, 128, 0, 1)',
          borderWidth: 1,
          data: gatepassAcceptDataLast
        },
        {
          label: 'Gatepass Reject',
          backgroundColor: 'rgba(255, 0, 0, 0.2)',
          borderColor: 'rgba(255, 0, 0, 1)',
          borderWidth: 1,
          data: gatepassRejectDataLast
        },
        {
          label: 'Gatepass Request',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          data: gatepassRequestDataLast
        }


      ]
    };
    var myChartLast = new Chart(ctxLast, {
      type: 'line',
      data: combinedDataLast,
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });



  });









  new DataTable('#example');
  (function () {
    window.requestAnimFrame = (function (callback) {
      return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimaitonFrame ||
        function (callback) {
          window.setTimeout(callback, 1000 / 60);
        };
    })();

    var canvas = document.getElementById("sig-canvas");
    var ctx = canvas.getContext("2d");
    ctx.strokeStyle = "#222222";
    ctx.lineWidth = 4;

    var drawing = false;
    var mousePos = {
      x: 0,
      y: 0
    };
    var lastPos = mousePos;

    canvas.addEventListener("mousedown", function (e) {
      drawing = true;
      lastPos = getMousePos(canvas, e);
    }, false);

    canvas.addEventListener("mouseup", function (e) {
      drawing = false;
    }, false);

    canvas.addEventListener("mousemove", function (e) {
      mousePos = getMousePos(canvas, e);
    }, false);

    // Add touch event support for mobile
    canvas.addEventListener("touchstart", function (e) {

    }, false);

    canvas.addEventListener("touchmove", function (e) {
      var touch = e.touches[0];
      var me = new MouseEvent("mousemove", {
        clientX: touch.clientX,
        clientY: touch.clientY
      });
      canvas.dispatchEvent(me);
    }, false);

    canvas.addEventListener("touchstart", function (e) {
      mousePos = getTouchPos(canvas, e);
      var touch = e.touches[0];
      var me = new MouseEvent("mousedown", {
        clientX: touch.clientX,
        clientY: touch.clientY
      });
      canvas.dispatchEvent(me);
    }, false);

    canvas.addEventListener("touchend", function (e) {
      var me = new MouseEvent("mouseup", {});
      canvas.dispatchEvent(me);
    }, false);

    function getMousePos(canvasDom, mouseEvent) {
      var rect = canvasDom.getBoundingClientRect();
      return {
        x: mouseEvent.clientX - rect.left,
        y: mouseEvent.clientY - rect.top
      }
    }

    function getTouchPos(canvasDom, touchEvent) {
      var rect = canvasDom.getBoundingClientRect();
      return {
        x: touchEvent.touches[0].clientX - rect.left,
        y: touchEvent.touches[0].clientY - rect.top
      }
    }

    function renderCanvas() {
      if (drawing) {
        ctx.moveTo(lastPos.x, lastPos.y);
        ctx.lineTo(mousePos.x, mousePos.y);
        ctx.stroke();
        lastPos = mousePos;
      }
    }

    // Prevent scrolling when touching the canvas
    document.body.addEventListener("touchstart", function (e) {
      if (e.target == canvas) {
        e.preventDefault();
      }
    }, false);
    document.body.addEventListener("touchend", function (e) {
      if (e.target == canvas) {
        e.preventDefault();
      }
    }, false);
    document.body.addEventListener("touchmove", function (e) {
      if (e.target == canvas) {
        e.preventDefault();
      }
    }, false);

    (function drawLoop() {
      requestAnimFrame(drawLoop);
      renderCanvas();
    })();
    var sigText = document.getElementById("sig-dataUrl");
    function clearCanvas() {
      canvas.width = canvas.width;
    }

    // Set up the UI
    var sigImage = document.getElementById("sig-image");
    var clearBtn = document.getElementById("sig-clearBtn");
    var submitBtn = document.getElementById("sig-submitBtn");
    var uploadBtn = document.getElementById("sig-uploadBtn");
    var sigAlert = document.getElementById("sig-alert"); clearBtn.addEventListener("click", function (e) {
      clearCanvas();
      sigText.innerHTML = "";
      sigImage.setAttribute("src", "");
    }, false);

    submitBtn.addEventListener("click", function (e) {
      var dataUrl = canvas.toDataURL('image/png');
      if (dataUrl != 'data:image/png;base64,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') {
        sigText.innerHTML = dataUrl;
        sigImage.setAttribute("src", dataUrl);
        sigAlert.style.display = "none";
        uploadBtn.click();
      } else {
        alert('<?= $this->lang->line('Tidak Boleh kosong') ?>');
      }
    }, false);
  })();

  var modalButtons = document.querySelectorAll("#OpenModalInfo");
  var modalButtonsProgress = document.querySelectorAll("#OpenModalProgress");
  Array.from(modalButtons).forEach(function (button) {
    button.addEventListener("click", function () {
      // Ambil konten dari atribut data-content
      var content = this.getAttribute("data-content");
      // Tampilkan modal
      $('#ModalInfo').modal('show');
      // Masukkan konten ke dalam modal
      document.querySelector('#isi-modal').innerText = content;
    });
  });
  Array.from(modalButtonsProgress).forEach(function (button) {
    button.addEventListener("click", function () {
      document.querySelector('#isi-tanggal').value = this.getAttribute("data-tanggal");
      document.querySelector('#isi-keperluan').innerHTML = this.getAttribute("data-keperluan");
      document.querySelector('#isi-penjelasan').value = this.getAttribute("data-penjelasan");
      document.querySelector('#isi_est_time_out').value = this.getAttribute("data-est-time-out");
      document.querySelector('#isi_est_time_in').value = this.getAttribute("data-est-time-in");
      document.querySelector('#isi_recommended').value = this.getAttribute("data-recommended");
      document.querySelector('#isi_approved').value = this.getAttribute("data-approved");
      document.querySelector('#isi_acknowledged').value = this.getAttribute("data-acknowledged");
      $('#ModalProgress').modal('show');
    });
  });
</script>
<!-- Modal Info -->
<div class="modal fade" id="ModalInfo" tabindex="-1" role="dialog" aria-labelledby="ModalInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div id="isi-modal" class="modal-body text-center">

      </div>
    </div>
  </div>
</div>



<!-- modal progress -->
<div class="modal fade" id="ModalProgress" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content px-4">
      <div class="modal-header">
        <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Detail Gatepaeess</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group mb-4">
            <label for="tanggal" class="col-form-label font-weight-bold"><?= $this->lang->line('Tanggal') ?></label>
            <input type="date" class="form-control w-50" id="isi-tanggal" disabled>
          </div>
          <div class="form-group mb-4 ">
            <label class="form-label font-weight-bold"><?= $this->lang->line('Keperluan') ?></label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="" value="" disabled checked>
              <label class="form-check-label text-uppercase" id="isi-keperluan" for=""></label>
            </div>
          </div>
          <div class="form-group mb-4">
            <label for="penjelasan" class="form-label font-weight-bold"><?= $this->lang->line('Penjelasan') ?></label>
            <textarea class="form-control" id="isi-penjelasan" style="height: 100px" disabled></textarea>
          </div>
          <div class="form-group mb-4">
            <label class="form-label font-weight-bold"><?= $this->lang->line('Perkiraan waktu') ?></label><br>
            <div class="input-group mb-1">
              <input type="text" class="form-control text-light"
                placeholder="<?= $this->lang->line('Perkiraan jam keluar') ?>" disabled>
              <input class="form-control" type="time" id="isi_est_time_out" value="" disabled>
            </div>
            <div class="input-group mb-4">
              <input type="text" class="form-control text-light"
                placeholder="<?= $this->lang->line('Perkiraan jam masuk') ?>" disabled>
              <input class="form-control" type="time" id="isi_est_time_in" value="" disabled>
            </div>
          </div>
          <div class="form-group mb-4">
            <label class="form-label font-weight-bold"><?= $this->lang->line('Pengesahan') ?></label><br>
            <div class="input-group mb-1">
              <input type="text" class="form-control text-light" placeholder="Recommendedby" disabled>
              <input class="form-control" type="text" id="isi_recommended" value="" disabled>
            </div>
            <div class="input-group mb-1">
              <input type="text" class="form-control text-light" placeholder="Approvedby" disabled>
              <input class="form-control" type="text" id="isi_approved" value="" disabled>
            </div>
            <div class="input-group mb-4">
              <input type="text" class="form-control text-light" placeholder="Acknowledgedby" disabled>
              <input class="form-control" type="text" id="isi_acknowledged" value="" disabled>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

</html>