<?php
/**
 * Easypay Configuration File
 * @package 	Easypay-PHP
 * @subpackage	api
 * @version 	1.0.0
 * @author 		Ricardo Lopes
 * @copyright	Easypay
 * @license		GPL v2
 */

/**
 * Define the Request reference API
 * @var array
 */
$ep_conf['request_reference'] = 'api_easypay_01BG.php';

/**
 * Define the Request payment API 
 * @var array
 */
$ep_conf['request_payment'] = 'api_easypay_05AG.php';

/**
 * Define the Request Payment Data API
 */
$ep_conf['request_payment_data'] = 'api_easypay_03BG.php';

/**
 * Define the Request Payment List Data
 */
$ep_conf['request_payment_list'] = 'api_easypay_040BG1.php';

/**
 * Define the Request Recurring Payment
 */
$ep_conf['request_payment_list'] = 'api_easypay_07BG.php';

/**
 * Define the Request a Verification of a Transaction Key
 */
$ep_conf['request_transaction_key_verification'] = 'api_easypay_23AG.php';

/**
 * Define Test Environment
 */
$ep_conf['test_server'] = 'http://test.easypay.pt/_s/';

/**
 * Define Production Environment
 */
$ep_conf['production_server'] = 'https://www.easypay.pt/_s/';

/**
 * Define Country
 */
$ep_conf['country'] = 'PT';

/**
 * Define Language
 */
$ep_conf['language'] = 'PT';

/**
 * Define reference type
 */
$ep_conf['ref_type'] = 'auto';

/**
 * Define user
 */
$ep_conf['user'] = '';

/**
 * Define CIN
 */
$ep_conf['cin'] = '';

/**
 * Define Entity
 */
$ep_conf['entity'] = '';

/**
 * Define code
 */
$ep_conf['code'] = false;

/**
 * Define mode to use, true to use live transactions
 */
$ep_conf['live_mode'] = false;