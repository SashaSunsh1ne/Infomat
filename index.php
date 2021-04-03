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

    <?php
    include getcwd() . "/serialPort/php_serial.class.php";
    include getcwd() . "/config/Config.php";
    $config = new Config();
    $serial = new phpSerial();
    $serial->deviceSet($config->getParam(PORT));
    $serial->confBaudRate($config->getParam(PORT_BAUDRATE));
    $serial->confParity($config->getParam(PORT_PARITY));
    $serial->confCharacterLength($config->getParam(PORT_CHARACTERLENGTH));
    $serial->confStopBits($config->getParam(PORT_STOPBITS));
    $serial->confFlowControl($config->getParam(PORT_FLOWCONTROL));
    $serial->deviceOpen($config->getParam(OPENMODE));

    sleep(2);
    $serial->sendMessage("Hello");
    $read = $serial->readPort();
    echo ".".$read.".";

    sleep(2);

    $serial->deviceClose();
    ?>

</body>

</html>