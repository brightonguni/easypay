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
     * Partner Username
     * @var string
     */
    protected $partnerUsername;
    
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
     * Country code
     * @var string
     */
    protected $country;

    /**
     * Language code
     * @var string
     */
    protected $language;

    /**
     * Custom parameters to be added to the request
     * @var array
     */
    protected $customParameters = array();

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
     * @return  Configuration
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Sets the Partner Username
     * @param string $username Username
     * @return  Configuration
     */
    public function setPartnerUsername($username)
    {
        $this->partnerUsername = $username;
        return $this;
    }

    /**
     * Sets the Client Identification Number
     * @param integer $cin CIN
     * @return  Configuration
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
        return $this;
    }

    /**
     * Sets the Entity
     * @param integer $entity Entity
     * @return  Configuration
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * Sets the Communication code
     * @param string $code Code
     * @return  Configuration
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Sets the Country code
     * @param string $countryIsoCode ISO-3301-alpha2 Country Code
     * @return  Configuration
     */
    public function setCountry($countryIsoCode)
    {
        $this->country = $countryIsoCode;
        return $this;
    }

    /**
     * Sets the Language code
     * @param string $language Language ISO-3301-alpha2 Code
     * @return  Configuration
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Sets the Mode
     * @param string $mode Mode
     * @return  Configuration
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
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Sets a custom parameter to be added to the request
     * @param string $key   Key
     * @param string $value Value
     * @return Configuration
     */
    public function setCustomParameter($key, $value)
    {
        $this->customParameters[$key] = $value;
        return $this;
    }

    /**
     * Returns the value of a custom parameter if it's setted
     * @param  string $key Key
     * @return string      Value
     */
    public function getCustomParameter($key)
    {
        return isset($this->customParameters[$key]) ? $this->customParameters[$key] : null;
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

        if ($this->partnerUsername) {
            $data['ep_partner'] = $this->partnerUsername;
        }

        if ($this->code) {
            $data['s_code'] = $this->code;
        }

        if ($this->country) {
            $data['ep_country'] = $this->country;
        }

        if ($this->language) {
            $data['ep_language'] = $this->language;
        }

        return array_merge($data, $this->customParameters);
    }
}
