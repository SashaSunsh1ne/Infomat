<?php

class ConfigParser
{
    public static $API_KEY = "Api-key";
    public static $PORT_NAME = "Port-Name";
    public static $DOCUMENT_DIR = "Document-Dir";

    public function getParam($paramName = 'Api-key') {
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