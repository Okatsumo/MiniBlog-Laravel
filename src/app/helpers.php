<?php
namespace App\Helpers;

use Nowakowskir\JWT\TokenEncoded;

function getUserFromRefreshToken($token){
    $token = new TokenEncoded($token);
    return $token->decode()->getPayload();
}
