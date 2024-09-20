<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\Course;
use App\Models\Employee;
use App\Models\EmployeeService;
use App\Models\Entry;
use App\Models\Graphic;
use App\Models\Service;
use App\Models\Type;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // пользовательская часть
    public function welcome() {
        $categories = Category::all();
        $employees = Employee::query()
            ->orderByDesc('created_at')
            ->limit(3)->get();
        return view('welcome', ['categories'=>$categories, 'employees'=>$employees]);
    }

    public function ChoicePage() {
        return view('guest.entry.choice');
    }
    public function ChoiceEmployeePage() {
        $categories = Category::all();
        $employees = Employee::query()->orderBy('fio')->get();
        return view('guest.entry.choiceEmployee', ['employees'=>$employees, 'categories'=>$categories]);
    }
    public function ChoiceServicePage() {
        $services = Service::all();
        $categories = Category::all();
        $types = Type::all();
        return view('guest.entry.choiceServices', ['services'=>$services, 'categories'=>$categories, 'types'=>$types]);
    }
    public function ChoiceEmployeeServicesPage(Employee $employee) {
        $employeesServices = EmployeeService::query()->where('employee_id', $employee->id)->get();
        $types = Type::query()->where('category_id', $employee->category_id)->get();
        return view('guest.entry.choiceEmployeeServices', ['employee'=>$employee, 'employeesServices'=>$employeesServices, 'types'=>$types]);
    }
    public function ChoiceServiceEmployeesPage(Service $service) {
        $employeesServices = EmployeeService::query()->where('service_id', $service->id)->get();
        return view('guest.entry.choiceServiceEmployees', ['service'=>$service, 'employeesServices'=>$employeesServices]);
    }
    public function ChoiceDatePage(Employee $employee, Service $service) {
        $employee = Employee::query()->where('id', $employee->id)->first();
        $service = Service::query()->where('id', $service->id)->first();

        $dateNow = \date("Y-m-d");
        $graphics = Graphic::query()
            ->where('employee_id', $employee->id)
            ->where('date', '>', $dateNow)
            ->orderBy('date')
            ->get();
        return view('guest.entry.choiceDate', ['employee'=>$employee, 'service'=>$service, 'graphics'=>$graphics]);
    }
    public function getTimes(Request $request) {
        $graphic = Graphic::query()
            ->where('id', $request->graphicId)
            ->first();
        $entries = Entry::query()
            ->where('date', $graphic->date)
            ->where('employee_id', $graphic->employee_id)
            ->with('service')
            ->orderBy('time')
            ->get();

        // функция для перевода времени в секунды
        function second ($time)
        {
            $part = explode(':', $time); //Разбиваем на подстроки
            $a = $part[0]*3600+$part[1]*60; //$part[0]- это часы, $part[1]- минуты
            return $a;
        }
        // функция для расчета времени для записи на услугу
        function hoursRange( $lower, $upper, $step, $format) {
            $times = [];
            if ( empty( $format ) ) {
                $format = 'H:i';
            }
            if ($lower + $step < $upper) {
                foreach ( range( $lower, $upper, $step ) as $increment ) {
                    $increment = date( 'H:i', $increment );
                    list( $hour, $minutes ) = explode( ':', $increment );
                    $date = new \DateTime( $hour . ':' . $minutes );
                    $times[(string) $increment] = $date->format( $format );
                }
            }
            return $times;
        }

        $times = [];
        $format = '';
        $step = $request->serviceTime * 60;
        if (count($entries) == 0) {
            $lower = second($graphic->time_start);
            $upper = second($graphic->time_end) - $step;
            $times = hoursRange($lower, $upper, $step, $format);
        } else {
            if ($entries[0]->time !== $graphic->time_start) {
                $lower = second($graphic->time_start);
                $upper = second($entries[0]->time) + $entries[0]->service->time * 60;
                $times = hoursRange($lower, $upper, $step, $format);
            }

            foreach ($entries as $key=>$entry) {
                $lower = second($entry->time) + $entry->service->time * 60;

                if ($key+1 == count($entries)) {
                    $upper = second($graphic->time_end) - $step;
                } else {
                    $upper = second($entries[$key+1]->time) - $step;
                }

                $timesRang = hoursRange($lower, $upper, $step, $format);
                $times = array_merge($times, $timesRang);
            }
        }
        return response()->json([
            'times'=>$times,
        ], 200);
    }

    public function CategoryServicePage(Category $category) {
        $types = Type::query()
            ->where('category_id', $category->id)
            ->get();
        $employees = Employee::query()
            ->where('category_id', $category->id)
            ->limit(3)
            ->get();
        return view('guest.services.category_services', ['category'=>$category, 'types'=>$types, 'employees'=>$employees]);
    }

    public function ServicesTypePage(Type $type) {
        $services = Service::query()
            ->where('type_id', $type->id)
            ->get();
        return view('guest.services.type_services', ['type'=>$type, 'services'=>$services]);
    }

    public function EmployeesUserPage() {
        $employees = Employee::all();
        $categories = Category::all();
        return view('guest.employees', ['employees'=>$employees, 'categories'=>$categories]);
    }
    public function getEmployees(Request $request) {
        if ($request->id === 0) {
            $employees = Employee::all();
        } else {
            $employees = Employee::query()
                ->where('category_id', $request->id)
                ->get();
        }
        return response()->json([
            'employees'=>$employees,
        ], 200);
    }

    public function ContactsPage() {
        return view('guest.contacts');
    }




    // администраторская часть
    public function AuthPage() {
        return view('admin.auth');
    }

    public function CategoryTypePage() {
        $categories = Category::all();
        $types = Type::query()->with('category')->get();
        return view('admin.category_type.index', ['categories'=>$categories, 'types'=>$types]);
    }

    public function ServicesPage() {
        $services = Service::query()->with(['type','type.category'])->get();
        $employees = Employee::all();
        $categories = Category::all();
        $types = Type::query()->with('category')->get();
        return view('admin.service.index', ['services'=>$services, 'types'=>$types, 'categories'=>$categories, 'employees'=>$employees]);
    }
    public function EditServicePage(Service $service) {
        $categories = Category::all();
        $types = Type::all();
        $employees = Employee::all();
        $employees_service = EmployeeService::query()
            ->where('service_id', $service->id)
            ->get();
        $selected_category = $service->type->category->id;
        $service = Service::query()
            ->where('id', $service->id)
            ->with(['type','type.category'])
            ->first();
        return view('admin.service.edit', ['service'=>$service, 'types'=>$types, 'employees'=>$employees, 'employees_service'=>$employees_service, 'categories'=>$categories, 'selected_category'=>$selected_category]);
    }

    public function EmployeesPage() {
        $employees = Employee::query()->orderByDesc('created_at')->get();
        $categories = Category::all();
        return view('admin.employee.index', ['employees'=>$employees, 'categories'=>$categories]);
    }
    public function EditEmployeePage(Employee $employee) {
        $categories = Category::all();
        return view('admin.employee.edit', ['employee'=>$employee, 'categories'=>$categories]);
    }

    public function GraphicsPage() {
        $graphics = Graphic::query()->with(['employee'])->get();
        $employees = Employee::query()->orderBy('fio')->get();
        $entries = Entry::all();
        return view('admin.graphic.index', ['employees'=>$employees, 'graphics'=>$graphics, 'entries'=>$entries]);
    }
    public function EditGraphicPage(Graphic $graphic) {
        $employees = Employee::all();
        return view('admin.graphic.edit', ['graphic'=>$graphic, 'employees'=>$employees]);
    }

    public function ApplicationsPage() {
        $applications = Application::query()
            ->orderByDesc('created_at')
            ->get();
        return view('admin.application.index', ['applications'=>$applications]);
    }

    public function EntriesPage() {
        $entries = Entry::query()
            ->orderByDesc('created_at')
            ->with(['employee', 'service'])
            ->get();
        return view('admin.entry.index', ['entries'=>$entries]);
    }

    public function EntriesDay() {
        $dateNow = \date("Y-m-d");
//        $dateNow = "2023-06-13";
        $entries = Entry::query()
            ->orderBy('time')
            ->with(['employee'])
            ->get();
        return view('admin.entry.day', ['entries'=>$entries, 'dateNow'=>$dateNow]);
    }
}
