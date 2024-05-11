<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scan - Gatepass</title>
  <!-- <link href="webcodecam/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- <link href="webcodecam/css/style.css" rel="stylesheet"> -->
</head>

<body>
  <?php
  if (isset($_GET['alert'])) {
    if ($_GET['alert'] == 'strltin1') {
      echo '<script>console.log("Berhasil!")</script>';
      echo '<script>alert("Berhasil!")</script>';
    }
    if ($_GET['alert'] == 'strltin0') {
      echo '<script>console.log("Gagal!")</script>';
      echo '<script>alert("Gagal!")</script>';
    }
    if ($_GET['alert'] == 'gp0') {
      echo '<script>console.log("Gatepass tidak valid!")</script>';
      echo '<script>alert("Gatepass tidak valid!")</script>';
    }
    if ($_GET['alert'] == 'gp-1') {
      echo '<script>console.log("Gatepass anda ditolak!")</script>';
      echo '<script>alert("Gatepass anda ditolak!")</script>';
    }
  

    echo '<script>
    setTimeout(function() {
        var newUrl = window.location.href.split("?")[0];
        window.history.replaceState({}, document.title, newUrl);
    }, 5000); // Menghapus parameter setelah 2 detik
</script>';
  }

  ?>
  <main class="content px-4 py-4">
    <div class="container-fluid">
      <div class="mb-5 text-center text-uppercase">
        <h4>Scan</h4>
      </div>
      <div class="row mb-5">
        <div class="w-100 d-flex">
          <div class="mx-auto">
            <div class="row mb-5">
              <form action="<?= base_url('scan/output') ?>" method='post' class="mx-auto">
                <div class="d-flex">
                  <input class="form-control" type="text" name="qr" id="out-QR" required>
                  <button class="ml-1 btn btn-primary" id="search-qr" type="submit">search</button>
                </div>
                <p id="scanned-QR"></p>
              </form>


            </div>

            <div class="row" id="QR-Code">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <!-- <div class="navbar-form navbar-left">
                    <h4>WebCodeCamJS.js Demonstration</h4>
                  </div> -->
                  <div class="navbar-form navbar-right">
                    <select class="form-control" id="camera-select"></select>
                    <div class="form-group mt-2">
                      <input style="display:none;" id="image-url" type="text" class="form-control"
                        placeholder="Image url">
                      <button style="display:none;" title="Decode Image" class="btn btn-default btn-sm" id="decode-img"
                        type="button" data-toggle="tooltip"><span
                          class="glyphicon glyphicon-upload">upload</span></button>
                      <button style="display:none;" title="Image shoot" class="btn btn-info btn-sm disabled"
                        id="grab-img" type="button" data-toggle="tooltip"><span
                          class="glyphicon glyphicon-picture">upload</span></button>
                      <button title="Play" class="btn btn-success btn-sm px-4" id="play" type="button"
                        data-toggle="tooltip"><span class="glyphicon glyphicon-play">START CAM</span></button>
                      <button style="display:none;" title="Pause" class="btn btn-warning btn-sm" id="pause"
                        type="button" data-toggle="tooltip"><span
                          class="glyphicon glyphicon-pause">pause</span></button>
                      <button title="Stop streams" class="btn btn-danger btn-sm px-4" id="stop" type="button"
                        data-toggle="tooltip"><span class="glyphicon glyphicon-stop">STOP CAM</span></button>
                    </div>
                  </div>
                </div>
                <div class="panel-body text-center">
                  <div class="col-xl-12">
                    <div class="well" style="max-width:100%;position: relative;display: inline-block;">
                      <canvas width="320" height="240" id="webcodecam-canvas"></canvas>
                      <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                      <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                      <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                      <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                    </div>
                  </div>
                  <div class="col-xl-12">
                    <div class="thumbnail" id="result">
                      <div class="well" style="display:none;overflow: hidden;">
                        <img width="320" height="240" id="scanned-img" src="">
                      </div>
                      <div class="caption">
                        <!-- <h3>Scanned result</h3> -->

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </main>





  <!-- punya header -->
  </div>
  </div>


  <script type="text/javascript" src="js/filereader.js"></script>
  <script type="text/javascript" src="js/qrcodelib.js"></script>
  <script type="text/javascript" src="js/webcodecamjs.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</body>


</html>