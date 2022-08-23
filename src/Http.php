<?php

namespace Zero;

class Http implements HttpInterface
{
    private $ch;

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function setup($headers = [])
    {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    public function post($url, $postFields = [])
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postFields);
        return curl_exec($this->ch);
    }

    public function get($url, $getFields = [])
    {
        if (count($getFields) > 0)
            $url = $url . '?' . http_build_query($getFields);
        
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, false);
        return curl_exec($this->ch);
    }

    public function form($url, $inputs)
    {
        $szHtml =  '<!DOCTYPE html>';
        $szHtml .= '<html>';
        $szHtml .= '<head>';
        $szHtml .= '<meta charset="utf-8">';
        $szHtml .= '</head>';
        $szHtml .= '<body>';
        $szHtml .= "<form id=\"__Form\" method=\"post\" action=\"{$url}\">";
        foreach ($inputs as $keys => $input) {
            $szHtml .= "<input type=\"hidden\" name=\"{$keys}\" value=\"" . htmlentities($input) . "\" />";
        }
        $szHtml .= "<input type=\"submit\" id=\"__paymentButton\" />";
        $szHtml .= '</form>';
        $szHtml .= '<script type="text/javascript">document.getElementById("__Form").submit();</script>';
        $szHtml .= '</body>';
        $szHtml .= '</html>';
        return $szHtml;
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
