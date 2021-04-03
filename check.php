<?php
include getcwd() . "/config/Config.php";
$config = new Config();
$config->getParam(PORT);
if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $searchStudent = 'http://university.cchgeu.ru/infomat/hs/infomat/'. $config->getParam() .'/searchStudent/' . $barcode;
    echo $searchStudent;
    $ch = curl_init($searchStudent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $searchOutput = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $searchStudentData = json_decode($searchOutput);
    curl_close($ch);
    if ($searchStudentData) {
        $getInfoStudent = 'http://university.cchgeu.ru/infomat/hs/infomat/'. $config->getParam() .'/getInfoStudent/' . $barcode;
        $ch = curl_init($getInfoStudent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $getInfoOutput = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $getInfoStudentData = json_decode($getInfoOutput);
        curl_close($ch);
    }
}
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

    <div id="print-content" class="infoblock">
        <?php
        if (isset($_POST['barcode']) && $searchStudentData) {
            $barcode = $_POST['barcode'];
            $lastname = htmlentities($getInfoStudentData->LastName);
            $firstname = htmlentities($getInfoStudentData->FirstName);
            $secondname = htmlentities($getInfoStudentData->SecondName);
            $received = htmlentities($getInfoStudentData->Received);
            $available = htmlentities($getInfoStudentData->Available);

            $output = "<p><b>Данные студента</b></p>
                <p>Фамилия: $lastname</p>
                <p>Имя: $firstname</p>
                <p>Отчество: $secondname</p>
                <p>Справок получено: $received</p>
                <p>Справок доступно: $available</p>
                <p>Пропуск:" . $_POST['barcode'] . "</p>
                <form id=\"printform\" action=\"print.php\" method=\"post\" target=\"_blank\">
                    <input style=\"display:none;\" required id=\"student\" type=\"text\" name=\"student\" value=\"$barcode\" placeholder=\"_\">
                    <input required id=\"count\" type=\"text\" name=\"count\" placeholder=\"_\">
                    <input type=\"submit\" value=\"Печать\">
                </form>
                <button onClick=\"Home();\">Вернуться на главную</button>";
            echo $output;
        } else if ($httpcode != 200) {
            $output = "<p><b>Ошибка:</b></p>
                <p>Не удается установить соединение с \"university.cchgeu.ru\"</p>
                <p>Проверьте корректность введенных данных, а так же проверьте подключены ли вы к сети ВУЗа</p>
                <button onClick=\"Reload();\">Обновить</button>
                <button onClick=\"Home();\">Вернуться на главную</button>";
            echo $output;
        } else {
            $output = "<p><b>Ошибка:</b></p>
                <p>Введенные данные некорректны</p>
                <p>Студент с пропускомы " . $_POST['barcode'] . " не найден</p>
                <button onClick=\"Home();\">Вернуться на главную</button>";
            echo $output;
        }
        ?>
    </div>

    <script>
        $(function() {
            $available = <?php echo $getInfoStudentData->Available ?>;
            if ($available > 0) {
                $.mask.definitions[''+$available] = '[1-'+$available+']';
                $("#count").mask(''+$available);
            } else
                document.getElementById("printform").style.display="none";
            $.mask.definitions['3'] = '[1-3]';
            $("#count").mask('3');
        });
    </script>

</body>

</html>