<?php
include("resources/ConfigParser.php");
include("resources/InfomatApi.php");
$count = $_POST['count'];
$code = $_POST['code'];

$config = new ConfigParser();
$infomatApi = new InfomatApi($config->getParam(ConfigParser::$API_KEY));

$responseFormDocument = $infomatApi->formDocument($code);
if ($responseFormDocument['code'] == 200) {
    $output = json_decode($responseFormDocument['output']);
    $documentNumber = $output->Result;
    $responseGetDocument = $infomatApi->getDocument($documentNumber);
    if ($responseGetDocument['code'] == 200) {
        $documentDirectory = $config->getParam(ConfigParser::$DOCUMENT_DIR);
        $file = $documentDirectory . $code . '_' .$documentNumber . "_$count.pdf";
        $rez = @file_put_contents($file, $responseGetDocument['output']);
        if ($rez) {
            exec("lpoptions -o \"copies=$count\"");
            exec("lp $file");
        }
        $response = [
            'code' => 200,
            'result' => (bool) $rez,
            'document' => $documentNumber,
            'file' => $file,
        ];
    } else {
        $response = [
            'code' => 0,
        ];
    }

} else {
    $response = [
        'code' => 0,
    ];
}
exit(json_encode($response));