<?php

namespace Easypay\SDK;

abstract class Api
{
    /**
     * Connection holder
     * @var Connection
     */
    protected $connection; 

    /**
     * Api class constructor
     * @param Connection $config Connection class
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
