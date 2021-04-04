<?
namespace controllers;

include_once ("serialPort/PhpSerial.php");
include_once ("ConfigController.php");
use \serialPort\PhpSerial;

class IndexController
{

    var $config = null;
    var $serial = null;
    var $barcode = null;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->config = new ConfigController();
        $this->serial = new PhpSerial();

        //$this->serial->deviceSet($this->config->getParam(PORT));

        /*$this->portConfigure([
            "baudRate"          =>  $this->config->getParam(BAUD_RATE) ?: null,
            "parity"            =>  $this->config->getParam(PARITY) ?: null,
            "characterLength"   =>  $this->config->getParam(CHARACTER_LENGTH) ?: null,
            "stopBits"          =>  $this->config->getParam(STOP_BITS) ?: null,
            "flowControl"       =>  $this->config->getParam(FLOW_CONTROL) ?: null
        ]);*/
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

    public function portConfigure($params = [])
    {
        if (!$this->serial)
            return;
        if ($params->baudRate) {
            $this->serial->confBaudRate($params->baudRate);
        }
        if ($params->parity) {
            $this->serial->confBaudRate($params->parity);
        }
        if ($params->characterLength) {
            $this->serial->confBaudRate($params->characterLength);
        }
        if ($params->stopBits) {
            $this->serial->confBaudRate($params->stopBits);
        }
        if ($params->flowControl) {
            $this->serial->confBaudRate($params->flowControl);
        }
    }

}