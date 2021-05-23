<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->admin){
            return response(['status'=>403], 403);
        }

        $validator = Validator::make(request()->all(), [
           'name'=>'required|string'
        ]);

        if($validator->fails()){
            return response(['status'=>422, 'error'=>$validator->getMessageBag()], 422);
        }

        $category = new Category();
        $category->name = request()->get('name');
        $category->save();

        return response(['status'=>201, 'message'=>'created', 'category'=>$category], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return array
     */
    public function show(Category $category)
    {
        $article = new Article();

        $data = $article->makeHidden(['category_id', 'author_id'])
            ->getWithConnections()
            ->where('category_id', '=', $category->category_id)
            ->paginate(6)
            ->jsonSerialize();

        return $response =  [
            'category'=>[
                'name'=>$category->name,
                'id'=>$category->category_id
            ],
            'articles'=>$data
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): \Illuminate\Http\Response
    {
        if(!auth()->user()->admin){
            return response(['status'=>403], 403);
        }

        $category->delete();
        return response(['status'=>200, 'message'=>'category deleted'], 200);
    }
}
