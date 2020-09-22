<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class TokenController extends Controller
{
    public static $payload;

    public static function isAuthorized()
    {
        if (self::getUrlToken()) {
            $token = self::getUrlToken();
        } else {
            $token = Cookie::get('token');
        }

        if ($token != true) {
            return false;
        }

        $tokenParts = explode('.', $token);

        self::$payload = json_decode(base64_decode($tokenParts[1]));

        $signature = self::setSignature($tokenParts[0], $tokenParts[1], env('SECRET'));

        if ($signature == $tokenParts[2]) {
            setcookie('token', $token, time() + 3600);
            return true;
        }

        return false;
    }

    public static function getSegmentContent($payload)
    {
        $payload = base64_decode($payload);
        return json_decode($payload);
    }

    public static function setSignature($header, $payload, $secret): string
    {
        $signature = hash_hmac('sha256', "{$header}.{$payload}", $secret);
        return base64_encode($signature);
    }

    private static function getUrlToken()
    {
        if (isset($_GET['token'])) {
            return $_GET['token'];
        }

        return false;
    }

    public static function isAdmin()
    {
        return self::$payload->type == 'admin';
    }

    public static function onlyAdmin()
    {
        if (!self::isAdmin()) {
            abort(403);
        }
    }

    public function isAdminLocal()
    {
        $number =  self::$payload->number;
        $user = User::find('number', $number)->get();

        if($user->count()) {
            return true;
        }

        return false;
    }

}
