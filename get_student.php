<?php
include ("resources/ConfigParser.php");
include ("resources/InfomatApi.php");
$code = $_POST['code'];
$config = new ConfigParser();
$infomatApi = new InfomatApi($config->getParam(ConfigParser::$API_KEY));
$responseSearchStudent = $infomatApi->searchStudent($code);
if ($responseSearchStudent['code'] == 200) {
    $output = json_decode($responseSearchStudent['output']);
    $studentIsExists = (bool) $output->Result;
    if ($studentIsExists) {
        $responseGetInfoStudent = $infomatApi->getInfoStudent($code);
        if ($responseGetInfoStudent['code'] == 200) {
            $studentData = json_decode($responseGetInfoStudent['output']);
            $lastName = $studentData->LastName;
            $firstName = $studentData->FirstName;
            $secondName = $studentData->SecondName;
            $received = $studentData->Received;
            $available = $studentData->Available;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.5.1.js"></script>
    <title>Infomat</title>
</head>
<body>
<div class="infoblock">
    <p><b>INFOMAT</b></p>
</div>
<div class="infoblock">
    <?php if ($responseSearchStudent['code'] == 200) : ?>
        <?php if ($studentIsExists) : ?>
            <p><b><?= $lastName . ' ' . $firstName . ' ' . $secondName ?></b></p>
            <?php if ($available > 0) : ?>
                <p>Сколько справок распечатать?</p>
                <form name="print_form" hidden>
                    <input required type="text" name="code" value="<?= $code ?>">
                    <input required type="number" name="count" value="1" min="1" max="<?= $available ?>" step="1">
                </form>
                <button id="decrementer" style="width: 70px" onclick="decrement()">-</button>
                <span><b id="value">1</b></span>
                <button id="incrementer" style="width: 70px" onclick="increment()">+</button>
                <br>
                <button id="print_button" onclick="sendToPrinter()">Печать</button>

                <script>
                    const print_form = $('form[name=print_form]');
                    const print_button = $('#print_button');
                    const count = $('input[name=count]');
                    const decrementer = $('#decrementer');
                    const value = $('#value');
                    const incrementer = $('#incrementer');
                    const available = <?= $available ?>;

                    let current_value = parseInt(value.html());
                    setValue(current_value);
                    function increment() {setValue(current_value + 1);}
                    function decrement() {setValue(current_value - 1);}
                    function setValue(int) {
                        current_value = int
                        value.html(int);
                        count.attr('value', int);
                        if (int == available) incrementer.attr('disabled', 'disabled');
                        else if (int < available) incrementer.removeAttr('disabled');
                        if (int == 1) decrementer.attr('disabled', 'disabled');
                        else if (int > 1) decrementer.removeAttr('disabled');
                    }
                    function sendToPrinter() {
                        print_button.attr('disabled', 'disables');
                        $.ajax({
                            url: "ajax_print_document.php",
                            type: "post",
                            data: print_form.serialize(),
                            success: function (response) {
                                response = JSON.parse(response);
                                registerIssueDocument(response.document, response.count);
                            }
                        });
                    }
                    function registerIssueDocument(document, count) {
                        $.ajax({
                            url: "ajax_register_issue_document.php",
                            type: "post",
                            data: {document: document, count: count}
                        });
                    }
                </script>
            <?php else : ?>
                <p>Вы уже распечатали все доступные справки</p>
            <?php endif ?>
        <?php else : ?>
            <p><b>Ошибка:</b></p>
            <p>Студент не найден</p>
        <?php endif ?>
    <?php else : ?>
        <p><b>Ошибка:</b></p>
        <?php if ($responseSearchStudent['code'] == 0) : ?>
            <p>Не удается установить соединение с "university.cchgeu.ru"</p>
            <p>Проверьте корректность введенных данных, а так же проверьте подключены ли вы к сети ВУЗа</p>
        <?php elseif ($responseSearchStudent['code'] == 403) : ?>
            <p>Отказано в доступе</p>
        <?php endif ?>
    <?php endif ?>
    <br>
    <button onclick="window.location.replace('index.php')">Вернуться на главную</button>
</div>
<script>
    setTimeout(function () { window.location.replace('index.php') }, 30 * 1000);
</script>
</body>
</html>