<?php

namespace App\Http\Controllers;

use App\Http\Middleware\isUserAdmin;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;

class CategoryController extends Controller implements HasMiddleware
{
    public Category $category;

    /**
     * Construct method 
    */
    public function __construct(Category $category) {
        $this->category = $category;
    }

    /**
     * @return array
     * Method to add middlewares in the functions.
     */
    public static function middleware():array
    {
        return [
            new Middleware(isUserAdmin::class, except:['index']) // impede que usuários não-administradores acesses os formulários.
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return Inertia('Categories/IndexCategory',
        [
            'categories' => $this->category->get(), 
            'isAdmin'=> $user->isAdmin 
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('Categories/Forms/CreateCategory', 
        [
            'route' => route('categories.store'), 
            'method' => 'POST'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->category->create($request->validated());
        return to_route('categories.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia('Categories/Forms/CreateCategory',
         [ 
            'category' => $category, 
            'route' => route('categories.update', $category->id), 
            'method' => 'PUT'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
}
