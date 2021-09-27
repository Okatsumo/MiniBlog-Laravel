<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nowakowskir\JWT\Exceptions\TokenExpiredException;
use Nowakowskir\JWT\TokenEncoded;

class Jwt
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'refreshToken'=> 'required',
        ]);

        $refreshToken = $request->input('refreshToken');

        if ($validator->fails()) {
            return abort(401, 'Вы не авторизованы');
        }

        $privateKey = config('jwt.privateKey');
        $tokenEncoded = new TokenEncoded($refreshToken);

        try {
            if (!$tokenEncoded->validate($privateKey, \Nowakowskir\JWT\JWT::ALGORITHM_HS512)) {
                return abort(401, 'Ошибка авторизации');
            }
        } catch (TokenExpiredException $ex) {
            return abort(401, 'Ошибка авторизации');
        }

        $payLoad = $tokenEncoded->decode($privateKey, \Nowakowskir\JWT\JWT::ALGORITHM_HS512)->getPayload();
        $user = User::find($payLoad['id'])->first();

        if ($user['admin']) {
            return $next($request, $user);
        } else {
            return abort(401, 'У вас недостаточно прав!');
        }
    }
}
