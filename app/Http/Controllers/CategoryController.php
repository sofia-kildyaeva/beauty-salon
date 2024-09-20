<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required', 'unique:categories', 'regex:/[А-Яа-я]/u'],
            'img'=>['required', 'mimes:png,jpeg,jpg'],
            'descriptionCategory'=>['required'],
        ],[
            'title.required'=>'Поле обязательно для заполнения',
            'title.unique'=>'Данная категория уже существует',
            'title.regex'=>'Поле может содержать только кириллицу',
            'img.required'=>'Поле обязательно для заполнения',
            'descriptionCategory.required'=>'Поле обязательно для заполнения',
        ]);
        $category = new Category();
        $category->title = $request->title;
        $category->description = $request->descriptionCategory;
        $path_img = $request->file('img')->store('/public/img');
        $category->img = '/public/storage/'.$path_img;
        $category->save();
        return redirect()->back();
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }
}
