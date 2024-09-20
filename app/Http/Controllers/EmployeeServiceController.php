<?php

namespace App\Http\Controllers;

use App\Models\EmployeeService;
use App\Models\Service;
use Illuminate\Http\Request;

class EmployeeServiceController extends Controller
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
    public function store(Request $request, Service $service)
    {
        $employee_service = new EmployeeService();
        $employee_service->employee_id = $request->employeeService;
        $employee_service->service_id = $service->id;
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeService $employeeService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeService $employeeService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeService $employeeService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeService $employeeService)
    {
        $employeeService->delete();
        return redirect()->back();
    }
}
