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
            "baudRate"          =>  $this->config->getParam(BAUD_RATE) ?: 9600,
            "parity"            =>  $this->config->getParam(PARITY) ?: "none",
            "characterLength"   =>  $this->config->getParam(CHARACTER_LENGTH) ?: 8,
            "stopBits"          =>  $this->config->getParam(STOP_BITS) ?: 1,
            "flowControl"       =>  $this->config->getParam(FLOW_CONTROL) ?: "none"
        ]);*/

        //$this->serial->deviceOpen($this->config->getParam(OPEN_MODE) ?: "r");
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
        $this->serial->confBaudRate($params->baudRate);
        $this->serial->confBaudRate($params->parity);
        $this->serial->confBaudRate($params->characterLength);
        $this->serial->confBaudRate($params->stopBits);
        $this->serial->confBaudRate($params->flowControl);
    }

}