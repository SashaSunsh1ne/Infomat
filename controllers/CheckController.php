<?php
namespace controllers;

class CheckController
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function getResultFromApiMethod($urlMethod, $value = ""){
        $ch = curl_init($urlMethod . '/' . $value);
        $this->curlSetOpts($ch);
        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$httpCode ?: 0, $output ?: null];
    }

    private function curlSetOpts($ch) {
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Key-api: '. $this->key]);
    }
}