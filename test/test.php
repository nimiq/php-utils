<?php

require_once 'vendor/autoload.php';

/**
 * SignatureUtils
 * AddressUtils
 */

use Nimiq\Utils\SignatureUtils;
use Nimiq\Utils\AddressUtils;

$message = 'Sign me, baby!';
$signature = sodium_hex2bin('6705860591cbac6518f8e84c2aa00f30230fbf02d87312a9f9b2ffa07b76a75a55e32b08f633dcd365ca7ad46385a3dda293dac44fcad65f1ae73fea9b29b608');
$sign_public = sodium_hex2bin('873279e12d5af18c4e899a781e55711f7910ed8ddb85b2179ece38a570253527');

echo 'Is valid: '; var_dump(SignatureUtils::verify_message($signature, $message, $sign_public));
echo 'Address:  ' . AddressUtils::pubkey2address($sign_public) . "\n";


/**
 * RpcUtils
 */

use Nimiq\Utils\RpcUtils;

$target = 'https://hub.nimiq-testnet.com';
$id = 1234;
$returnUrl = 'https://shop.nimiq-testnet.com';
$command = 'checkout';
$request = [
    'recipient' => 'NQ07 A38E G81P 3QKU G1R1 6JT9 BTAR R8P8 FMFV',
    'value' => 4500e5,
    'extraData' => 'Hello World!',
];
$responseMethod = 'post';

$redirectUrl = RpcUtils::prepareRedirectInvocation( $target, $id, $returnUrl, $command, [ $request ], $responseMethod );

echo 'Redirect URL: ' . $redirectUrl . "\n";
