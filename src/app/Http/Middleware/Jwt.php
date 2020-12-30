<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Modules\JwtToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nowakowskir\JWT\TokenEncoded;

class Jwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $refreshToken = $request->input('refreshToken');


        $validator = Validator::make($request->all(), [
           'refreshToken'=>'required'
        ]);

        if($validator->fails()){
            return redirect('/');
        }

        $privateKey = 'secret';
        $tokenEncoded = new TokenEncoded($refreshToken);

        try{
            if(!$tokenEncoded->validate($privateKey, \Nowakowskir\JWT\JWT::ALGORITHM_HS512)){
                return redirect('/');
            };
        }
        catch (Exception $ex){
            return redirect('/');
        }

        $payLoad = $tokenEncoded->decode($privateKey, \Nowakowskir\JWT\JWT::ALGORITHM_HS512)->getPayload();
        $user = User::find($payLoad['id'])->first();



        if($user['admin']){
            return $next($request);
        }
        else{
            return redirect('/');
        }
    }
}
