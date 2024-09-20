@extends('layout.app')
@section('title')
    Процедуры
@endsection
@section('main')
    <div class="container" id="AddServicePage">
        <div class="row padding-page mb-3 justify-content-center align-items-center">
            <div class="col-10">
                <h2 class="my-lightgreen"><strong>УСЛУГИ</strong></h2>
            </div>
            <div class="col-2">
                <select name="filter_category" class="form-select select-filter" v-model="filter_category">
                    <option value="0">Все услуги</option>
                    <option v-for="category in categories" :value="category.id">@{{ category.title }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <form action="{{route('AddService')}}" method="post">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                        <div class="invalid-feedback">
                            @error('title')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Область процедуры</label>
                        <select name="category_id" id="category_id" class="form-select" v-model="selected_category">
                            <option selected disabled value="0">Выбрать</option>
                            <option v-for="category in categories" :value="category.id">@{{category.title}}</option>
                            <div class="invalid-feedback">
                                @error('category_id')
                                {{$message}}
                                @enderror
                            </div>
                        </select>
                    </div>
                    <div class="mb-3" :style="selected_category==0 ? 'display:none;':''">
                        <label for="type_id" class="form-label">Тип процедуры</label>
                        <select name="type_id" id="type_id" class="form-select">
                            <option selected disabled value="0">Выбрать</option>
                            <option v-for="type in filter_type" :value="type.id">@{{type.title}}</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="basic-addon2" class="form-label">Цена</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control @error('price') is-invalid @enderror" aria-label="Recipient's username" aria-describedby="basic-addon2" name="price">
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
                            <div class="input-group mb-3">
                                <input type="number" class="form-control @error('time') is-invalid @enderror" aria-label="Recipient's username" aria-describedby="basic-addon3" name="time">
                                <span class="input-group-text" id="basic-addon3">мин</span>
                                <div class="invalid-feedback">
                                    @error('time')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a class="btn d-flex align-items-center" style="padding: 0;" :class="selected_category==0 ? 'disabled':''" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <p class="m-0" style="margin-right: 0.5rem !important;">Сотрудники, оказывающие услугу</p>
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
                    <button type="submit" class="button button-add">Добавить</button>
                </form>
            </div>
            <div class="col-8">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Категория</th>
                        <th scope="col">Тип</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="service in filterSort">
                        <th>@{{ service.id }}</th>
                        <td class="table-marker">@{{ service.title }}</td>
                        <td>@{{ service.type.category.title }}</td>
                        <td>@{{ service.type.title }}</td>
                        <td>
                            <a :href="`{{route('EditServicePage')}}/${service.id}`" class="btn mb-2" style="background-color: #FBBB1A;color: #FFFFFF;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                            </a>
                            <form :action="`{{route('DeleteService')}}/${service.id}`" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn button-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16" style="color: #FFFFFF;">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const AddServicePage = {
            data() {
                return {
                    employees: <?php print json_encode($employees) ?>,
                    categories: <?php print json_encode($categories) ?>,
                    types: <?php print json_encode($types) ?>,
                    services: <?php print json_encode($services) ?>,

                    filter_category:0,
                    selected_category: 0,
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
                filterSort() {
                    let services = this.services;

                    if(this.filter_category!=0) {
                        services = this.services.filter(service=>service.type.category_id===this.filter_category);
                    }

                    return services;
                }
            }
        }
        Vue.createApp(AddServicePage).mount('#AddServicePage');
    </script>
@endsection
