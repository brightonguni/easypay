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
     * Stores the last url that was called
     * @var string
     */
    protected $lastUrlCalled;

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
     * @param  string $dataType   Data type if you want to get the data parsed
     * @return string|object
     */
    public function call($segment, array $parameters = array(), $dataType = 'raw')
    {
        $url           = $this->config->getEndpoint() . '_s/api_easypay_' . $segment . '.php';
        $urlParameters = array_merge($this->config->toArray(), $parameters);
        $urlToCall     = $url . '?' . http_build_query($urlParameters);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlToCall);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = trim(curl_exec($ch));
        curl_close($ch);

        $this->lastUrlCalled = $urlToCall;

        $result = $response;
        
        ob_start();
        switch ($dataType) {
            case 'xml':
                // This is used to convert all the children to stdclass, if any
                $result = json_decode(json_encode(simplexml_load_string($response)));
                break;

            case 'json':
                $result = json_decode($response);
                break;
        }
        $messages = ob_get_clean();

        if (empty(trim($messages))) {
            return $result;
        }

        return $response;
    }

    /**
     * Return the last Url called
     * @return string Url called
     */
    public function getLastCall()
    {
        return $this->lastUrlCalled;
    }
}
