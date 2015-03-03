<?php

namespace Easypay\SDK;

class Configuration
{
    const MODE_LIVE = 'live';
    const MODE_SANDBOX = 'sandbox';

    protected $username;
    protected $cin;
    protected $entity;
    protected $code;
    protected $mode;

    public function getEndpoint()
    {
        if ($this->isLive()) {
            return 'https://www.easypay.pt/';
        }
        return 'http://test.easypay.pt/';
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setCin($cin)
    {
        $this->cin = $cin;
        return $this;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setMode($mode)
    {
        if (!in_array($mode, [self::MODE_LIVE, self::MODE_SANDBOX])) {
            throw new Exception("Invalid mode");
        }

        $this->mode = $mode;
        return $this;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function isLive()
    {
        return $this->getMode() == self::MODE_LIVE;
    }

    public function toArray()
    {
        return [
            'ep_user'   => $this->username,
            'ep_cin'    => $this->cin,
            'ep_entity' => $this->entity,
            'ep_code'   => $this->code,
        ];
    }
}
