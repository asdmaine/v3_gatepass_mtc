<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Remarks</title>
  <link rel="stylesheet" href="<?php echo base_url('src/assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('src/assets/css/nav.css'); ?>" />
</head>
<style>
  #sig-canvas {
    border: 2px solid #CCCCCC;
    cursor: crosshair;
  }
</style>

<body>

  <div class="modal fade" id="ModalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="ModalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center w-100" id="ModalEditLabel">Remarks</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?= base_url("mail/approve_from_mail/".base64_encode($what)."/".base64_encode($as)."/".base64_encode($qrcode)."/".base64_encode($id_verifikasi)."/".base64_encode($id_gatepass)."/".base64_encode($id_remarks)) ?>" method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="what" value="<?= $what ?>" hidden>
              <input type="text" class="form-control" name="as" value="<?= $as ?>" hidden>
              <input type="text" class="form-control" name="qrcode" value="<?= $qrcode ?>" hidden>
              <input type="text" class="form-control" name="id_verifikasi" value="<?= $id_verifikasi ?>" hidden>
              <input type="text" class="form-control" name="id_gatepass" value="<?= $id_gatepass ?>" hidden>
              <input type="text" class="form-control" name="id_remarks" value="<?= $id_remarks ?>" hidden>
              <label for="remarks">Remarks</label>
              <input type="text" class="form-control" name="remarks" value="-">
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Konfirmasi</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo base_url('src/assets/js/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('src/assets/js/popper.min.js'); ?>"></script>
  <script src="<?php echo base_url('src/assets/js/bootstrap.min.js'); ?>"></script>
  <script>
    $(document).ready(function () {
      $('#ModalEdit').modal('show');
    });
  </script>
</body>

</html>