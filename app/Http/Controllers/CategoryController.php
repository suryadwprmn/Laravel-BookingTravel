<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware('can:manage categories');
     }
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        // 1. data akan divalidasi 
        // 2. jika validasi gagal, akan kembali ke halaman sebelumnya
        // 3. jika validasi sukses, maka data akan disimpan ke dalam database

        
        DB::transaction(function () use ($request){
            $validatedData = $request->validated();

            if ($request->hasFile('icon')) {
              $iconPath = $request->file('icon')->store('icons', 'public');
              $validatedData['icon'] = $iconPath;
            }

            $validatedData['slug'] = Str::slug($validatedData['name']);
            $newCategory = Category::create($validatedData);
         
        });

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
        DB::transaction(function () use ($request, $category){
            $validatedData = $request->validated();

            if ($request->hasFile('icon')) {
              $iconPath = $request->file('icon')->store('icons', 'public');
              $validatedData['icon'] = $iconPath;
            }

            $validatedData['slug'] = Str::slug($validatedData['name']);
            $category->update($validatedData);
         
        });
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        DB::transaction(function () use ($category){
            $category->delete();
        });

        return redirect()->route('admin.categories.index');
    }
}