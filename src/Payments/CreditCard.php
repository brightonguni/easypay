<?php

namespace Easypay\SDK\Payments;

use Easypay\SDK\Api;

class CreditCard extends Api
{

    /**
     * Requests a credit card record
     * @param  CustomerDetails $customerDetails        Customer Details
     * @param  double          $value                  Value to be paid
     * @param  string          $myIdentificationNumber An identifier of the order corresponding to this payment request
     * @param  string          $observations           You can use this to store whatever you want
     * @return object
     * @throws \Exception Throws exception in case status from easypay is err1
     */
    public function createRecord(CustomerDetails $customerDetails, $value, $myIdentificationNumber = '', $observations = '')
    {
        $args = array(
            'ep_ref_type' => 'auto',
            't_value'     => $value,
            't_key'       => $myIdentificationNumber,
            'o_obs'       => $observations,
        );

        $result = $this->call('01BG', array_merge($args, $customerDetails->toArray()), 'xml');

        if ($result->ep_status == 'err1') {
            throw new \Exception($result->ep_message);
        }

        return $result;
    }

    public function requestPayment($entity, $reference, $value, $k = null)
    {
        $args = array(
            'e' => $entity,
            'r' => $reference,
            'v' => $value,
        );

        if ($k) {
            $args['k'] = $k;
        }

        $result = $this->call('05AG', $args, 'xml');

        if ($result == 'check your vars') {
            throw new \Exception('Error: check your vars');
        } elseif ($result->ep_status == 'err1') {
            throw new \Exception($result->ep_message);
        }

        return $result;
    }
}
