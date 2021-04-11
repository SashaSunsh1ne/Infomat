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
            "baudRate"          => $this->config->getParam(BAUD_RATE) ?:            9600,
            "parity"            => $this->config->getParam(PARITY) ?:               "none",
            "characterLength"   => $this->config->getParam(CHARACTER_LENGTH) ?:     8,
            "stopBits"          => $this->config->getParam(STOP_BITS) ?:            1,
            "flowControl"       => $this->config->getParam(FLOW_CONTROL) ?:         "none"
        ));

        $this->serial->deviceOpen($this->config->getParam(OPEN_MODE) ?: "r");
    }

    public function readSerialUntilResult()
    {
        $this->serial->deviceOpen($this->config->getParam(OPENMODE));
        while (!$this->barcode)
        {
            $this->barcode = $this->serial->readPort() ?: null;
            sleep(1);
        }
        $this->serial->deviceClose();
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

    public function waitForCard()
    {
        if ($this->isTimerOn)
            return '<p>Error</p>';
        new EvTimer(0, 1, function () {
            echo "итерация = ", Ev::iteration(), PHP_EOL;
            if (Ev::iteration() >= 30) {
                $this->isTimerOn = false;
            }
        });
        return '<p>Success</p>';
    }

    public function isTimerOn() {
        return $this->isTimerOn;
    }
}