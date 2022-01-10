<?php

namespace App\Libraries;

use ParagonIE\EasyRSA\EasyRSA;
use ParagonIE\EasyRSA\PrivateKey;
use ParagonIE\EasyRSA\PublicKey;

class RSA
{
    static function encrypt(String $text)
    {
        return EasyRSA::encrypt($text, new PublicKey(Key::PUBLIC));
    }

    static function decrypt(String $text)
    {
        return EasyRSA::decrypt($text, new PrivateKey(Key::PRIVATE));
    }
}
