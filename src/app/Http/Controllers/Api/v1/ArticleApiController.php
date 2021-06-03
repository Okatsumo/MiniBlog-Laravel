<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
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
     * @return array|Application|ResponseFactory|Response
     */
    public function index()
    {
        $article = new Article();


        $validator = Validator::make(request()->all(), [
            'sort'=>'string',
            'categoryId'=>'integer',
        ]);

        if($validator->fails()){
            return response(['status'=>422, 'error'=>$validator->getMessageBag()], 422);
        }

        if(request()->get('categoryId')){
            if($category = Category::find(request()->get('categoryId'))){
                $articles = $article
                    ->makeHidden(['category_id', 'author_id'])
                    ->getWithConnections()
                    ->select(['title', 'article_id', 'shortDescription', 'rating', 'image', 'author_id', 'category_id', 'tags'])
                    ->where('category_id', '=', request()->get('categoryId'))
                    ->paginate(6)
                    ->jsonSerialize();

                return [
                    'category'=>[
                        'name'=>$category->name,
                        'id'=>$category->category_id
                    ],
                    'articles'=>$articles
                ];
            }
            else{
                return response(['status'=>404], 404);
            }

        }

        if(request()->get('sort') == "descending"){
            return [
                'articles'=>$article
                ->getWithConnections()
                ->orderBy('article_id', 'desc')
                ->take(4)
                ->get(['title', 'article_id', 'shortDescription', 'rating', 'image', 'author_id', 'category_id', 'tags']),
                'count'=>$article->count()
            ];
        }

        else{
            return $article
                ->getWithConnections()
                ->select(['title', 'article_id', 'shortDescription', 'rating', 'image', 'author_id', 'category_id', 'tags'])
                ->paginate(6)
//                ->makeHidden(['category_id', 'author_id'])
                ->jsonSerialize();
        }
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
            ->select(['title', 'article_id', 'shortDescription', 'rating', 'image', 'author_id', 'category_id', 'tags'])
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
            'title'=>'required|string|max:80|min:4',
            'content'=>'required|string',
            'shortDescription'=>'string|min:0|max:140',
            'categoryId'=>'required|integer',
            'tags'=>'json',
            'image'=>'mimes:jpeg,bmp,png'
        ]);


        if($validator->fails()){
            return \response(['status'=>422, 'error'=>$validator->getMessageBag()], 422);
        }

        if(!auth()->user()->admin){
            return \response(['status'=>403, "error"=>"admin?"], 403);
        }

        $article = new Article();
        $article->author_id = auth()->user()->user_id;
        $article->title = $request->get("title");
        $article->content = $request->get("content");;
        $article->category_id = $request->get("categoryId");

        if($request->get("shortDescription")){
            $article->shortDescription = $request->get('shortDescription');
        }

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
        $validator = Validator::make($request->all(), [
            'title'=>'string|max:80|min:4',
            'shortDescription'=>'string|min:0|max:140',
            'content'=>'string',
            'categoryId'=>'integer',
            'tags'=>'json',
            'image'=>'mimes:jpeg,bmp,png'
        ]);

        if($validator->fails()){
            return \response(['status'=>422, 'error'=>$validator->getMessageBag()], 422);
        }

        if($request->get("title")){
            $article->title = $request->get('title');
        }

        if($request->get("shortDescription")){
            $article->shortDescription = $request->get('shortDescription');
        }

        if($request->get("content")){
            $article->content = $request->get('content');
        }

        if($request->file('image')){
            $article->image = uploadImage('public/images/articles/', $request->file('image'), 300, 300);
        }

        if($request->get("tags")){
            $article->tags = $request->get('tags');
        }

        if($request->get("categoryId")){
            $article->category_id = $request->get('categoryId');
        }

        if($article->update()){
            return response(['status'=>201, 'article'=>$article], 201);
        }

        return response(['status'=>404], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        if(!$article = Article::find($id)){
            return response(['status'=>404], 404);
        }

        if(!auth()->user()->admin){
            return response(['status'=>403], 403);
        }

        if($article->delete()){
            return response(['status'=>200], 200);
        }

        else{
            return response(['status'=>400], 400);
        }
    }
}
