<?php


namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Modules\JwtToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;
use Nowakowskir\JWT\TokenEncoded;


/**
 * Есть access token и refresh token. Refresh работает всего 5 минут,
 * истекает и  через access токен выдается новый refresh, а
 * access token истекает через 30 минут.
 *
 * Class LoginApiController
 * @package App\Http\Controllers\Api\Auth
 */
class LoginApiController
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
                'email'=>'required',
                'password'=>'required'
            ]
        );

        if($validator->fails()){
            return [
              'status'=>false,
              'errors'=>$validator->getMessageBag()
            ];
        }

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $accessToken =  JwtToken::getAccessToken($email, $password, 30)->toString();
            $refreshToken = JwtToken::getRefreshToken($accessToken, 5)->toString();


            return [
              'status'=>true,
              'tokens'=>[
                  'access'=>$accessToken,
                  'refresh'=>$refreshToken
              ]
            ];

        } catch (\Exception $ex) {
            return [
                'status'=>false,
                'errors'=>[
                   'error'=>$ex->getMessage()
                ]
            ];
        }

    }


    public function getRefreshToken(Request $request)
    {
        $accessToken = $request->input('accessToken');

        $validator = Validator::make($request->all(), [
            'accessToken'=>'required'
        ]);

        if($validator->fails()){
            return [
                'status'=>false,
                'errors'=>$validator->getMessageBag()
            ];
        }

        try{
            $refreshToken = JwtToken::getRefreshToken($accessToken, 5)->toString();

        }
        catch (\Exception $ex){
            return [
                'status'=>false,
                'errors'=>[
                    'error'=>$ex->getMessage()
                ]
            ];
        }

        return [
            'status'=>true,
            'refreshToken'=>$refreshToken
        ];

    }
}
