<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryApiController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CategoryResource::collection($this->categoryRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     *
     * @return void
     */
    public function store(CategoryRequest $request)
    {
        return $this->categoryRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     *
     * @return Application|Response|ResponseFactory
     */
    public function show(Category $category)
    {
        $data = $this->categoryRepository->get($category)->paginate()->jsonSerialize();

        return response(
            [
                'articles'=> $data,
                'category'=> [
                        'name'=> $category->name,
                        'id'  => $category->category_id,
                    ],
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $categoryId
     *
     * @return JsonResponse
     */
    public function update(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->fill($request->except(['category_id']));
//        $category->$request->get('name');
        $category->save();

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoryRequest $request
     *
     * @return Application|ResponseFactory|Response
     */
    public function destroy($category, CategoryRequest $request)
    {
        if (!$category = Category::findOrFail($category)) {
            return response(['message'=>'not found'], 404);
        }

        if ($category->delete()) {
            return response(['status'=>204], 204);
        }
    }
}
