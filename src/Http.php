<?php

namespace Zero;

class Http implements HttpInterface
{
    private $ch;

    public function __construct()
    {
        $this->ch = curl_init();

        if ($this->ch === false) {
            throw new \RuntimeException('Zero\Payment\Http::[Failed to initialize cURL]');
        }

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
        return $this->execute();
    }

    public function get($url, $getFields = [])
    {
        if (count($getFields) > 0)
            $url = $url . '?' . http_build_query($getFields);
        
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, false);
        return $this->execute();
    }

    public function form($url, $inputs)
    {
        $szHtml =  '<!DOCTYPE html>';
        $szHtml .= '<html>';
        $szHtml .= '<head>';
        $szHtml .= '<meta charset="utf-8">';
        $szHtml .= '</head>';
        $szHtml .= '<body>';
        $escapedUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $szHtml .= "<form id=\"__Form\" method=\"post\" action=\"{$escapedUrl}\">";
        foreach ($inputs as $keys => $input) {
            $escapedKey = htmlspecialchars((string) $keys, ENT_QUOTES, 'UTF-8');
            $escapedValue = htmlspecialchars((string) $input, ENT_QUOTES, 'UTF-8');
            $szHtml .= "<input type=\"hidden\" name=\"{$escapedKey}\" value=\"{$escapedValue}\" />";
        }
        $szHtml .= "<input type=\"submit\" id=\"__paymentButton\" />";
        $szHtml .= '</form>';
        $szHtml .= '<script type="text/javascript">document.getElementById("__Form").submit();</script>';
        $szHtml .= '</body>';
        $szHtml .= '</html>';
        return $szHtml;
    }

    private function execute()
    {
        $response = curl_exec($this->ch);

        if ($response === false) {
            throw new \RuntimeException('Zero\Payment\Http::[' . curl_error($this->ch) . ']');
        }

        return $response;
    }

    public function __destruct()
    {
        if ($this->ch) {
            curl_close($this->ch);
        }
    }
}
