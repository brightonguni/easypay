<?php
/**
 * Easypay Transaction Key Verification Example
 * @category 	Example File
 * @package 	Easypay-PHP
 * @version 	2.0.0
 * @author      André Filipe
 * @author      Sérgio Morais
 * @copyright	Easypay
 * @license     GPL v2
 */
require_once('./api/Easypay.php');

//verifies authorization status
if ($_GET['s'] == 'ok') {

    /**
     * Define the easypay access parameters
     * Please replace this parameters with your own
     * This parameters can also be defined in the easypay api configuration file
     * in api/Easypay-config.php
     * @var array
     */
    $easypay_params['user'] = '';
    $easypay_params['cin'] = '';
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

    $verification = $easypay->getTransactionVerification( $_GET['r'] );
    
    echo '<pre>';
    var_dump($verification);
    echo '</pre>';
}
?>
<!doctype html>
<html>
    <head>
        <title>Easypay Reference Creation Test</title>
    </head>
    <body>
        <div id="container">
            <span>Estado - <?= $_GET['s'] == 'ok' ? 'Success' : 'Error' ?></span>
        </div>
    </body>
</html>