<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Entry;
use App\Models\Graphic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntryController extends Controller
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
        $graphic = Graphic::query()->where('id', $request->graphic_id)->first();

        $entry = new Entry();
        $entry->fio = $request->fio;
        $entry->phone = $request->phone;
        $entry->comment = $request->comment;
        $entry->date = $graphic->date;
        $entry->time = $request->time;
        $entry->service_id = $request->service_id;
        $entry->employee_id = $request->employee_id;
        $entry->status = 'новая';
        $entry->save();
        return response()->json('Заявка отправлена. В ближайшее время с Вами свяжется администратор!', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry)
    {
        $entry->status = 'подтвержденная';
        $entry->update();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entry $entry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();
        return redirect()->back();
    }
}
