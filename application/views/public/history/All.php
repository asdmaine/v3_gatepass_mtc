<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All History - Gatepass</title>

</head>

<body>
  <main class="content px-4 py-4">
    <div class="container-fluid">
      <div class="mb-5 text-center text-uppercase">
        <h4><?= $this->lang->line('Semua Histori Gatepass pada tahun') ?> <?php if (isset($year)) {
          echo $year;
        } else {
          echo date('Y');
        } ?></h4>
      </div>
      <div class="col-xl-2 col-md-4 col-sm-1">
        <select class="form-control" name="" id="" onchange="YearSelector(this)">
          <option disabled selected>-</option>
          <option><?= date('Y') ?></option>
          <option><?= date('Y') - 1 ?></option>
          <option><?= date('Y') - 2 ?></option>
          <option><?= date('Y') - 3 ?></option>
          <option><?= date('Y') - 4 ?></option>
          <option><?= date('Y') - 5 ?></option>
        </select>
      </div>

      <div class="col-xl-12">
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
              foreach ($Gatepass as $hs) {
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
                      onclick="window.open('<?= base_url('all/detail/' . $hs->qrcode) ?>','_self');">
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
    </div>
  </main>





  <!-- punya header -->
  </div>
  </div>

  <script>
    // untk datatables
    new DataTable('#example');

    function YearSelector(select) {
      var selectedYear = select.options[select.selectedIndex].value;
      window.open('<?= base_url('all/from/') ?>' + selectedYear, '_self')
    }
  </script>
</body>

</html>