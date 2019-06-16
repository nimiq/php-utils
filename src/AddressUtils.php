<?php

declare(strict_types = 1);

namespace Nimiq\Utils;

class Base32 extends \Tuupola\Base32
{
    const NIMIQ = '0123456789ABCDEFGHJKLMNPQRSTUVXY';

    public function __construct()
    {
        parent::__construct([
            'characters' => self::NIMIQ,
            'padding' => false,
        ]);
    }
}

class AddressUtils
{
    const CCODE = 'NQ';

    public static function pubkey2address(string $public_key, bool $with_spaces = true): string
    {
        $address_bytes = substr(sodium_crypto_generichash($public_key), 0, 20);
        return self::to_user_friendly_address($address_bytes, $with_spaces);
    }

    // PHP port of Nimiq.Address.prototype.toUserFriendlyAddress()
    // https://github.com/nimiq/core-js/blob/master/src/main/generic/consensus/base/account/Address.js#L141
    private static function to_user_friendly_address(string $bytes, bool $with_spaces): string
    {
        $address = (new Base32())->encode($bytes);
        $check = substr('00' . (98 - self::iban_checksum($address . self::CCODE . '00')), -2);
        $res = self::CCODE . $check . $address;
        if ($with_spaces) $res = chunk_split($res, 4, ' ');
        return $res;
    }

    // PHP port of Nimiq.Address._ibanCheck()
    // https://github.com/nimiq/core-js/blob/master/src/main/generic/consensus/base/account/Address.js#L123
    private static function iban_checksum(string $str): int
    {
        $num = implode('', array_map(function($c) {
            $code = ord(strtoupper($c));
            return $code >= 48 && $code <= 57 ? $c : $code - 55;
        }, str_split($str)));
        $tmp = '';

        for ($i = 0; $i < ceil(strlen($num) / 6); $i++) {
            $tmp = intval($tmp . substr($num, $i * 6, 6)) % 97;
        }

        return $tmp;
    }
}
