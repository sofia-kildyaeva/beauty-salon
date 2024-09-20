<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\EmployeeService;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
            'title'=>['required', 'unique:services', 'regex:/[А-Яа-яA-Za-z]/u'],
            'price'=>['required', 'numeric', 'between:0,100000'],
            'time'=>['required', 'numeric', 'min:1', 'max:300'],
        ],[
            'title.required'=>'Поле обязательно для заполнения',
            'title.unique'=>'Данная услуга уже существует',
            'title.regex'=>'Поле может содержать только кириллицу',
            'price.required'=>'Поле обязательно для заполнения',
            'price.numeric'=>'Поле может содержать только цифры',
            'price.between'=>'Значение не иожет быть меньше 0 и больше 100000',
            'time.required'=>'Поле обязательно для заполнения',
            'time.numeric'=>'Поле может содержать только цифры',
            'time.min'=>'Минимальное значение 30',
            'time.max'=>'Максимвльное значение 300',
        ]);
        $service = new Service();
        $service->title = $request->title;
        $service->type_id = $request->type_id;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->save();

        if ($request->employees_id) {
            foreach ($request->employees_id as $employee) {
                $employee_service = new EmployeeService();
                $employee_service->employee_id = $employee;
                $employee_service->service_id = $service->id;
                $employee_service->save();
            }
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title'=>['required', 'regex:/[А-Яа-яA-Za-z]/u'],
            'price'=>['required', 'numeric', 'between:0,100000'],
            'time'=>['required', 'numeric', 'min:30', 'max:300'],
        ],[
            'title.required'=>'Поле обязательно для заполнения',
            'title.unique'=>'Данная услуга уже существует',
            'title.regex'=>'Поле может содержать только кириллицу',
            'price.required'=>'Поле обязательно для заполнения',
            'price.numeric'=>'Поле может содержать только цифры',
            'price.between'=>'Значение не иожет быть меньше 0 и больше 100000',
            'time.required'=>'Поле обязательно для заполнения',
            'time.numeric'=>'Поле может содержать только цифры',
            'time.min'=>'Минимальное значение 30',
            'time.max'=>'Максимвльное значение 300',
        ]);
        $service->title = $request->title;
        if ($request->type_id) {
            $service->type_id = $request->type_id;
        }
        $service->price = $request->price;
        $service->time = $request->time;

        if ($request->category_id !== $service->type->category->id) {
            if ($request->employees_id) {
                foreach ($request->employees_id as $employee) {
                    $employee_service = EmployeeService::query()
                        ->where('employee_id', $employee)
                        ->where('service_id', $service->id)
                        ->first();
                    if ($employee_service == null) {
                        $employee_service = new EmployeeService();
                        $employee_service->employee_id = $employee;
                        $employee_service->service_id = $service->id;
                        $employee_service->save();
                    }
                }
            }
        }
        if ($request->category_id == $service->type->category->id) {
            $employees_service = EmployeeService::query()
                ->where('service_id', $service->id)
                ->get();
            foreach ($employees_service as $employee) {
                $employee->delete();
            }

            if ($request->employees_id) {
                foreach ($request->employees_id as $employee) {
                    $employee_service = new EmployeeService();
                    $employee_service->employee_id = $employee;
                    $employee_service->service_id = $service->id;
                    $employee_service->save();
                }
            }
        }

        $service->update();
        return redirect()->route('ServicesPage');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->back();
    }
}
