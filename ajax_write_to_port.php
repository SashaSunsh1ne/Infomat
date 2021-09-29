<?php
include ('resources/ConfigParser.php');
$configParser = new ConfigParser();
$device = $configParser->getParam(ConfigParser::$PORT_NAME);
$open_mode = 'r+';

$handle = @fopen($device, $open_mode);
if ($handle) {
    $data = @fwrite($handle, 'No card' . PHP_EOL);
}