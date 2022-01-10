<?php

namespace App\Libraries;

use ParagonIE\EasyRSA\KeyPair;

class Key
{

    public static function getPublicKey()
    {
        return KeyPair::generateKeyPair()->getPublicKey();
    }

    public static function getPrivateKey()
    {
        return KeyPair::generateKeyPair()->getPrivateKey();
    }

    const PRIVATE = <<<EOD
    -----BEGIN RSA PRIVATE KEY-----
    MIICWwIBAAKBgHplxzU7WGVDrRT0tmKmD/9I2ncmhYg0WixKghWKEr/Q9ee95rYJ
    mijiSRiWFug+0mhMHIYb8YKhAdg8n43Sd+9ACyncQY6BA9b2Gw5D4MKQjxXzmvUB
    5ToWlp83YmlUrfme/O4fEecRtTG5/jDTeHbpB1vYFrIvq3WnxQCs8QKJAgMBAAEC
    gYBFRI49eO1ouakdP/Rr1bEd9zvzzHArif0yLaR6zh4YQgi4csc7ZCnDU3Ssnlwu
    aUcoUVKfLvc5xybFGmHtoBvRFEtMHlgHmmFiddR5DSqRugomwPNbs3xjB0/ZSEfw
    4ojydyz2kQqHNIDQfAYVGAAm0ucVNSnQA/34Bmd0caMrxQJBANxqOTMVY0o+c9JX
    mvHfvEq6nmMfcToIArPE7TGIUsf78exn4azmWfTAQ5rxiNzOip+vKKIzORFu8YY5
    cbkbCKsCQQCOKHwjbqb7w2L+Rwe3OOD37KIr8xC2mc/KjgxxOs1cbb7V/Pb60Irg
    ZUzJpKa07KYd/6ZDdVhuGmsn5+DATkmbAkEAq0Bg1r7MWTfytz/XpAuoeQtL2kno
    qCTnLJNZkv2PC9BFo98GaVbEF7R2EmGNa7mR3QWzdWqE8XWYdCgXorFNZwJAIdGh
    zrAZS5Ws7D8rp7wBURnbbscxd69Zzp9CeIF7r3xwROocO4j3MPEIdoQUIMCXuFVE
    UZIOCouAaIryXe2B9wJATt93fMQY7/68HuINkPyEYaAl4jWRwywqzHJC37vdTePp
    ulHoHDr8vnO1ub84A3/T/HVDcL0Dq9JJBdlss0JgbQ==
    -----END RSA PRIVATE KEY-----
    EOD;

    const PUBLIC = <<<EOD
    -----BEGIN PUBLIC KEY-----
    MIGeMA0GCSqGSIb3DQEBAQUAA4GMADCBiAKBgHplxzU7WGVDrRT0tmKmD/9I2ncm
    hYg0WixKghWKEr/Q9ee95rYJmijiSRiWFug+0mhMHIYb8YKhAdg8n43Sd+9ACync
    QY6BA9b2Gw5D4MKQjxXzmvUB5ToWlp83YmlUrfme/O4fEecRtTG5/jDTeHbpB1vY
    FrIvq3WnxQCs8QKJAgMBAAE=
    -----END PUBLIC KEY-----
    EOD;
}
