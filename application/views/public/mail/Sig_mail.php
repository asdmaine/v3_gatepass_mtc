<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <button style="display:none;" type="button" class="btn btn-info" id="btn-sig" data-toggle="modal"
        data-target="#ModalSignature">
        E-Signature
    </button>
    <div class="modal fade" id="ModalSignature" tabindex="-1" aria-labelledby="ModalSignatureLabel"
        data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Set Signature</h5>
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
                                <button class="btn btn-success" id="sig-submitBtn">Selesai</button>
                                <button class="btn btn-secondary" id="sig-clearBtn">Bersihkan</button>
                            </div>
                        </div>
                        <br />
                        <form action="<?= base_url('mail/upSignatureFromMail') ?>" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                  <input type="text" name="what" value="<?= $what ?>" hidden>
                                  <input type="text" name="as" value="<?= $as ?>" hidden>
                                  <input type="text" name="qrcode" value="<?= $qrcode ?>" hidden>
                                  <input type="text" name="id_verifikasi" value="<?= $id_verifikasi ?>" hidden>
                                  <input type="text" name="id_gatepass" value="<?= $id_gatepass ?>" hidden>
                                  <input type="text" name="id_remarks" value="<?= $id_remarks ?>" hidden>
                                
                                    <textarea id="sig-dataUrl" class="form-control" name="signature" rows="5" hidden
                                        required></textarea>
                                    <textarea class="form-control" name="pst_pnr" rows="5"
                                        hidden><?= $pst_pnr ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <img id="sig-image" src=""
                                        alt="Anda belum membuat signature, tolong buat signature terlebih dahulu"
                                        style="max-width: 100%;" />
                                </div>
                            </div>
                            <p id="sig-alert" class="text-danger" style="display:none;">Tekan Tombol Selesai terlebih
                                dahulu</p>

                    </div>
                </div>
                <div class="modal-footer">
                    <button id="sig-uploadBtn" type="submit" class="btn btn-primary px-5" hidden>Upload
                        Signature</button>
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
    var signSet = <?= $signSet ?>;
    if (signSet == 0) {
      document.getElementById("x-btn").style.display = 'none';
      document.getElementById("btn-sig").click();
    }
  });


  var modalButtons = document.querySelectorAll("#OpenModalInfo");
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
      if(dataUrl != 'data:image/png;base64,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'){
        sigText.innerHTML = dataUrl;
        sigImage.setAttribute("src", dataUrl);
        sigAlert.style.display = "none";
        uploadBtn.click();
      }else{
        alert('<?=  $this->lang->line('Tidak Boleh kosong') ?>');
      }
    }, false);
  })();
</script>
</body>

</html>