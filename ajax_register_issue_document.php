<?php
include("resources/ConfigParser.php");
include("resources/InfomatApi.php");
$document = $_POST['document'];
$count = $_POST['count'];

$config = new ConfigParser();
$infomatApi = new InfomatApi($config->getParam(ConfigParser::$API_KEY));

$responseRegister = $infomatApi->registerIssueDocument($document);
header('Location: index.php');