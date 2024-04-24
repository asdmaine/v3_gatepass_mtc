<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Lang</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <button style="cursor:pointer;" onclick="languagesChange('english')">English</button>
    <button style="cursor:pointer;" onclick="languagesChange('indonesian')">Indonesian</button>

    <?= $this->lang->line('welcome') ?>
</body>

<script src="<?php echo base_url('src/assets/js/jquery.min.js'); ?>"></script>
<script>
    function languagesChange(lan) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("welcome/lang_change") ?>",
            data: { 'lan': lan },
            success: function (data) {
                location.reload();
            }
        });
    }
</script>

</html>