<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginNotification;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function register(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'username'=> [
                'required',
                'max:255',
            ],
            'email'=> [
                'required',
                'max:255',
                'regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
            ],
            'password'=> 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        if (User::whereEmail(request('email'))->first()) {
            return response()->json([
                'message' => 'user with mail already exists',
                'status'  => 422,
            ], 422);
        }

        if (User::where('name', '=', request('username'))->first()) {
            return response()->json([
                'message' => 'User with username already exists',
                'status'  => 422,
            ], 422);
        }

        $user = new User();
        $user->name = request('username');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->save();

        event(new Registered($user));

        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        if (!$client) {
            return response()->json([
                'message' => 'Laravel Passport is not setup properly.',
                'status'  => 500,
            ], 500);
        }

        $data = [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => request('email'),
            'password'      => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);
        $oauth = app()->handle($request);
        $data = json_decode($oauth->getContent());

        return response()->json([
            'status' => 201,
            'token'  => $data->access_token,
            'user'   => $user,
        ]);
    }

    /**
     * @throws Exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(): \Symfony\Component\HttpFoundation\Response
    {
        $user = User::whereEmail(request('username'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status'  => 422,
            ], 422);
        }

        if ($user->banned) {
            return response()->json([
                'message' => 'The account is blocked',
                'status'  => 403,
            ], 403);
        }

        if (!Hash::check(request('password'), $user->password)) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status'  => 422,
            ], 422);
        }

        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        if (!$client) {
            return response()->json([
                'message' => 'Laravel Passport is not setup properly.',
                'status'  => 500,
            ], 500);
        }

        $data = [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => request('username'),
            'password'      => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status'  => 422,
            ], 422);
        }

        $user->notify(new LoginNotification($user, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
        $data = json_decode($response->getContent());

        return response()->json([
            'token'  => $data->access_token,
            'user'   => $user,
            'status' => 200,
        ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);
        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }

    /**
     * @return Application|Response|ResponseFactory
     */
    public function getUser()
    {
        if (auth()->user()->banned) {
            return response([
                'message' => 'The account is blocked',
                'status'  => 403,
            ], 403);
        }

        return response(auth()->user(), 200);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email',
        ]);

        if ($validator->fails()) {
            return response(['status'=>422, 'error'=>$validator->getMessageBag()], 422);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
        ? response([['status'=>404, 'message' => 'link to reset your password has been sent to your email']], 201)
        : response()->json(['status'=>422, 'message' => 'user with mail already exists'], 422);
    }

    public function resetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validate->fails()) {
            return response(['status'=>422, 'error'=>$validate->getMessageBag()], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? response([['status'=>201, 'message' => 'password recovered successfully']], 201)
            : response(['status'=>404, 'message' => 'link is not valid'], 404);
    }

    public function updatePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'password'    => 'required|min:8|confirmed',
        ]);

        if ($validate->fails()) {
            return response(['status'=>422, 'error'=>$validate->getMessageBag()], 422);
        }

        $user = Auth()->user();

        if (!Hash::check(request('oldPassword'), $user->password)) {
            return response([
                'message' => 'Wrong old password',
                'status'  => 422,
            ], 422);
        }

        $user = User::find($user->user_id);
        $user->password = bcrypt(request('password'));
        $user->update();

        $accessToken = auth()->user()->token();
        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);
        $accessToken->revoke();
    }
}
