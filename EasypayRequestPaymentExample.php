<?php
/**
 * Easypay Request Payment Example
 * @category 	Example File
 * @package 	Easypay-PHP
 * @version 	2.0.0
 * @author      Ricardo Lopes
 * @copyright	Easypay
 * @license		GPL v2
 */
require_once('./api/Easypay.php');

//verifies if payment was successfull or not, if so, requests payment information
if ($_GET['s'] == 'ok') {

    /**
     * Define the easypay access parameters
     * Please replace this parameters with your own
     * This parameters can also be defined in the easypay api configuration file
     * in api/Easypay-config.php
     * @var array
     */
    $easypay_params['user'] = '';
    $easypay_params['entity'] = $_GET['e'];

    //Uncomment if you need to validate by code code
    //$ep_conf['code'] = '';

    /**
     * Create a new Easypay Object
     * @var Easypay
     */
    $easypay = new Easypay($easypay_params);

    //set mode to either test or production.
    //This can be defined in the config file
    $easypay->set_live(false);

    /**
     * Requesting Payment
     * @var array
     */
    $payment = $easypay->requestPayment($_GET['r'], $_GET['k']);
}
?>
<!doctype html>
<html>
    <head>
        <title>Easypay Reference Creation Test</title>
    </head>
    <body>
        <div id="container">
            <?php if ($_GET['s'] == 'ok') { ?>            
                <span>Entidade - <?= $payment['ep_entity'] ?></span><br>
                <span>Referência - <?= $payment['ep_reference'] ?></span><br>
                <span>Estado - <?= $payment['ep_status'] == 'ok0' ? 'Success' : 'Error' ?></span><br>
            <?php } else { ?>
                <span>Estado - Error</span><br>
            <?php } ?>
        </div>
    </body>
</html>