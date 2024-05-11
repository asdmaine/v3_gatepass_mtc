<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit - Gatepass</title>

</head>


<body>
  <main class="content px-4 py-4">
    <div class="container-fluid">
      <div class="mb-5 text-center text-uppercase">
        <h4>Submit</h4>
      </div>
      <div>
        <a class="btn btn-primary text-white mb-3" data-toggle="modal" data-target=".ModalSubmit">
          <i class="fa-solid fa-plus mr-2"></i>
          Submit Gatepass
        </a>


        <!-- konversi data progress -->
        <div class="row">
          <!-- konversi data progress -->
          <div class="table-responsive">
            <h6 class="text-center text-uppercase mb-3">Gatepass Progress</h6>
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
                  <tr class="text">
                    <th class="text-center align-middle text-uppercase" colspan="7">no data to be shown</th>
                  </tr>
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
                        data-est-time-out="<?= $pg->est_time_out ?>" data-est-time-in="<?= $pg->est_time_in ?>" data-recommended="<?= $content_recommended ?>" data-approved="<?= $content_approved ?>" data-acknowledged="<?= $content_acknowledged ?>"><i
                        class="fa-solid fa-circle-info"></i></div>
                    <div class="btn btn-danger" data-toggle="modal" data-target="#ModalSure<?= $pg->id_gatepass ?>"><i
                        class="fa-solid fa-trash"></i></div>
                  </td>
                  </tr>
                  <!-- Modal sure-->
                  <div class="modal fade" id="ModalSure<?= $pg->id_gatepass ?>" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    aria-labelledby="ModalSureLabel" aria-hidden="true">
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
                <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>





  <!-- punya header -->
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
              <input type="text" class="form-control text-light"
                placeholder="Recommendedby" disabled>
              <input class="form-control" type="text" id="isi_recommended" value="" disabled>
            </div>
            <div class="input-group mb-1">
              <input type="text" class="form-control text-light"
                placeholder="Approvedby" disabled>
              <input class="form-control" type="text" id="isi_approved" value="" disabled>
            </div>
            <div class="input-group mb-4">
              <input type="text" class="form-control text-light"
                placeholder="Acknowledgedby" disabled>
              <input class="form-control" type="text" id="isi_acknowledged" value="" disabled>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- modal submit -->
  <div class="modal fade ModalSubmit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content px-4">
        <div class="modal-header">
          <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Form Gatepass</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="myForm" action="<?= base_url("submit/do_submit") ?>" method="post">
            <div class="form-group mb-4">
              <label for="tanggal" class="col-form-label font-weight-bold"><?= $this->lang->line('Tanggal') ?></label>
              <input type="date" class="form-control w-50" name="tanggal" id="tanggal" required>
            </div>
            <div class="form-group mb-4 ">
              <label class="form-label font-weight-bold"><?= $this->lang->line('Keperluan') ?></label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="keperluan" id="urusan_perusahaan"
                  value="urusan_perusahaan" required>
                <label class="form-check-label"
                  for="urusan_perusahaan"><?= $this->lang->line('Urusan Perusahaan') ?>&nbsp;&nbsp;&nbsp;&nbsp;</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="keperluan" id="urusan_keluarga"
                  value="urusan_keluarga" required>
                <label class="form-check-label"
                  for="urusan_keluarga"><?= $this->lang->line('Urusan Keluarga') ?>&nbsp;&nbsp;&nbsp;&nbsp;</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="keperluan" id="sakit" value="sakit" required>
                <label class="form-check-label"
                  for="sakit"><?= $this->lang->line('Sakit/Klinik/Rs') ?>&nbsp;&nbsp;&nbsp;&nbsp;</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="keperluan" id="lain-lain" value="lain-lain" required>
                <label class="form-check-label" for="lain-lain"><?= $this->lang->line('lain-lain') ?></label>
              </div>
            </div>
            <div class="form-group mb-4">
              <label for="penjelasan" class="form-label font-weight-bold"><?= $this->lang->line('Penjelasan') ?></label>
              <textarea class="form-control" placeholder="Tulis lebih detail keperluan anda." name="penjelasan"
                id="penjelasan" style="height: 100px" required></textarea>
            </div>
            <div class="form-group">
              <label class="form-label font-weight-bold"><?= $this->lang->line('Perkiraan waktu') ?></label><br>
              <div class="input-group mb-1">
                <input type="text" class="form-control text-light"
                  placeholder="<?= $this->lang->line('Perkiraan jam keluar') ?>" disabled>
                <input class="form-control" onchange="checkTimeInterval()" type="time" name="est_time_out"
                  id="form_est_time_out" required>
              </div>
              <div class="input-group mb-4">
                <input type="text" class="form-control text-light"
                  placeholder="<?= $this->lang->line('Perkiraan jam masuk') ?>" disabled>
                <input class="form-control" onchange="checkTimeInterval()" type="time" name="est_time_in"
                  id="form_est_time_in" required>
              </div>
              <div class="input-group mb-4">
                <p class="text-center w-100 text-danger" id="alert-time" style="display:none;">
                  <?= $this->lang->line('Tidak boleh keluar lebih dari 3 jam') ?></p>
              </div>
            </div>
            <div class="form-group mb-4">
              <label class="form-label font-weight-bold"><?= $this->lang->line('Pengesahan') ?></label><br>
              <div class="input-group mb-1">
                <input type="text" class="form-control text-light" placeholder="Requested By" disabled>
                <select name="" id="" class="form-control" disabled>
                  <option value="" selected>
                    <?= $this->logindata['user']['pst_name'] ?> -
                    <?= $this->logindata['user']['pst_pnr'] ?>
                  </option>
                </select>
                <input type="text" name="requested" value="<?php echo $this->logindata['user']['pst_pnr'] ?>" hidden>
                <input type="text" name="requested_name" value="<?php echo $this->logindata['user']['pst_name'] ?>"
                  hidden>
              </div>
              <div class="input-group mb-1">
                <input type="text" class="form-control text-light" placeholder="Recommended By" disabled>
                <select name="recommended" id="" class="form-control" required>
                  <?php if (empty($Recommended)) { ?>
                    <option selected value="0" class="text-uppercase">
                      -
                    </option>
                  <?php } else { foreach ($Recommended as $var) { ?>
                    <option selected value="<?= $var->verifikasi1 ?>" class="text-uppercase">
                      <?= $var->pst_name ?> -
                      <?= $var->verifikasi1 ?>
                    </option>
                  <?php }} ?>
                </select>
              </div>
              <div class="input-group mb-1">
                <input type="text" class="form-control text-light" placeholder="Approved By" disabled>
                <select name="approved" id="" class="form-control" required>
                  <?php if (empty($Approved)) { ?>
                    <option selected value="0" class="text-uppercase">
                      -
                    </option>
                  <?php } else { foreach ($Approved as $var) { ?>
                    <option selected value="<?= $var->approval1 ?>" class="text-uppercase">
                      <?= $var->pst_name ?> -
                      <?= $var->approval1 ?>
                    </option>
                  <?php }} ?>
                </select>
              </div>
              <div class="input-group mb-4">
                <input type="text" class="form-control text-light" placeholder="Acknowledged By" disabled>
                <select name="acknowledged" id="" class="form-control" required>
                  <option value="" selected disabled>-</option>
                  <option value="46171029">Aris Setyo Hartanto - 46171029</option>
                  <option value="521073730">Marden Saragih - 521073730</option>
                </select>
              </div>
              <!-- <div class="mb-4">
                <label class="form-label font-weight-bold">Waktu Sebenarnya</label><br>
                <div class="input-group mb-1">
                  <input type="text" class="form-control text-light" placeholder="Jam Keluar" disabled>
                  <input class="form-control" type="time" name="real_time_out" id="real_time_out" disabled>
                </div>
                <div class="input-group mb-4">
                  <input type="text" class="form-control text-light" placeholder="Jam Masuk" disabled>
                  <input class="form-control" type="time" name="real_time_in" id="real_time_in" disabled>
                </div>
              </div> -->
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger text-white" onclick="resetForm()">Reset</button>
          <button type="submit" class="btn btn-primary px-5">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- modal info -->
  <div class="modal fade" id="ModalInfo" tabindex="-1" role="dialog" aria-labelledby="ModalInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div id="isi-modal" class="modal-body text-center">

      </div>
    </div>
  </div>
</div>

  <script>
    function resetForm() {
      document.getElementById("myForm").reset();
    }
    function checkTimeInterval() {
      var timeIn = document.getElementById('form_est_time_in').value;
      var timeOut = document.getElementById('form_est_time_out').value;

      // Pisahkan jam dan menit dari waktu masuk dan keluar
      var inTimeParts = timeIn.split(':');
      var outTimeParts = timeOut.split(':');

      // Hitung jumlah menit dari jam masuk dan keluar
      var inMinutes = parseInt(inTimeParts[0]) * 60 + parseInt(inTimeParts[1]);
      var outMinutes = parseInt(outTimeParts[0]) * 60 + parseInt(outTimeParts[1]);

      // Hitung selisih waktu dalam menit
      var timeDifference = Math.abs(outMinutes - inMinutes);

      // Konversi selisih waktu menjadi jam
      var timeDifferenceHours = timeDifference / 60;

      // Periksa apakah selisih waktu lebih dari 3 jam
      if (timeDifferenceHours > 3) {
        // alert('Jarak antara waktu masuk dan keluar tidak boleh lebih dari 3 jam.');
        document.getElementById('alert-time').style.display = 'block';
        // Atur kembali nilai input
        document.getElementById('form_est_time_in').value = '';
        document.getElementById('form_est_time_out').value = '';
      } else {
        document.getElementById('alert-time').style.display = 'none';
      }
    }
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
</body>

</html>