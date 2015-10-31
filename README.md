# chippyash/Crypt

## Quality Assurance

Certified for PHP 5.3+

[![Build Status](https://travis-ci.org/chippyash/Crypt.svg?branch=master)](https://travis-ci.org/chippyash/Crypt)
[![Coverage Status](https://coveralls.io/repos/chippyash/Crypt/badge.svg?branch=master&service=github)](https://coveralls.io/github/chippyash/Crypt?branch=master)
[![Code Climate](https://codeclimate.com/github/chippyash/Crypt/badges/gpa.svg)](https://codeclimate.com/github/chippyash/Crypt)

The above badges represent the current development branch.  As a rule, I don't push
 to GitHub unless tests, coverage and usability are acceptable.  This may not be
 true for short periods of time; on holiday, need code for some other downstream
 project etc.  If you need stable code, use a tagged version. Read 'Further Documentation'
 and 'Installation'.
 
## What?

Provides a simple encryption capability

## Why?

Encryption is not generally straight forward.  This library tries to ease the pain.
At the present time, a single encryption method is provided, others will follow.

As the majority of web encryption requires that you are able to store the value in
cookies, database tables etc, by default the encrypted value is encoded using Base 64.
You can switch that off if required.

## How

The encryption methods supported by this library all require an encryption key.  You can
generate this (on a \*nix based system at least,) by running `uuidgen`

You need to supply an encryption method to the Crypt class.  At present one is provided
for you, Rijndael256, but you can implement others by implementing the MethodInterface.

The supplied Rijndael256 method is capable of encrypting any PHP serializable object.

<pre>
use Chippyash\Crypt\Crypt;
use Chippyash\Crypt\Crypt\Method\Rijndael256;
use chippyash\Type\String\StringType;
use chippyash\Type\BoolType;

$crypt = new Crypt(new StringType('my seed value'), new Rijndael256());
 
$encrypted = $crypt->encrypt($someValue);
$decrypted = $crypt->decrypt($encrypted);
</pre>

By default the encrypted value is encoded using Base64.  You can get the raw value thus:

<pre>
$encrypted = $crypt->encrypt($someValue, new BoolType(false));
</pre>

If you are not using Base64 encoding to encrypt, you need to switch it off in the decrypt as well:

<pre>
$decrypted = $crypt->decrypt($encrypted, new BoolType(false));
</pre>

By default, on \*nix based machines, the seed that you supply on construction is mixed
with the mac address of the machine that the code is running on, if it can be found.  This ensures that only
that machine can encrypt and decrypt a given value.  If you do not want this, say for instance
that you are running on load balanced machines and storing in a central database, you can
switch it off:

<pre>
$crypt = new Crypt(new StringType('my seed value'), new Rijndael256());
$crypt->setUseMacAddress(new BoolType(false));
</pre>
 
As an example of how you can wrap other libraries into this, I've supplied the Blowfish
method, which requires the Zend Crypt library.  

<pre>
use Chippyash\Crypt\Crypt\Method\Blowfish;

$crypt = new Crypt(new StringType('my seed value'), new Blowfish());
</pre>

If you want to do very serious cryptography
the Zend Crypt library is a good starting point.  If you just want sound and simple, use
this library.  You will need to  use the now default `composer install` to bring in dev 
dependencies to use the Zend stuff. If you like it then add `"zendframework/zend-crypt": "~2.5.0"`
to your project composer 'requires' statement;

## Further documentation

Please note that what you are seeing of this documentation displayed on Github is
always the latest dev-master. The features it describes may not be in a released version
 yet. Please check the documentation of the version you Compose in, or download.

[Test Contract](https://github.com/chippyash/Crypt/blob/master/docs/Test-Contract.md) in the docs directory.
For Symfony users, you'll also find an example DIC definition in the docs directory

### UML

![class diagram](https://github.com/chippyash/Crypt/blob/master/docs/crypt-classes.png)

## Changing the library

1.  fork it
2.  write the test
3.  amend it
4.  do a pull request

Found a bug you can't figure out?

1.  fork it
2.  write the test
3.  do a pull request

NB. Make sure you rebase to HEAD before your pull request

Or - raise an issue ticket.

## Where?

The library is hosted at [Github](https://github.com/chippyash/Crypt). It is
available at [Packagist.org](https://packagist.org/packages/chippyash/crypt)

### Installation

Install [Composer](https://getcomposer.org/)

#### For production

<pre>
    "chippyash/crypt": "~1.0.0"
</pre>

Or to use the latest, possibly unstable version:

<pre>
    "chippyash/crypt": "dev-master"
</pre>

To use the Zend cryptography lib under my lib add the `"zendframework/zend-crypt": "~2.5.0"`
line to your composer require section.

#### For development

Clone this repo, and then run Composer in local repo root to pull in dependencies

<pre>
    git clone git@github.com:chippyash/Crypt.git Crypt
    cd Crypt
    composer install
</pre>

To run the tests:

<pre>
    cd Crypt
    vendor/bin/phpunit -c test/phpunit.xml test/
</pre>


## License

This software library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

This software library is Copyright (c) 2015, Ashley Kitson, UK

This software library contains code items that are derived from other works: 

None of the contained code items breaks the overriding license, or vice versa,  as far as I can tell. 
So as long as you stick to GPL V3+ then you are safe. If at all unsure, please seek appropriate advice.

If the original copyright owners of the derived code items object to this inclusion, please contact the author.

A commercial license is available for this software library, please contact the author. 
It is normally free to deserving causes, but gets you around the limitation of the GPL
license, which does not allow unrestricted inclusion of this code in commercial works.

## Thanks

I didn't do this by myself. I'm deeply indebted to those that trod the path before me.
 
The Rijndael256 cryptography method is based on code created by Andrew Johnson. I can find
no current location or link for Andrew, so if you know him (he created Cryptastic,) please
do let me know.

## History

V1.0.0 Initial Release
