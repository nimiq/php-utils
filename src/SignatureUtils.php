<?php

declare(strict_types = 1);

namespace Nimiq\Utils;

class SignatureUtils
{
    const MSG_PREFIX = "\x16Nimiq Signed Message:\n";

    public static function verify(string $signature, string $data, string $public_key): bool
    {
        return sodium_crypto_sign_verify_detached($signature, $data, $public_key);
    }

    public static function verify_message(string $signature, string $message, string $public_key): bool
    {
        $msg_length = strlen($message);
        $data = self::MSG_PREFIX . $msg_length . $message;
        $hash = hash('sha256', $data, true);

        return self::verify($signature, $hash, $public_key);
    }
}
