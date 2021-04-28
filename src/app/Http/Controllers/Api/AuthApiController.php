<?php


namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Modules\JwtToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
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
class AuthApiController
{

    public function register(Request $request): array
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);

        if ($validator->fails()){
            return [
                'status' => false,
                'errors' => $validator->getMessageBag()
            ];
        }

        try{
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password')) ;
            $user->save();

            return [
                'status' => true,
                'user'=>$user
            ];
        }
        catch (QueryException $ex){
            if($ex->errorInfo[1] == "1062")
                return [
                'status' => false,
                'error'=>'Пользователь с таким логином или паролем уже существует!'
            ];
        }
    }



    public function login(Request $request): array
    {
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
            $accessToken =  JwtToken::getAccessToken($email, $password, 30);
            $refreshToken = JwtToken::getRefreshToken($accessToken->toString(), 5);


            return [
              'status'=>true,
              'tokens'=>[
                  'access'=>$accessToken->toString(),
                  'refresh'=>$refreshToken->toString()
              ],
              'admin'=>(bool)$accessToken->decode()->getPayload()['admin']
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
