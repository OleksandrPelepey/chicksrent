<?php
/**
 * Created by PhpStorm.
 * User: Oleksandr
 * Date: 12.08.2018
 * Time: 17:58
 */

namespace AppBundle\Utils;


class TokensGenerator
{
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}