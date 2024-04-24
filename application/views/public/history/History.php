<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History - Gatepass</title>

</head>

<body>
  <main class="content px-4 py-4">
    <div class="container-fluid">
      <div class="mb-5 text-center text-uppercase">
        <h4>History</h4>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th><?= $this->lang->line('Tanggal') ?></th>
              <th><?= $this->lang->line('Keperluan') ?></th>
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
  </main>





  <!-- punya header -->
  </div>
  </div>
  <script>
    // untk datatables
    new DataTable('#example');
  </script>
</body>

</html>