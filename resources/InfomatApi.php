<?php

class InfomatApi
{
    private $key;
    private $baseUrl = "http://university.cchgeu.ru/infomat/hs/infomat";

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param $method
     * @param string $param
     *
     * @return array
     */
    private function getResultFromApiMethod($method, $param){
        $ch = curl_init($this->baseUrl . DIRECTORY_SEPARATOR . $method . DIRECTORY_SEPARATOR . $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Key-api: $this->key"));
        $output = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [
            'code' => $code ?: 0,
            'output' => $output ?: null
        ];
    }

    /**
     * Существует ли студент?
     * @param string $code
     *
     * @return array
     */
    public function searchStudent($code){
        return $this->getResultFromApiMethod("searchStudent", $code);
    }

    /**
     * Получить данные студента
     * @param string $code
     *
     * @return array
     */
    public function getInfoStudent($code){
        return $this->getResultFromApiMethod("getInfoStudent", $code);
    }

    /**
     * Сформировать справку студента
     * @param string $code
     *
     * @return array
     */
    public function formDocument($code){
        return $this->getResultFromApiMethod("formDocument", $code);
    }

    /**
     * Получить справку по номеру
     * @param int $documentNumber
     *
     * @return array
     */
    public function getDocument($documentNumber){
        return $this->getResultFromApiMethod("getDocument", $documentNumber);
    }

    /**
     * Зарегистрировать ошибку при печати документа
     * @param int $documentNumber
     *
     * @return array
     */
    public function registerIssueDocument($documentNumber){
        return $this->getResultFromApiMethod("registerIssueDocument", $documentNumber);
    }
}