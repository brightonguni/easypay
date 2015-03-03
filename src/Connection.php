<?php

namespace Easypay\SDK;

class Connection
{
    /**
     * Configuration holder
     * @var Configuration
     */
    protected $config; 

    /**
     * Connection class constructor
     * @param Configuration $config Configuration class
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * Requests a specified segment of the API
     * @param  string $segment    Segment
     * @param  array  $parameters Arguments to be sent on the request
     * @return [type]             [description]
     */
    public function call($segment, array $parameters = array(), $dataType = 'raw')
    {
        $url = $this->config->getEndpoint() . '_s/api_easypay_' . $segment . '.php';
        $urlParameters = array_merge($this->config->toArray(), $parameters);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($urlParameters));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = trim(curl_exec($ch));
        curl_close($ch);

        switch ($dataType) {
            case 'xml':
                return json_decode(json_encode((array) simplexml_load_string($response), true));

            case 'json':
                return json_decode($response);
            
            case 'raw':
            default:
                return $response;
        }
    }
}
