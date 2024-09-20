<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
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
        $validation = Validator::make($request->all(), [
            'fio'=>['required', 'regex:/[А-Яа-я]/u'],
            'phone'=>['required', 'regex:/\+?[78][-\(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$/'],
            'rules'=>['required'],
        ],[
            'fio.required'=>'поле обязательно для заполнения',
            'fio.regex'=>'поле может содержать только кириллицу',
            'phone.required'=>'поле обязательно для заполнения',
            'phone.regex'=>'поле должно соответствовать формату мобильного телефона',
            'rules.required'=>'поле обязательно для выбора',
        ]);
        if($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }
        $application = new Application();
        $application->fio = $request->fio;
        $application->phone = $request->phone;
        $application->save();
        return response()->json('Заявка отправлена. В ближайшее время с Вами свяжется администратор!', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        $application->status = 'подтвержденная';
        $application->update();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $application->status = 'отмененная';
        $application->update();
        return redirect()->back();
    }
}
