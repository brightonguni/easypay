<?php

namespace Easypay\SDK;

class Connection
{
    protected $config; 

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function call($segment, array $parameters = array())
    {
        $url = $this->config->getEndpoint() . '_s/api_easypay_' . $segment . '.php';
        $urlParameters = array_merge($this->config->toArray(), $parameters);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($urlParameters));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = trim(curl_exec($ch));
        curl_close($ch);
    }
}
