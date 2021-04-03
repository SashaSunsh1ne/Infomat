<?php
if (isset($_POST['count']) && isset($_POST['student'])){
    $documentStudent = 'http://university.cchgeu.ru/infomat/hs/infomat/getDocument/'.$_POST['student'].'/'.$_POST['count'];
    $ch = curl_init($documentStudent);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_TIMEOUT,10);
    $documentOutput = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode==200) {
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=student.pdf");
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
            if ($httpcode==200) {
                echo $documentOutput;
            } else {
                $output = "<p><b>Ошибка:</b></p>
                <p>Не удается установить соединение с \"university.cchgeu.ru\"</p>
                <p>Проверьте корректность введенных данных, а так же проверьте подключены ли вы к сети ВУЗа</p>
                <button onClick=\"Reload();\">Обновить</button>
                <button onClick=\"Home();\">Вернуться на главную</button>";
                echo $output; 
            }
        ?>
    </div>
    
    
    
</body>

</html>