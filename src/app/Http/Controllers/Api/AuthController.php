<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function register()
    {
        $validator = Validator::make(request()->all(),[
            'username'=>'required|max:255',
            'email'=>'email|required|max:255|',
            'password'=>'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->getMessageBag()
            ], 422);
        }

        if (User::whereEmail(request('email'))->first()) {
            return response()->json([
                'message' => 'user with mail already exists',
                'status' => 422
            ], 422);
        }

        if (User::where('name', '=', request('username'))->first()) {
            return response()->json([
                'message' => 'User with username already exists',
                'status' => 422
            ], 422);
        }

        $user = new User();
        $user->name = request('username');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->password = bcrypt(request('password'));
        $user->save();

        return response()->json(['status' => 201]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function login(): \Symfony\Component\HttpFoundation\Response
    {
        $user = User::whereEmail(request('username'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

        if (!Hash::check(request('password'), $user->password)) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        if (!$client) {
            return response()->json([
                'message' => 'Laravel Passport is not setup properly.',
                'status' => 500
            ], 500);
        }

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => request('username'),
            'password' => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

        $data = json_decode($response->getContent());

        return response()->json([
            'token' => $data->access_token,
            'user' => $user,
            'status' => 200
        ]);
    }

    public function logout(){
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }

    /**
     * @return Authenticatable|null
     */
    public function getUser(): ?Authenticatable
    {
        return auth()->user();
    }

}
