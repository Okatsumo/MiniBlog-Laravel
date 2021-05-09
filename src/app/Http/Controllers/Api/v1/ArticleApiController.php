<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $article = new Article();
        $article->author_id = "1"; //НЕ ЗАБЫТЬ ПЕРЕДЕЛАТЬ!!!!!!!!!!!!!!!!!!!!!!!!!
        $article->title = $request->get("title"); //
        $article->content = $request->get("content");;
        $article->category_id = $request->get("categoryId");;

        $imageType = $request->file('image')->getClientOriginalExtension();

        if($imageType == "png" || $imageType == "jpeg" || $imageType == "jpg"){
            $image = $request->file('image');
            $article->image = mt_rand(50, 100). "." . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(300, 300);
            $image_resize->save(Storage::path('public/images/articles/') .$article->image);

        }
        $article->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return array
     */
    public function show(Article $article)
    {
        $relations = $article
            ->getWithConnections()->first()
            ->getRelations();

        return [
                'article' =>$article->makeHidden(['category_id', 'author_id'])
            ] + $relations ;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return Response
     */
    public function edit(Article $article)
    {
        //
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
    public function destroy(Article $article)
    {
        //
    }
}
