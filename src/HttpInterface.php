<?php

namespace Zero;

interface HttpInterface
{
    public function post($url, $postFields = []);
    public function get($url, $getFields = []);
    public function form($url, $data);
}
