@extends('layout.app')
@section('title')
    {{$category->title}}
@endsection
@section('main')
    <div class="container" id="CategoryServicesPage">
        <div class="row padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong style="text-transform: uppercase;">{{$category->title}}</strong></h2>
                <p class="text-description text-center mt-3">{{$category->description}}</p>
            </div>
        </div>
        <div class="row mt-2 mb-5 justify-content-center">
            @foreach($types as $type)
            <div class="col-4 mt-3">
                <a href="{{route('ServicesTypePage', ['type'=>$type])}}">
                    <div class="button-type">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{$type->title}}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="row margin-top-regular">
            <div class="col-5">
                <h4 class="my-lightgreen"><strong>СПЕЦИАЛИСТЫ</strong></h4>
                <p>Вы можете ознакомиться с интересующим вас специалистом, а также записаться к нему на прием.</p>
            </div>
        </div>
        <div class="row" id="CategoryServicesPage">
            @foreach($employees as $employee)
                <div class="col-4">
                    <div class="card">
                        <img src="{{$employee->img}}" class="image card-employees" alt="{{$employee->fio}}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{$employee->fio}}</h5>
                            <p class="mb-2 my-lightgreen">{{$employee->profession}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center" style="margin-top: 1.9rem;">
                <a href="{{route('EmployeesUserPage')}}" class="button-more d-flex align-items-center justify-content-center">
                    <strong>Все специалисты</strong>
                </a>
            </div>
        </div>
    </div>
    <script>
        const CategoryServicesPage = {
            data() {
                return {
                    errors:[],
                    message:'',
                }
            },
            methods:{
                async AddApplication() {
                    const form = document.querySelector('#form');
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('ApplicationSave')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                        },
                        body:form_data,
                    });
                    if(response.status===400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors=[];
                        },3000);
                    }
                    if(response.status===200) {
                        this.message = await response.json();
                    }
                }
            }
        }
        Vue.createApp(CategoryServicesPage).mount('#CategoryServicesPage');
    </script>
@endsection
