<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use function App\Helpers\uploadImage;
use function MongoDB\BSON\fromJSON;
use function MongoDB\BSON\toJSON;


class ArticleApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $article = new Article();

        return $article->makeHidden(['category_id', 'author_id'])
            ->getWithConnections()
            ->paginate(6)
            ->jsonSerialize();
    }

    public function search(Request $request){
        $articles = Article::where('title', 'LIKE', '%' . $request->get('text') . '%');
        $data = $articles->with([
            'category'=> function($query){
                $query->select(['category_id','name']);
            },
            'author'=>function($query){
                $query->select(['user_id','name', 'dec', 'avatar']);
            }
        ])
            ->paginate(6)
            ->jsonSerialize();

        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'content'=>'required',
            'categoryId'=>'required|integer',
            'tags'=>'json',
            'image'=>'mimes:jpeg,bmp,png'
        ]);


        if($validator->fails()){
            return \response(['status'=>404, 'error'=>$validator->getMessageBag()], 404);
        }

        if(!auth()->user()->admin){
            return \response(['status'=>403, "error"=>"admin?"], 403);
        }

        $article = new Article();
        $article->author_id = auth()->user()->user_id;
        $article->title = $request->get("title");
        $article->content = $request->get("content");;
        $article->category_id = $request->get("categoryId");;


        if($request->get("tags")){
            $article->tags = $request->get('tags');
        }

        if($request->file('image')){
            $article->image = uploadImage('public/images/articles/', $request->file('image'), 300, 300);
        }

        $article->save();

        return response(['status'=>201, "article"=>$article], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return Application|ResponseFactory|Response
     */
    public function show(Article $article)
    {
        $relations = $article
            ->getWithConnections()->first()
            ->getRelations();

        $data=  [
                'article' =>$article->makeHidden(['category_id', 'author_id'])
            ] + $relations ;
        return response($data, 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Article $article
     * @param Request $request
     * @return Response
     */
    public function edit(Article $article, Request $request): Response
    {
        if($request->get("title")){
            $article->title = $request->get('title');
        }

        if($request->get("content")){
            $article->title = $request->get('content');
        }

        if($request->get("image")){
            $article->title = $request->get('image');
        }

        if($request->get("category_id")){
            $article->title = $request->get('category_id');
        }

        if($article->update()){
            return \response(['status'=>201, 'article'=>$article], 201);
        }

        return \response(['status'=>404], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return Response
     */
    public function destroy($id)
    {
        if(!$article = Article::find($id)){
            return \response(['status'=>404], 404);
        }

        if($article->author_id != auth()->user()->user_id){
            return \response(['status'=>403], 403);
        }


        if($article->delete()){
            return \response(['status'=>200], 200);
        }
        else{
            return \response(['status'=>400], 400);
        }
    }
}
