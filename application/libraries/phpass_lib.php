<?php
/**
 * Proxy to the phpass lib
 *
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require_once APPPATH . 'libraries/phpass-0.3/PasswordHash.php';
class PHPass_lib
{
    const HASH_STRENGTH = 8;
    const PORTABLE_HASH = true;

    /**
     * Hash a password with phpass
     *
     * @param $pass the password to hash
     * @return string the hashed password
     */
    function hashPassword($pass){
        $phpass = new PasswordHash(self::HASH_STRENGTH, self::PORTABLE_HASH);
        return $phpass->HashPassword($pass);
    }

    /**
     * Check if a password is correct
     *
     * @param $given the password the client gave you (plain)
     * @param $stored the database password (hashed)
     * @return bool true if the password is correct
     *              false if not
     */
    function checkPassword($given, $stored){
        $phpass = new PasswordHash(self::HASH_STRENGTH, self::PORTABLE_HASH);
        return $phpass->CheckPassword($given, $stored);
    }
}
