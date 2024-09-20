@extends('layout.app')
@section('title')
    {{$type->title}}
@endsection
@section('main')
    <div class="container" id="TypeServicesPage">
        <div class="row padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong style="text-transform: uppercase;">{{$type->title}}</strong></h2>
                <p class="text-description text-center mt-3">{{$type->description}}</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-8">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Наименование</th>
                        <th scope="col">Время проведения (мин)</th>
                        <th scope="col">Цена (руб)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>{{$service->title}}</td>
                            <td>{{$service->time}}</td>
                            <td>{{$service->price}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
            <div class="col-3">
                <h5 class="text-center my-lightgreen">Остались вопросы? Оставьте свои контакты и мы с Вами свяжемся</h5>
                <form id="form" @submit.prevent="AddApplication" :style="message ? 'display:none;':''">
                    <div class="mb-3">
                        <label for="fio" class="form-label">ФИО*</label>
                        <input type="text" class="form-control" id="fio" :class="errors.fio? 'is-invalid':''" name="fio">
                        <div class="invalid-feedback" v-for="error in errors.fio">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Телефон*</label>
                        <input type="text" class="form-control" id="phone" :class="errors.phone? 'is-invalid':''" name="phone">
                        <div class="invalid-feedback" v-for="error in errors.phone">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rules" :class="errors.rules? 'is-invalid':''" name="rules">
                        <label class="form-check-label" for="rules">Я согласен с условиями обработки персональных данных</label>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Оставить заявку</button>
                    </div>
                </form>
                <div :class="message ? 'message-application':''">
                    <div class="d-flex justify-content-center align-items-center">
                        <h3>@{{ message }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const TypeServicesPage = {
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
        Vue.createApp(TypeServicesPage).mount('#TypeServicesPage');
    </script>
@endsection
