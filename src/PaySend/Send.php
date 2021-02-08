<?php

namespace Zero\Pay\PaySend;

class Send
{
    public $ch;

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function post($url, $postFields = [], $headers = [])
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postFields);
        return curl_exec($this->ch);
    }

    public function get($url, $getFields = [], $headers = [])
    {
        curl_setopt($this->ch, CURLOPT_URL, $url . $getFields);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($this->ch);
    }

    public function form($url, $data)
    {
        $szHtml =  '<!DOCTYPE html>';
        $szHtml .= '<html>';
        $szHtml .= '<head>';
        $szHtml .= '<meta charset="utf-8">';
        $szHtml .= '</head>';
        $szHtml .= '<body>';
        $szHtml .= "<form id=\"__ecPayForm\" method=\"post\" action=\"{$url}\">";
        foreach ($data as $keys => $value) {
            $szHtml .= "<input type=\"hidden\" name=\"{$keys}\" value=\"" . htmlentities($value) . "\" />";
        }
        $szHtml .= "<input type=\"submit\" id=\"__paymentButton\" />";
        $szHtml .= '</form>';
        $szHtml .= '<script type="text/javascript">document.getElementById("__ecPayForm").submit();</script>';
        $szHtml .= '</body>';
        $szHtml .= '</html>';
        return $szHtml;
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
