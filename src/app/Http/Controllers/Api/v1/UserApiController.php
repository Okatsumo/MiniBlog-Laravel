<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use function App\Helpers\uploadImage;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = (new User())->paginate(6)->jsonSerialize();
        $data["status"] = 200;

        return response($data, 200);
    }

    public function uploadAvatar(User $user, Request $request){

        $validator = Validator::make($request->all(), [
            'avatar'=>'mimes:jpeg,png',
        ]);

        if(auth()->user()->user_id != $user->user_id and !auth()->user()->admin){
            return response(['status'=>404, 'errors'=>'You don`t have enough rights'], 404);
        }

        $user->avatar = uploadImage('public/images/avatars/', $request->file('avatar'), 140, 140);
        $user->save();

        return response(['status'=>200, 'avatar'=>['name'=>$user->avatar, 'path'=>'public/images/avatars/']], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function edit(User $user, Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'avatar'=>'mimes:jpeg,png',
            'name'=>'string',
            'email'=>'email',
            'dec'=>'string',
            'admin'=>'boolean',
            'banned'=>'boolean'
        ]);

        if(auth()->user()->user_id != $user->user_id and !auth()->user()->admin){
            return response(['status'=>404, 'errors'=>'You don`t have enough rights'], 404);
        }

        if($validator->fails()){
            return response(['status'=>404, 'errors'=>$validator->getMessageBag()], 404);
        }

        if($request->get('name')){
            $user->name = $request->get('name');
        }

        if($request->get('email')){
            $user->email = $request->get('email');
        }

        if($request->get('description')){
            $user->dec = $request->get('description');
        }

        if($request->get('admin') and auth()->user()->admin){
            $user->admin = boolval($request->get('admin'));
        }

        if($request->get('banned') and auth()->user()->admin){
            $user->banned = boolval($request->get('banned'));
        }

        $user->save();
        return response(['status'=>200, 'user'=>$user], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return response(['status'=>200, 'user'=>$user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        if($user->user_id != auth()->user()->user_id and !auth()->user()->admin){
            return response(['status'=>403], 403);
        }

        if($user->delete()){
            return response(['status'=>200], 200);
        }
        else{
            return response(['status'=>400], 400);
        }
    }
}
