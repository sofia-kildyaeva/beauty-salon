@extends('layout.app')
@section('title')
    Сотрудники
@endsection
@section('main')
    <div class="container" id="EmployeesPage">
        <div class="row padding-page mb-3 justify-content-center align-items-center">
            <div class="col-10">
                <h2 class="my-lightgreen"><strong>СОТРУДНИКИ</strong></h2>
            </div>
            <div class="col-2">
                <select name="filter_category" class="form-select select-filter" v-model="filter_category">
                    <option value="0">Все сотрудники</option>
                    <option v-for="category in categories" :value="category.id">@{{ category.title }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <form action="{{route('AddEmployee')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="fio" class="form-label">ФИО</label>
                        <input type="text" class="form-control @error('fio') is-invalid @enderror" id="fio" name="fio">
                        <div class="invalid-feedback">
                            @error('fio')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Изображение</label>
                        <input class="form-control @error('img') is-invalid @enderror" type="file" id="img" name="img">
                        <div class="invalid-feedback">
                            @error('img')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Выберете категорию услуг</label>
                        <select name="category_id" id="category_id" class="form-select">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="profession" class="form-label">Специализация</label>
                        <input class="form-control @error('profession') is-invalid @enderror" type="text" id="profession" name="profession">
                        <div class="invalid-feedback">
                            @error('profession')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="button button-add">Добавить</button>
                </form>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-4 mb-3" v-for="employee in filterSort">
                        <div class="card text-bg-dark">
                            <img :src="employee.img" class="card-img image" style="height: 40vh;">
                            <div class="card-img-overlay text-white" style="top: 70%;background: rgba(0, 0, 0, 0.6);">
                                <h5 class="card-title">@{{ employee.fio }}</h5>
                                <p class="card-text"><small>@{{ employee.profession }}</small></p>
                            </div>
                            <div class="card-img-overlay d-flex justify-content-center" style="left: 65%;">
                                <a :href="`{{route('EditEmployeePage')}}/${employee.id}`" style="margin-right: 0.7rem;color: #FBBB1A;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                    </svg>
                                </a>
                                <form :action="`{{route('DeleteEmployee')}}/${employee.id}`" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn" style="padding: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16" style="color: #F34334;">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const EmployeesPage = {
            data() {
                return {
                    categories: <?php print json_encode($categories)?>,
                    employees: <?php print json_encode($employees)?>,

                    filter_category:0,
                }
            },
            computed:{
                filterSort() {
                    let employees = this.employees;

                    if(this.filter_category!=0) {
                        employees = this.employees.filter(employee=>employee.category_id===this.filter_category);
                    }

                    return employees;
                }
            },
        }
        Vue.createApp(EmployeesPage).mount('#EmployeesPage');
    </script>
@endsection
