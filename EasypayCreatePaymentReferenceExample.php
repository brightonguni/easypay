<?php
/**
 * Easypay Create Reference Example
 * @category 	Example File
 * @package 	Easypay-PHP
 * @version 	2.0.0
 * @author      Ricardo Lopes
 * @copyright	Easypay
 * @license		GPL v2
 */
require_once('./api/Easypay.php');

/**
 * Define the easypay access parameters
 * Please replace this parameters with your own
 * This parameters can also be defined in the easypay api configuration file
 * in api/Easypay-config.php
 * @var array
 */
$easypay_params['user'] = 'TESTE300810';
$easypay_params['cin'] = '3016';
$easypay_params['entity'] = '10611';
$easypay_params['name'] = '';
$easypay_params['description'] = '';
$easypay_params['observation'] = '';
$easypay_params['mobile'] = '';
$easypay_params['email'] = '';
$easypay_params['value'] = '10.01';
$easypay_params['key'] = '007';


//Uncomment if you need to validate by code code
//$easypay_params['code'] = '';

/**
 * Create a new Easypay Object
 * @var Easypay
 */
$easypay = new Easypay($easypay_params);

//set mode to either test or production.
//This can be defined in the config file
$easypay->set_live(false);

$reference = $easypay->createReference();

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Easypay Reference Creation Test</title>
    </head>
    <body>
        <div runat="server" id="ep_box" style="float: left; text-align:center; border: 1px solid #ddd; border-radius: 5px; width: 210px; min-height: 70px; padding:10px;" >
            <img src="http://store.easyp.eu/img/easypay_logo_nobrands-01.png" style="height:40px; margin-bottom: 10px;" title="Se quer pagar uma referência multibanco utilize a easypay" alt="Se quer pagar uma referência multibanco utilize a easypay" />
            <div style="width: 190px; float: left; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color:#eee;">
                <img src="http://store.easyp.eu/img/MB_bw-01.png" />
                
                <div style="padding: 5px; padding-top: 10px; clear: both;">
                    <span style="font-weight: bold;float: left;">Entity:</span>
                    <span style="color: #0088cc; float: right"><?= $reference['ep_entity'] ?> (Easypay)</span>
                </div>

                <div style="padding: 5px;clear: both;">
                    <span style="font-weight: bold;float: left;">Reference:</span>
                    <span style="color: #0088cc; float: right"><?= wordwrap( $reference['ep_reference'], 3, ' ', true ) ?></span>
                </div>
                
                <div style="padding: 5px; clear: both;">
                    <span style="font-weight: bold;float: left;">Value:</span>
                    <span style="color: #0088cc; float: right"><?= $reference['ep_value'] ?> &euro;</span>
                </div>
            </div>
            <div style="margin-top: 10px; width: 190px; float: left; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color:#eee;">
                <a href="<?= $reference['ep_link'] ?>">
                    <img src="http://store.easyp.eu/img/visa_mc_bw-01.png" />
                    <div style="padding: 5px; padding-top: 10px; clear: both;" >
                        <span style="color: #0088cc; text-decoration: none;">Pay Now!</span>
                    </div>
                </a>
            </div>
            <? if($reference['ep_boleto_link']): ?>
            <div style="margin-top: 10px; width: 190px; float: left; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color:#eee;">
                <a href="<?= $reference['ep_boleto_link'] ?>">
                    <img src="http://store.easyp.eu/img/bb_bw-01.png" />
                    <div style="padding: 5px; padding-top: 10px; clear: both;" >
                        <span style="color: #0088cc; text-decoration: none;">Pay Now!</span>
                    </div>
                </a>
            </div>
            <? endif; ?>
        </div>  
    </body>
</html>

    