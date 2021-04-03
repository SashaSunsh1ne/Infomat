<?php
define ("LICENSE_KEY", "License-key");
define ("PORT", "Port-Name");
define ("OPENMODE", "Port-OpenMode");
define ("PORT_BAUDRATE", "Port-BaudRate");
define ("PORT_PARITY", "Port-Parity");
define ("PORT_CHARACTERLENGTH", "Port-CharacterLength");
define ("PORT_STOPBITS", "Port-StopBits");
define ("PORT_FLOWCONTROL", "Port-FlowControl");

class Config
{

    public function __constructor(){
        $content = file_get_contents(getcwd() . "/config/config.txt");
        $content = preg_replace('/\s+/', '', $content);
        $this->fileContentArray = explode(";", $content);
    }

    /**
     * @param  string $device the name of the device to be used
     * @return string
     */
    public function getParam($paramName = LICENSE_KEY) {
        $content = file_get_contents(getcwd() . "/config/config.txt");
        $content = preg_replace('/\s+/', '', $content);
        $content = explode(";", $content);
        foreach ($content as $item) {
            $param = explode(":", $item);
            $paramValue = $param[0] == $paramName ? $param[1] : null;
            if ($paramValue)
                return $paramValue;
        }
    }

}