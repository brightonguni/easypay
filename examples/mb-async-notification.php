<?php

/**
 * The following code demonstrates how to use async notifications for MB payments
 * This code uses API 040BG1, that's used to fetch the payment details of all payment types.
 * Here, specifically, we'll use the code to process only MB payments.
 *
 * Note that you should call this method in a cronjob or schedule task on a regular interval
 * (every day or every 12 hours).
 * How to test this? Use mb-create-reference.php to create a reference. Go to easypay test backoffice
 * and "pay" that reference. Than call this URL and you'll see a new record on easypay_payments.
 *
 * For further details check this post (Portuguese):
 * https://geekalicious.pt/blog/pt/php/integracao-servico-pagamentos-easypay-multibanco-mb-atm#easypay-async-payment-notification
 */

// Set error reporting for demo purposes
error_reporting(E_ERROR);

// Load autoload classes
require_once 'vendor/autoload.php';
require_once 'config.php';

// Let's go ahead and call Fetch all payments. We'll fetch the payments for a specific date
// Be sure to set the second parameter to true.
$easypay = new Easypay\EasyPay($easypayConfig);
$payments = $easypay->fetchAllPayments([
    'o_list_type' => 'date',
    'o_ini'       => '2017-11-04',
    'o_last'      => '2017-11-04',
], true);

// Easypay throws an error when there are no results, and it's not useful to log this kind of info
if ($payments['ep_status'] === 'err1'
    && strpos($payments['ep_message'], ' - query with no records') !== false
) {
    var_dump($easypay->getLogs());
    // There are no payments for the request
    echo 'no results';
    die();
}

// Check if there's any real error
if ($payments['ep_status'] === 'err1') {
    var_dump($paymentInfo);
    throw new Exception('Something went wrong fetching payments');
}

// Create the DB conn
$conn = new PDO('mysql:host=' . $dbConfig['host']. ';dbname=easypay_examples', $dbConfig['user'], $dbConfig['pass']);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ok, now we'll just loop through the payments and update our DB accordingly
foreach ($payments['ref_detail'] as $payment) {
    // Skip all payments not MB
    if ($payment['ep_payment_type'] !== 'MB') {
        continue;
    }

    // Find the easypay_references row based on the payment's ep_reference
    $stmt = $conn->prepare('SELECT * FROM easypay_references WHERE ep_reference = :ep_reference');
    $stmt->execute([':ep_reference' => $payment['ep_reference']]);
    $easypayReference = $stmt->fetch();

    // If the reference doesn't exist, move along. Beware, there are some times
    // where some client types the wrong reference or entity and your system
    // will receive a payment for something that doesn't exist
    if (!is_array($easypayReference) || empty($easypayReference)) {
        continue;
    }

    // Ok, now that we're sure the reference was created by our system, let's create a payment
    // and do whatever our application needs.
    $stmt = $conn->prepare("
        INSERT INTO easypay_payments (easypay_reference_id, ep_doc, ep_cin, ep_user, ep_status, ep_message,
            ep_entity, ep_reference, ep_value, ep_date, ep_payment_type, ep_value_fixed, ep_value_var,
            ep_value_tax, ep_value_transf, ep_date_transf, t_key)
        VALUES (:easypay_reference_id, :ep_doc, :ep_cin, :ep_user, :ep_status, :ep_message,
            :ep_entity, :ep_reference, :ep_value, :ep_date, :ep_payment_type, :ep_value_fixed, :ep_value_var,
            :ep_value_tax, :ep_value_transf, :ep_date_transf, :t_key)
    ");
    $stmt->execute([
        ':easypay_reference_id' => $easypayReference['id'],
        ':ep_doc' => $payment['ep_doc'],
        ':ep_cin' => $payment['ep_cin'],
        ':ep_user' => $payment['ep_user'],
        ':ep_status' => $payment['ep_status'],
        ':ep_message' => $payment['ep_message'],
        ':ep_entity' => $payment['ep_entity'],
        ':ep_reference' => $payment['ep_reference'],
        ':ep_value' => $payment['ep_value'],
        ':ep_date' => $payment['ep_date'],
        ':ep_payment_type' => $payment['ep_payment_type'],
        ':ep_value_fixed' => $payment['ep_value_fixed'],
        ':ep_value_var' => $payment['ep_value_var'],
        ':ep_value_tax' => $payment['ep_value_tax'],
        ':ep_value_transf' => $payment['ep_value_transf'],
        ':ep_date_transf' => $payment['ep_date_transf'],
        ':t_key' => $payment['t_key'],
    ]);
}
