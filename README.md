# Nimiq PHP Utilities

This is a collection of utility classes for working with Nimiq primitives in PHP. It is not meant to enable a Nimiq network node in PHP, but rather to verify signatures, derive and validate addresses and to work with serialized primitives in a PHP environment. This collection is planned to grow over time when the need arises or by additions from the community.

## Installation

The Nimiq PHP Utilities are availabe via the [Packagist package registry](https://packagist.org/packages/nimiq/utils) and can be installed with [Composer](https://getcomposer.org):

```bash
composer require nimiq/utils
```

*Please note that PHP >= 7.2 with an installed `sodium` extention is required to use these utilities. Please make sure that you have your operating system's equivalent of the `php-sodium` package installed or that you activate the sodium extension in your hosting's PHP settings.*

## Usage

The utility classes are available in the `Nimiq\Utils` namespace:

```php
use Nimiq\Utils\AddressUtils;
use Nimiq\Utils\SignatureUtils;
```

To generate byte-encoded strings from HEX representations, you can use [`sodium_hex2bin()`](https://paragonie.com/book/pecl-libsodium/read/03-utilities-helpers.md#hex2bin), for example:

```php
$public_key = sodium_hex2bin('873279e12d5af18c4e899a781e55711f7910ed8ddb85b2179ece38a570253527');
```

### AddressUtils

```php
AddressUtils::pubkey2address(string $public_key[, bool $with_spaces = true]): string
```

Convert a public key into a Nimiq userfriendly address.

- `$public_key` A byte-encoded string of length 32 representing a Nimiq public key.
- `$with_spaces` [optional] Set to FALSE to output the address without spaces.

### SignatureUtils

```php
SignatureUtils::verify(string $signature, string $data, string $public_key): bool
```

Verify a signature for the given data and public key.

- `$signature` A byte-encoded string representing a Nimiq signature.
- `$data` A byte-encoded string representing the data that the signature should be verified for.
- `$public_key` A byte-encoded string representing the Nimiq public key of the signer.

```php
SignatureUtils::verify_message(string $signature, string $message, string $public_key): bool
```

Verify a message signature for the given message and public key.

*Message signatures are different from regular signatures in that the message is prefixed and hashed before being signed. This method applies these same manipulations to the message before verifying the signature.*

- `$signature` A byte-encoded string representing a Nimiq message signature.
- `$message` The plain-text representation of the message that the signature should be verified for.
- `$public_key` A byte-encoded string representing the Nimiq public key of the signer.

## Development

The sodium cryptographic methods are best documented in the developer's documentation: https://paragonie.com/book/pecl-libsodium.

### Setup

1. Use PHP >= 7.2
2. [Install the `sodium` extension](https://paragonie.com/book/pecl-libsodium/read/00-intro.md#installing-extension)
3. Verify that you have the sodium extension correctly installed by running `php test/version_check.php` - if it displays the extension's version numbers, everything is good to go

### Testing

To execute a (minimal) test of these utilities' functionality, run:

```bash
php test/test.php
```

The expected output is:

```
Is valid: bool(true)
Address:  NQ03 VDL0 TSF5 CFNX VNCL 4MGK 0BX7 150E VMXA
```
 
