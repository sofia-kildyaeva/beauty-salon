<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Service;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
            'fio'=>['required', 'regex:/[А-Яа-я-]/u'],
            'img'=>['required', 'mimes:png,jpeg,jpg'],
            'profession'=>['required', 'regex:/[А-Яа-я-]/u'],
        ],[
            'fio.required'=>'Поле обязательно для заполнения',
            'fio.regex'=>'Поле может содержать только кириллицу',
            'img.required'=>'Поле обязательно для заполнения',
            'img.mimes'=>'Изображение может быть только в формате png,jpeg,jpg',
            'profession.required'=>'Поле обязательно для заполнения',
            'profession.regex'=>'Поле может содержать только кириллицу',
        ]);
        $employee = new Employee();
        $employee->fio = $request->fio;
        $path_img = $request->file('img')->store('/public/img');
        $employee->img = '/public/storage/'.$path_img;
        $employee->profession = $request->profession;
        $employee->category_id = $request->category_id;
        $employee->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'fio'=>['required', 'regex:/[А-Яа-я-]/u'],
            'img'=>['mimes:png,jpeg,jpg'],
            'profession'=>['required', 'regex:/[А-Яа-я-]/u'],
        ],[
            'fio.required'=>'Поле обязательно для заполнения',
            'fio.regex'=>'Поле может содержать только кириллицу',
            'img.mimes'=>'Изображение может быть только в формате png,jpeg,jpg',
            'profession.required'=>'Поле обязательно для заполнения',
            'profession.regex'=>'Поле может содержать только кириллицу',
        ]);
        $employee->fio = $request->fio;
        if ($request->file('img')) {
            $path_img = $request->file('img')->store('/public/img');
            $employee->img = '/public/storage/'.$path_img;
        }
        $employee->profession = $request->profession;
        if ($request->category_id) {
            $employee->category_id = $request->category_id;
        }

        $employee->update();
        return redirect()->route('EmployeesPage');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->back();
    }
}
