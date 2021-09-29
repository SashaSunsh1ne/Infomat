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
        <p id="instruction">Для начала сканирования нужно нажать на кнопку "ПОЛУЧИТЬ СПРАВКУ", после чего необходимо поднести пропуск к сканеру</p>
        <button id="scan_button" onclick="readFromPort(10);">ПОЛУЧИТЬ СПРАВКУ</button>
        <form id="code_form" hidden method="post" action="get_student.php">
            <input type="text" id="code" name="code" required>
        </form>
    </div>
    <script type="text/javascript">
        const scan = $("#scan_button");
        const instruction = $("#instruction");
        const instruction_content = instruction.html();
        const code_form = $("#code_form");
        const code = $("#code");

        function readFromPort(seconds) {
            startScanTimeout(seconds);
            $.ajax({
                url: "ajax_scan_port.php",
                type: "post",
                success: function (response) {
                    response = JSON.parse(response);
                    let str = response['content'];
                    if (str.length == 25) {
                        let rez = str.substring(str.length - 9);
                        code.val(rez);
                        code_form.submit();
                    }
                },
                error: function () {
                    writeToPort();
                },
                timeout: seconds * 1000
            });
        }

        function writeToPort() {
            $.ajax({
                url: "ajax_write_to_port.php",
                type: "post"
            });
        }

        function startScanTimeout(seconds) {
            scan.attr('hidden', 'hidden');
            instruction.html('Поднесите ваш пропуск к сканеру');
            let func = function () {
                scan.removeAttr('hidden');
                instruction.html(instruction_content);
            }
            return setTimeout(func, seconds * 1000);
        }
    </script>
</body>
</html>