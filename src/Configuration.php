<?php

namespace Easypay\SDK;

class Configuration
{
    const MODE_LIVE = 'live';
    const MODE_SANDBOX = 'sandbox';

    /**
     * Username
     * @var string
     */
    protected $username;
    
    /**
     * CIN - Client Identification Number
     * @var integer
     */
    protected $cin;

    /**
     * Entity
     * @var integer
     */
    protected $entity;

    /**
     * Communication Code
     * @var string
     */
    protected $code;

    /**
     * Request mode
     * @var string
     */
    protected $mode;

    /**
     * Configuration class constructor
     */
    public function __construct()
    {
        $this->setMode(self::MODE_SANDBOX);
    }

    /**
     * Returns the endpoint depending on the mode
     * @return string Endpoint URL
     */
    public function getEndpoint()
    {
        switch ($this->getMode()) {
            case self::MODE_LIVE:
                return 'https://www.easypay.pt/';
            
            case self::MODE_SANDBOX:
            default:
                return 'http://test.easypay.pt/';
        }
    }

    /**
     * Sets the Username
     * @param string $username Username
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Sets the Client Identification Number
     * @param integer $cin CIN
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
        return $this;
    }

    /**
     * Sets the Entity
     * @param integer $entity Entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * Sets the Communication code
     * @param string $code Code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Sets the Mode
     * @param string $mode Mode
     */
    public function setMode($mode)
    {
        if (!in_array($mode, array(self::MODE_LIVE, self::MODE_SANDBOX))) {
            throw new Exception("Invalid mode");
        }

        $this->mode = $mode;
        return $this;
    }

    /**
     * Returns the mode that we are using
     * @param string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Returns an array with the options to use on a request
     * @return array
     */
    public function toArray()
    {
        $data = array(
            'ep_user'   => $this->username,
            'ep_cin'    => $this->cin,
            'ep_entity' => $this->entity
            );

        if ($this->code) {
            $data['ep_code'] = $this->code;
        }

        return $data;
    }
}
