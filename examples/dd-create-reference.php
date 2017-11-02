<?php

/**
 * The following code demonstrates how to create a Direct debit reference with 01BG API
 * Once the reference is created, the user will be redirected to Easypay's payment gateway
 * to insert the SWIFT and IBAN info.
 */

// Set error reporting for demo purposes
error_reporting(E_ERROR);

// Load autoload classes
require_once 'vendor/autoload.php';
require_once 'config.php';

$easypay = new Easypay\EasyPay($easypayConfig);

// Note: Live mode is disabled by default.
// If you want to use production you'll need to uncomment the following line
// $easypay->setLive(true);


// In an usual use case, you would have an order that should be related
// to your payment. We're creating a dummy order here, using the sample database on schema/
$conn = new PDO('mysql:host=' . $dbConfig['host']. ';dbname=easypay_examples', $dbConfig['user'], $dbConfig['pass']);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->exec("INSERT INTO `orders`(some_field) VALUES ('Some purchase')");
$tKey = $conn->lastInsertId();

// Set the key so you can correlate the payment with your system
// This key is usually an autoincrement value from DB and will always
// be treated as "t_key" by easypay
$easypay->setValue('t_key', $tKey);

// Set the value to be payed
$value = '50.00';
$easypay->setValue('t_value', $value);

// Fill in optional values
$obs = 'Bought XPTO product on Nov 2017';
$mobile = '+351 123 456 789';
$email = 'email@example.com';
$easypay->setValue('o_name', 'John Doe with accented characters çãºáÒ\'\'.');
$easypay->setValue('o_description', 'Purchase of amazing product');
$easypay->setValue('o_obs', $obs);
$easypay->setValue('o_mobile', $mobile);
$easypay->setValue('o_email', $email);

// Since this is a direct debit, you'll need to set the recurrent frequency and the return url
// This parameter is the minimum period between to payment requests. However, you are not
// obligated to call the payments between this specific period.
// For eg: you can set 2W (2 weeks) and request a payment every 3 weeks or every month
// You can't however, set this to 1M (1 month) and request payments every 2 weeks
$easypay->setValue('ep_rec_freq', '2W');

// This parameter is used once the user submits the IBAN and SWIFT on Easypay's Gateway
// On submit, Easypay will send the client back to this URL
$easypay->setValue('ep_rec_url', '//your-website-url.com/easypay-gateway-redirect.php');

// Notice the 'recurring' value
$result = $easypay->createReference('recurring');

// Verify if the request throwed an error:
// Easypay result "normally" throws a ep_status with "err1" when there's an error
// but I'm not sure if it's always a "1" at the end, so we better prepare for anything
preg_match("/err[0-9]+/", $result["ep_status"], $matches);

// If matches is not empty, an error was thrown
if (count($matches) !== 0 || $result === false) {
    var_dump($result);
    throw new Exception('Something went wrong with Easypay integration');
}

// We'll display the reference below.
// We're going to store this info on the `easypay_references` table to use later on.
// However, for advanced sites / applications, you will probably want to send this
// information to the client by email or something.

// When creating a DD reference, the API will retrieve more information
$stmt = $conn->prepare('
    INSERT INTO easypay_references (ep_cin, ep_status, ep_message, ep_entity, ep_reference, ep_k1, t_key, o_obs, o_mobile, o_email, ep_value, ep_link, ep_link_rp_dd, ep_link_rp_cc, ep_periodicity)
    VALUES (:ep_cin, :ep_status, :ep_message, :ep_entity, :ep_reference, :ep_k1, :t_key, :o_obs, :o_mobile, :o_email, :ep_value, :ep_link, :ep_link_rp_dd, :ep_link_rp_cc, :ep_periodicity)
');
$stmt->execute([
    ':ep_cin' => $easypayConfig['cin'],
    ':ep_status' => $result['ep_status'],
    ':ep_message' => $result['ep_message'],
    ':ep_entity' => $easypayConfig['entity'],
    ':ep_reference' => $result['ep_reference'],
    ':ep_k1' => $result['ep_k1'],
    ':t_key' => $tKey,
    ':o_obs' => $obs,
    ':o_mobile' => $mobile,
    ':o_email' => $email,
    ':ep_value' => $value,
    ':ep_link' => $result['ep_link'],
    ':ep_link_rp_dd' => $result['ep_link_rp_dd'],
    ':ep_link_rp_cc' => $result['ep_link_rp_cc'],
    ':ep_periodicity' => $result['ep_periodicity']
]);

// Now redirect the user to Easypay's gateway
header('Location: ' . $result['ep_link_rp_dd']);
