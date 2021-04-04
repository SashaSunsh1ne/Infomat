<?
use controllers\ConfigController;
use controllers\CheckController;
include_once("controllers/ConfigController.php");
include_once("controllers/CheckController.php");
$config = new ConfigController();
$url = "http://university.cchgeu.ru/infomat/hs/infomat";
$studentExist = [0];
$getInfoStudentData = null;
if (isset($_POST['barcode']))
    $controller = new CheckController($config->getParam());
    $studentExist = $controller->getResultFromApiMethod($url . '/searchStudent',$_POST['barcode']);
    if ($studentExist[0] == 200) {
        $result = $controller->getResultFromApiMethod($url . '/getInfoStudent',$_POST['barcode']);
        if ($result[0] == 200) {
            $getInfoStudentData = json_decode($result[1]);
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
        <?
        if ($getInfoStudentData) {
            $barcode = $_POST['barcode'];
            $lastname = htmlentities($getInfoStudentData->LastName);
            $firstname = htmlentities($getInfoStudentData->FirstName);
            $secondname = htmlentities($getInfoStudentData->SecondName);
            $received = htmlentities($getInfoStudentData->Received);
            $available = htmlentities($getInfoStudentData->Available);

            $output = "
                <p><b>Данные студента</b></p>
                <p>Фамилия: $lastname</p>
                <p>Имя: $firstname</p>
                <p>Отчество: $secondname</p>
                <p>Справок получено: $received</p>
                <p>Справок доступно: $available</p>
                <p>Пропуск: " . $_POST['barcode'] . "</p>
                <form id=\"printform\" action=\"print.php\" method=\"post\" target=\"_blank\">
                    <input style=\"display:none;\" required id=\"student\" type=\"text\" name=\"student\" value=\"$barcode\" placeholder=\"_\">
                    <input required id=\"count\" type=\"text\" name=\"count\" placeholder=\"_\">
                    <input type=\"submit\" value=\"Печать\">
                </form>
                <button onClick=\"Home();\">Вернуться на главную</button>
                ";
            echo $output;
        } else if ($studentExist[0] == 0) {
            $output = "<p><b>Ошибка:</b></p>
                <p>Не удается установить соединение с \"university.cchgeu.ru\"</p>
                <p>Проверьте корректность введенных данных, а так же проверьте подключены ли вы к сети ВУЗа</p>
                <button onClick=\"Reload();\">Обновить</button>
                <button onClick=\"Home();\">Вернуться на главную</button>";
            echo $output;
        } else if ($studentExist[0] == 403) {
            $output = "<p><b>Ошибка доступа:</b></p>
                <p>У вас нет доступа к выдаче справок</p>
                <button onClick=\"Home();\">Вернуться на главную</button>";
            echo $output;
        }
        ?>
    </div>

    <script>
        $(function() {
            let available = 0 + <? echo $getInfoStudentData->Available ?>;
            if (available > 0 && available < 10) {
                $.mask.definitions['^'] = '[1-'+available+']';
                $("#count").mask('^');
            } else if (available <= 0) {
                document.getElementById("printform").style.display = "none";
            } else {
                $.mask.definitions['3'] = '[1-3]';
                $("#count").mask('3');
            }
        });
    </script>

</body>

</html>