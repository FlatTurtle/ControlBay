<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require_once APPPATH . 'libraries/phpass-0.3/PasswordHash.php';
class PHPass_lib
{
    const HASH_STRENGTH = 8;
    const PORTABLE_HASH = true;

    function hashPassword($pass){
        $phpass = new PasswordHash(self::HASH_STRENGTH, self::PORTABLE_HASH);
        return $phpass->HashPassword($pass);
    }

    function checkPassword($given, $stored){
        $phpass = new PasswordHash(self::HASH_STRENGTH, self::PORTABLE_HASH);
        return $phpass->CheckPassword($given, $stored);
    }
}
