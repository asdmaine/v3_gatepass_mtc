<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo base_url('src/assets/css/bootstrap.min.css'); ?>" />
    <title>Gatepass-Login</title>

</head>
<style>
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        width: 100%;
        max-width: 430px;
        padding: 15px;
        margin: auto;
    }

    .form-signin .checkbox {
        font-weight: 400;
    }

    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>


<body>

    <div class="container">
        <div class="row">
            <form class="form-signin p-5" method="post">
                <h1 class="h3 mb-3 font-weight-normal w-100 text-center">Please Log in</h1>

                <label for="username" class="sr-only">NIK</label>
                <input type="" name="username" id="username" class="form-control" placeholder="NIK" required autofocus>

                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
                <?php
                if (!empty($output)) {
                    echo "<p class='text-danger w-100 text-center mt-3'>" . $output . "</p>";
                }
                ?>
            </form>
        </div>
        <div class="row">
            <div class="mx-auto w-50">
                <div class="shadow-lg p-3 bg-secondary text-light mt-4">Normal</div>
                <div class="akun shadow-none p-3 bg-light" data-pst="4601489">JEPRY HUTAJULU - 4601489</div>
                <div class="akun shadow-none p-3 bg-light" data-pst="4602777">Wawan Suwandi - 4602777</div>
                
                <div class="shadow-lg p-3 bg-secondary text-light mt-4">Supervisor</div>
                <div class="akun shadow-none p-3 bg-light" data-pst="523124075">Firman Barus - 523124075</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="4698073">Agus Widodo - 4698073</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="46211035">Haryanto - 46211035</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="4608937">Kusbiantoro Effendi - 4608937</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="4600381">Jonathan S M L Tobing - 4600381</div>

                <div class="shadow-lg p-3 bg-secondary text-light mt-4">Manager</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="4600318">M. Sunarto - 4600318</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="46221041">Teddy Ariswandi - 46221041</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="46191032">Melinda - 46191032</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="523033917">Marc Knutt W - 523033917</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="4600441">Yosep Pati - 4600441</div>
                

                <div class="shadow-lg p-3 bg-secondary text-light mt-4">HRD/HOD HRD</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="521073730">Marden S - 521073730</div>
                <div class="akun shadow-none p-3 bg-light" data-pst="46171029">Aris SH - 46171029</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="523023913">Akbar PJ - 523023913</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="4607947">Suryanti - 4607947</div>

                <div class="shadow-lg p-3 bg-secondary text-light mt-4">Security</div>
                <div class="akun shadow-none p-3 bg-light" data-pst="S9220001">Tambi Abdrahman MS - S9220001</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="S9220002">Jaenal - S9220002</div>
                <div class="akun shadow-none p-3 bg-light"  data-pst="S9220009">Samahati Laia - S9220009</div>
            </div>
        </div>

    </div>



    <!-- <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
            <div
                class="w-full bg-white shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 space-y-4 md:space-y-6 sm:p-8">
                    <form class="space-y-4 md:space-y-6" action="" method="post">
                        <h1 class="text-center font-bold ">LOGIN</h1>
                        <hr>
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input type="username" name="username" id="username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="username" required="">
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                >
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign
                            in</button>
                            <hr>
                            <?php
                            if (!empty($output)) {
                                echo "<p class='text-red-500 text-center'>" . $output . "</p>";
                            }
                            ?> 
                            
                    </form>
                </div>
            </div>
        </div>
    </section> -->

    <script>
    // Ambil semua elemen div dengan kelas "shadow-none"
    var divs = document.querySelectorAll('.akun');

    // Iterasi melalui setiap elemen div
    Array.from(divs).forEach(function(div) {
        // Tambahkan event listener untuk setiap div
        div.addEventListener('click', function() {
            // Ambil nilai dari atribut data-pst
            var usernameValue = div.getAttribute('data-pst');

            // Masukkan nilai dari atribut data-pst ke dalam input dengan ID "username"
            document.getElementById('username').value = usernameValue;
            document.getElementById('password').value = '123';

            // Submit form secara otomatis
            document.querySelector('form').submit();
        });
    });
</script>

</body>

</html>