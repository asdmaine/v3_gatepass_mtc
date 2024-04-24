<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Interval Check</title>
    <script>
        function checkTimeInterval() {
            var timeIn = document.getElementById('in').value;
            var timeOut = document.getElementById('out').value;

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
                alert('Jarak antara waktu masuk dan keluar tidak boleh lebih dari 3 jam.');
                // Atur kembali nilai input
                document.getElementById('in').value = '';
                document.getElementById('out').value = '';
            }
        }
    </script>
</head>
<body>
    <h2>Waktu Masuk</h2>
    <input onchange="checkTimeInterval()" type="time" id="in" name="in">
    <h2>Waktu Keluar</h2>
    <input onchange="checkTimeInterval()" type="time" id="out" name="out">
    <br><br>
   
</body>
</html>
