<?php

require_once 'vendor/autoload.php';

use Nimiq\Utils\SignatureUtils;
use Nimiq\Utils\AddressUtils;

$message = 'Sign me, baby!';
$signature = sodium_hex2bin('6705860591cbac6518f8e84c2aa00f30230fbf02d87312a9f9b2ffa07b76a75a55e32b08f633dcd365ca7ad46385a3dda293dac44fcad65f1ae73fea9b29b608');
$sign_public = sodium_hex2bin('873279e12d5af18c4e899a781e55711f7910ed8ddb85b2179ece38a570253527');

echo 'Is valid: '; var_dump(SignatureUtils::verify_message($signature, $message, $sign_public));
echo 'Address:  ' . AddressUtils::pubkey2address($sign_public) . "\n";
