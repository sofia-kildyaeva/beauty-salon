@extends('layout.app')
@section('title')
    График
@endsection
@section('main')
    <div class="container" id="GraphicsPage">
        <div class="row padding-page mb-3">
            <div class="col-12">
                <h2 class="my-lightgreen"><strong>ГРАФИК</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                @if(session()->has('warning'))
                    <div class="alert alert-danger">
                        {{session('warning')}}
                    </div>
                @endif
                <form action="{{route('AddGraphic')}}" method="post">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Сотрудник</label>
                        <select name="employee_id" id="employee_id" class="form-select">
                            <option value="0">Выбрать</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->fio}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Дата</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date">
                        <div class="invalid-feedback">
                            @error('date')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                <label for="time_start" class="form-label label-input">С</label>
                                <input type="time" class="form-control @error('time_start') is-invalid @enderror" id="time_start" name="time_start">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                <label for="time_end" class="form-label label-input">До</label>
                                <input type="time" class="form-control @error('time_end') is-invalid @enderror" id="time_end" name="time_end">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="button button-add">Добавить</button>
                </form>
            </div>
            <div class="col-8">
                <div class="row justify-content-center align-items-end">
                    <div class="col-6">
                        <label for="employeeGraphic" class="form-label">
                            <h5 class="my-lightgreen">График сотрудника</h5>
                        </label>
                        <select class="form-select" name="employeeGraphic" id="employeeGraphic" v-model="employee">
                            <option :value="0">Выберете сотрудника</option>
                            <option v-for="employee in employees" :value="employee.id">@{{ employee.fio }}</option>
                        </select>
                    </div>
                    <div class="col-6">
                        @if(session()->has('danger'))
                            <div class="alert alert-danger" style="margin-bottom: 0 !important;">
                                {{session('danger')}}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mt-4" v-if="employee !== 0">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Дата</th>
                                <th scope="col">Время работы</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="graphic in filterGraphics">
                                <th scope="row">@{{ graphic.date }}</th>
                                <td>@{{ graphic.time_start }} - @{{ graphic.time_end }}</td>
                                <td class="d-flex justify-content-end">
                                    <form :action="`{{route('DeleteGraphic')}}/${graphic.id}`" method="post">
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
        </div>
    </div>
    <script>
        const GraphicsPage = {
            data() {
                return {
                    employee: 0,

                    employees: <?php print json_encode($employees)?>,
                    graphics: <?php print json_encode($graphics)?>,

                    month:['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'],
                }
            },
            computed: {
                filterGraphics() {
                    let graphics = this.graphics;
                    graphics = this.graphics.filter(graphic=>graphic.employee_id === this.employee);
                    return graphics
                },
                normalize() {
                    this.graphics.forEach((graphic)=>{
                        let date = new Date(graphic.date);
                        graphic['date'] = date.getDate() + ' ' + this.month[date.getMonth()] + ' ' + date.getFullYear();

                        let time_start = graphic.time_start.split(':');
                        graphic.time_start = time_start[0] + ':' + time_start[1];

                        let time_end = graphic.time_end.split(':');
                        graphic.time_end = time_end[0] + ':' + time_end[1];
                    });
                },
            },
            mounted() {
                this.normalize;
            }
        }
        Vue.createApp(GraphicsPage).mount('#GraphicsPage');
    </script>
@endsection
