<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Graphic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class GraphicController extends Controller
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
            'date' => ['required'],
            'time_start' => ['required'],
            'time_end' => ['required'],
        ], [
            'date.required' => 'Поле обязательно для заполнения',
        ]);
        $graphics = Graphic::query()
            ->where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->first();
        if ($graphics !== null) {
            return redirect()->back()->with('warning', 'График на выбранный день уже есть!');
        }
        $dateNow = \date("Y-m-d");
        if ($request->date <= $dateNow) {
            return redirect()->back()->with('warning', 'Выбранный день уже прошел!');
        }
        $graphic = new Graphic();
        $graphic->employee_id = $request->employee_id;
        $graphic->date = $request->date;
        $graphic->time_start = $request->time_start;
        $graphic->time_end = $request->time_end;
        $graphic->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Graphic $graphic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Graphic $graphic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Graphic $graphic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Graphic $graphic)
    {
        $entry = Entry::query()->where('date', $graphic->date)->first();
        if ($entry !== null) {
            return redirect()->back()->with('danger', 'На данный день уже есть запись!');
        }
        $graphic->delete();
        return redirect()->back();
    }
}
