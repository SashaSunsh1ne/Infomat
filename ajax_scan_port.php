<?php
include ('resources/ConfigParser.php');
$configParser = new ConfigParser();
$device = $configParser->getParam(ConfigParser::$PORT_NAME);
$open_mode = 'r';

$handle = @fopen($device, $open_mode);
if ($handle) {
    $data = @fgets($handle);
    @fclose($handle);
    $response = [
        'code' => 200,
        'status' => 'ok',
        'message' => 'Card successfully read',
        'content' => trim($data),
    ];
} else {
    $response = [
        'code' => 403,
        'status' => 'error',
        'message' => 'File not fount / Access denied',
    ];
}
exit(json_encode($response));