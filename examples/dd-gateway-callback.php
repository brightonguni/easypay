<?php

/**
 * The following code demonstrates what happens once the user has finished
 * the process on Easypay's gateway.
 * Before you check this code, you should take a look at dd-create-reference.php
 *
 * Easypay should send a few $_GET parameters in the request, such as:
 *  `r`: Represents the ep_reference
 *  `e`: Represents the ep_entity
 *  `v`: The ep_value
 *  `s`: The result of the operation on Easypay's gateway (status)
 *  `ep_k1`: A key that identifies this reference - this will be the AdC (Autorização Débito em conta)
 */

// Set error reporting for demo purposes
error_reporting(E_ERROR);

// Load autoload classes
require_once 'vendor/autoload.php';
require_once 'config.php';


if (empty($_GET['r']) || empty($_GET['e']) || empty($_GET['v']) || empty($_GET['s'])
    || empty($_GET['ep_k1']) || $_GET['s'] !== 'ok') {
    // There was an error on Easypay's end
    // Should probably log the error and eventually you can delete the reference
    // die(var_dump($_GET));

    // Delete the reference from easypay_references and change the play of the user
    if (!empty($_GET['r']) && !empty($_GET['ep_k1'])) {
        // Here you can delete the easypay_references row that you've created
    }
    // And eventually notify the end-user and/or administrator that something went wrong

} else {
    // Awesome, everything went ok.
    // If you want, you can already request a DD payment here (calling 05AG API)
    // @todo: Add request payment code
}


