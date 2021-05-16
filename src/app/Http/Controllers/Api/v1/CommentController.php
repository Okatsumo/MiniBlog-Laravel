<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\CreateCommentsEven;
use App\Events\removeCommentEven;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as ResponseAlias;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    public function index()
    {
        $comment = new Comment;
        $comments = $comment->with([
            'author'=> function($query){
                $query->select(['user_id','name']);
            }
        ])->take(4)->get()->reverse();
        return response(['status'=>200,'comments'=>$comments], 200);
    }

    /**
     * @return array
     */
    public function show($articleId){
        $comment = new Comment();
        return $comment
            ->where('article_id', '=', $articleId)
            ->with([
                'author'=> function($query){
                    $query->select(['user_id','name']);
                }
            ])
            ->paginate(4)
            ->jsonSerialize();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array|Application|ResponseFactory|JsonResponse|ResponseAlias
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'content'=>'required',
            'articleId'=>'required',
        ]);

        if ($validator->fails()){
            return response([
                'status' => 404,
                'errors' => $validator->getMessageBag()
            ], 404);
        }

        $user = auth()->user();

        if($user->banned){
            return response([
                'status' => 403,
                'errors' => "The account is blocked"
            ], 403);
        }

        try{
            $comment = new Comment();
            $comment->author_id = $user->user_id;
            $comment->article_id = $request->get('articleId');
            $comment->content = $request->get('content');
            $comment->save();

            broadcast(new CreateCommentsEven($comment, 'create'));

            $comment->author;

            return response([$comment], 201);
        }
        catch (QueryException $ex){
            return response()->json(['status'=>404, 'message'=>$ex]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ResponseAlias
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return ResponseAlias
     */
    public function edit(Comment $comment, Request $request): ResponseAlias
    {
        if($request->get("content")){
            $comment->content = $request->get('content');
        }

        if($comment->author_id != auth()->user()->user_id and !auth()->user()->admin){
            return response(['status'=>403, 'message'=>$comment->author_id], 403);
        }


        if($comment->update()){
            broadcast(new CreateCommentsEven($comment, 'edit'));
            return response(['status'=>201], 201);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return ResponseAlias
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return ResponseAlias
     */
    public function destroy(Comment $comment): ResponseAlias
    {
        if($comment->author_id != auth()->user()->user_id){
            return response(['status'=>403], 403);
        }


        $removedComment = Comment::updateOrCreate($comment->jsonSerialize())->first();
        broadcast(new CreateCommentsEven($removedComment, 'remove'));

        if($comment->delete()){
            return response(['status'=>200], 200);
        }
        else{
            return response(['status'=>400], 400);
        }
    }
}
