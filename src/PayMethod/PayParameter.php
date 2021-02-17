<?php

namespace Zero\Pay\PayMethod;

use Exception;

class PayParameter
{
    public $sendMethod;
    public $necessaryParameters;
    public $sendData;

    /**
     * 選擇必要設定參數
     */
    public function selectNecessaryParametersConfig($pay)
    {
        $this->necessaryParameters = require(dirname(dirname(__FILE__)) . "/config.php");
        switch (strtolower($pay)) {
            case 'ecpay':
                $this->necessaryParameters = $this->necessaryParameters[strtolower($pay)];
                break;
            case 'linepay':
                $this->necessaryParameters = $this->necessaryParameters[strtolower($pay)];
                break;
            default:
                throw new Exception('no necessary parameters config data');
        }
    }


    /**
     * 請求參數
     */
    public function requestParameter($data)
    {
        $this->sendData = $data;
    }
}
