<?php
namespace controllers;

define ("API_KEY", "Api-key");
define ("PORT", "Port-Name");
define ("OPEN_MODE", "Port-OpenMode");
define ("BAUD_RATE", "Port-BaudRate");
define ("PARITY", "Port-Parity");
define ("CHARACTER_LENGTH", "Port-CharacterLength");
define ("STOP_BITS", "Port-StopBits");
define ("FLOW_CONTROL", "Port-FlowControl");

class ConfigController
{

    public function getParam($paramName = API_KEY) {
        $content = file_get_contents(getcwd() . "/config/config.txt");
        $content = preg_replace('/\s+/', '', $content);
        $content = explode(";", $content);
        foreach ($content as $item) {
            $param = explode(":", $item);
            $paramValue = $param[0] == $paramName ? $param[1] : null;
            if ($paramValue)
                return $paramValue;
        }
        return null;
    }

}