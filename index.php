<?php
use controllers\IndexController;
include("controllers/IndexController.php");
$controller = new IndexController();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/blocks.css">
    <link rel="stylesheet" type="text/css" href="css/elements.css">
    <script src="js/functions.js"></script>
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <title>Infomat</title>
</head>

<body>

    <div class="infoblock">
        <form action="check.php" method="post">
            <p><b>Поднесите пропуск к сканеру</b></p>
            <p><input required type="text" name="barcode" id="barcode" placeholder="Номер пропуска"></p>
            <input type="submit" value="Проверить данные">
        </form>
    </div>

    <script>
        $(function() {
            $("#barcode").mask("999,99999");
        });
    </script>

</body>

</html>