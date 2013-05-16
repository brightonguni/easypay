<?php
/**
 * Easypay Payment Info Example
 * @category 	Example File
 * @package 	Easypay-PHP
 * @version 	2.0.0
 * @author      André Filipe
 * @author      Sérgio Morais
 * @copyright	Easypay
 * @license	GPL v2
 */
require_once('./api/Easypay.php');

/**
 * Define the easypay access parameters, 
 * this parameters should not be modified
 * @var array
 */
$easypay_params['user'] = $_GET['ep_user'];
$easypay_params['cin'] = $_GET['ep_cin'];

/**
 * Create a new Easypay Object
 * @var Easypay
 */
$easypay = new Easypay($easypay_params);

//set mode to either test or production.
//This can be defined in the config file
$easypay->set_live(false);

//connecting to database
/**
 * Connect to Database,
 * you may use your own connection system, this one is just for example purposes
 * you may also want to change your database credentials
 */
$mysqli = new mysqli("localhost", "root", "123", "easypay_test");
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit();
}

/**
 * First, you need to save the values that are passed by GET on your database
 * @var int(9) ep_cin Your Client Identification Number
 * @var int(9) ep_user Your Client Username
 * @var varchar(50) ep_doc Unique Payment Number
 */
$query = "INSERT INTO `easypay_notifications` ( `ep_cin`, `ep_user`, `ep_doc`)
          VALUES ('" . $_GET['ep_cin'] . "', '" . $_GET['ep_user'] . "', '" . $_GET['ep_doc'] . "');";

$mysqli->query($query);

/**
 * Second, you will request the payment info and update the details of the requested payment
 */
$info = $easypay->getPaymentInfo($_GET['ep_doc']);

$query = "UPDATE `easypay_notifications` SET
            `ep_status` = '"        . $info['ep_status'] . "',
            `ep_entity` = '"        . $info['ep_entity'] . "',
            `ep_reference` = '"     . $info['ep_reference'] . "',
            `ep_value` = '"         . $info['ep_value'] . "',
            `ep_date` = '"          . $info['ep_date'] . "',
            `ep_payment_type` = '"  . $info['ep_payment_type'] . "',
            `ep_value_fixed` = '"   . $info['ep_value_fixed'] . "',
            `ep_value_var` = '"     . $info['ep_value_var'] . "',
            `ep_value_tax` = '"     . $info['ep_value_tax'] . "',
            `ep_value_transf` = '"  . $info['ep_value_transf'] . "',
            `ep_date_transf` = '"   . $info['ep_date_transf'] . "',
            `t_key` = '"            . $info['t_key'] . "'
          WHERE `ep_doc` = '" . $info['ep_doc'] . "';";

$mysqli->query($query);

$mysqli->close();
