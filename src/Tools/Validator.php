<?php

namespace Easypay\SDK\Tools;
use Easypay\SDK\Api;

class Validator extends Api
{

	/**
	 * Checks if a credit card is valid or not
	 * @param  integer $creditCardNumber  Credit Card Number
	 * @param  string $creditCardCountry Country Code (ISO 3166-2)
	 * @return [type]                    [description]
	 */
	public function checkCreditCard($creditCardNumber, $creditCardCountry)
	{
 		$args = array(
 			'ep_ret_type'     => 'json',
 			'ep_card'         => $creditCardNumber,
 			'ep_card_country' => $creditCardCountry
 			);

        return $this->call('24AG', $args, 'json');
	}
}