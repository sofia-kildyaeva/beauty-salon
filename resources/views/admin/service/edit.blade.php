@extends('layout.app')
@section('title')
    Редактирование процедуры "{{$service->title}}"
@endsection
@section('main')
    <div class="container" id="EditServicePage">
        <div class="row mb-4 padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong style="text-transform: uppercase;">Редактирование процедуры "{{$service->title}}"</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <form action="{{route('EditServiceSave', ['service'=>$service])}}" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{$service->title}}">
                        <div class="invalid-feedback">
                            @error('title')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Область процедуры</label>
                        <select name="category_id" id="category_id" class="form-select" v-model="selected_category">
                            <option selected disabled value="{{$service->type->category->id}}">{{$service->type->category->title}}</option>
                            <option v-for="category in categories" :value="category.id">@{{category.title}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type_id" class="form-label">Тип процедуры</label>
                        <select name="type_id" id="type_id" class="form-select">
                            <option v-if="selected_category == service.type.category.id" selected disabled value="{{$service->type_id}}">{{$service->type->title}}</option>
                            <option v-if="selected_category !== service.type.category.id" selected disabled value="0">Выбрать</option>
                            <option v-for="type in filter_type" :value="type.id">@{{type.title}}</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="basic-addon2" class="form-label">Цена</label>
                            <div class="input-group mb-4">
                                <input type="number" class="form-control @error('price') is-invalid @enderror" aria-label="Recipient's username" aria-describedby="basic-addon2" name="price" value="{{$service->price}}">
                                <span class="input-group-text" id="basic-addon2">руб.</span>
                                <div class="invalid-feedback">
                                    @error('price')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="time" class="form-label">Время проведения</label>
                            <div class="input-group mb-4">
                                <input type="number" class="form-control @error('time') is-invalid @enderror" aria-label="Recipient's username" aria-describedby="basic-addon3" name="time" value="{{$service->time}}">
                                <span class="input-group-text" id="basic-addon3">мин</span>
                                <div class="invalid-feedback">
                                    @error('time')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <a class="btn d-flex align-items-center" style="padding: 0;" :class="selected_category==0 ? 'disabled':''" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <h5 class="m-0" style="margin-right: 0.5rem !important;">Сотрудники, оказывающие услугу</h5>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                                <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
                            </svg>
                        </a>
                        <div class="collapse mt-2 mb-2" v-for="employee in filter_employee" id="collapseExample">
                            <div class="d-flex card-body" style="padding: 0 !important;">
                                <input type="checkbox" :id="employee.id" name="employees_id[]" style="margin-right: 0.5rem;" :value="employee.id">
                                <label :for="employee.id" style="cursor: pointer;font-style: normal;">@{{employee.fio}}</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="button button-add">Изменить</button>
                </form>
            </div>
            <div class="col-2"></div>
            <div class="col-5">
                <div class="row">
                    <h4 class="mb-3">Сотрудники, выполняющие данную услугу</h4>
                    @foreach($employees_service as $employeeService)
                    <div class="mb-2 d-flex justify-content-between">
                        <p>{{$employeeService->employee->fio}}</p>
                        <form action="{{route('DeleteEmployeeService', ['employeeService'=>$employeeService])}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn" style="color: #F34334;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        const EditServicePage = {
            data() {
                return {
                    categories: <?php print json_encode($categories) ?>,
                    types: <?php print json_encode($types) ?>,
                    employees: <?php print json_encode($employees) ?>,
                    selected_category: <?php print json_encode($selected_category) ?>,
                    service: <?php print json_encode($service)?>,
                }
            },
            computed: {
                filter_type() {
                    let types = this.types;

                    if (this.selected_category != 0) {
                        types = this.types.filter(type=>type.category_id===this.selected_category);
                    }
                    return types
                },
                filter_employee() {
                    let employees = this.employees;

                    if (this.selected_category != 0) {
                        employees = this.employees.filter(employee=>employee.category_id===this.selected_category);
                    }
                    return employees
                },
            }
        }
        Vue.createApp(EditServicePage).mount('#EditServicePage');
    </script>
@endsection
