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

    /**
     * Requests a specified segment of the API
     * @param  string $segment    Segment
     * @param  array  $parameters Arguments to be sent on the request
     * @param  string $dataType   Data type if you want to get the data parsed
     * @return string|object
     */
    public function call($segment, array $parameters = array(), $dataType = 'raw')
    {
        return $this->connection->call($segment, $parameters, $dataType);
    }
}
