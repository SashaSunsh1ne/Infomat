<?php

include_once ("serialPort/PhpSerial.php");
include_once ("ConfigController.php");

class IndexController
{
    private $config;
    private $serial;
    private $barcode = null;
    private $isTimerOn;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->config = new ConfigController();

        $this->serial = new PhpSerial();
        $this->serial->deviceSet($this->config->getParam(PORT));
        $this->portConfigure(array(
            "baudRate" => $this->config->getParam(BAUD_RATE) ?:                 9600,
            "parity" => $this->config->getParam(PARITY) ?:                      "none",
            "characterLength" => $this->config->getParam(CHARACTER_LENGTH) ?:   8,
            "stopBits" => $this->config->getParam(STOP_BITS) ?:                 1,
            "flowControl" => $this->config->getParam(FLOW_CONTROL) ?:           "none"
        ));
    }

    public function readSerialUntilResult($seconds = 1)
    {
        $timer = 0;
        $iterationsPerSeconds = 4;
        $this->serial->deviceOpen($this->config->getParam(OPEN_MODE) ?: "r");
        $this->isTimerOn = true;
        while ((!$this->barcode || $this->barcode == "No card") && ($timer <= $seconds * $iterationsPerSeconds)) {
            $this->barcode = $this->serial->readPort() ?: "No card";
            sleep(1 / $iterationsPerSeconds);
            $timer++;
        }
        $this->serial->deviceClose();
        $this->isTimerOn = false;
        die($this->barcode);
    }

    public function portConfigure(array $params)
    {
        if (!$this->serial)
            return;
        $this->serial->confBaudRate($params["baudRate"]);
        $this->serial->confBaudRate($params["parity"]);
        $this->serial->confBaudRate($params["characterLength"]);
        $this->serial->confBaudRate($params["stopBits"]);
        $this->serial->confBaudRate($params["flowControl"]);
    }

    public function isTimerOn()
    {
        return $this->isTimerOn;
    }

    public function getBarcode()
    {
        if ($this->barcode != "No card" || !$this->barcode)
            return null;
        else
            return $this->barcode;
    }
}