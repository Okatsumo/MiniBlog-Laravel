<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\loadCommentsEven;
use App\Http\Controllers\Controller;
use App\Jobs\AddCommentJob;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use function App\Helpers\getUserFromRefreshToken;

class CommentController extends Controller
{

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
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'content'=>'required',
            'articleId'=>'required',
        ]);

        if ($validator->fails()){
            return [
                'status' => false,
                'errors' => $validator->getMessageBag()
            ];
        }

        $user = auth()->user();

        try{
            $comment = new Comment();
            $comment->author_id = $user->user_id;
            $comment->article_id = $request->get('articleId');
            $comment->content = $request->get('content');
            $comment->save();

            broadcast(new loadCommentsEven($comment));

            return response(['status'=>201], 201);


        }
        catch (QueryException $ex){
            return response()->json(['status'=>404, 'message'=>$ex]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
