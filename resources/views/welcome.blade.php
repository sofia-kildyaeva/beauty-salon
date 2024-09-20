@extends('layout.app')
@section('title')
    Студия загара "Солнышко" в Нижнем Новгороде
@endsection
@section('main')
    <div class="image-welcome">
        <img src="{{asset('public/img/welcome-img.png')}}" class="image">
    </div>
    <div class="welcome-text">
        <h1><strong style="text-transform: uppercase;color: #212529;">Студия загара Солнышко</strong></h1>
        <p>Мы стремимся создать атмосферу расслабления и комфорта, где вы можете насладиться процедурами и получить удовольствие от своего пребывания у нас. Добро пожаловать в нашу студию загара, где забота о вашей красоте - наша страсть!</p>
        <a href="{{route('ChoicePage')}}" class="button welcome-button mt-4 d-flex justify-content-center align-items-center">ЗАПИСАТЬСЯ</a>
    </div>

    <div class="container">
        <div class="row margin-top-big align-items-center welcome-about">
            <div class="col-5">
                <p style="font-size: 32px;line-height: 37px;">Добро пожаловать в студию загара <strong style="color: #06AA6C;font-family: 'Playfair Display', serif !important;font-size: 39px;">Солнышко</strong></p>
            </div>
            <div class="col-7">
                <p class="about-text">Студия красоты "Солнышко" - это уютное и современное место, где каждый клиент может получить профессиональный уход за своей кожей, волосами и ногтями.</p>
                <p class="about-text">В студии работают опытные и квалифицированные мастера, которые используют только высококачественные косметические средства и инновационные технологии для достижения наилучшего результата.</p>
                <p class="about-text">Студия красоты "Солнышко" - это место, где вы можете расслабиться и насладиться процедурами, которые помогут вам выглядеть и чувствовать себя прекрасно.</p>
            </div>
        </div>

        <div class="row margin-top-middle justify-content-center align-items-center">
            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                <h2 class="my-lightgreen"><strong>УСЛУГИ</strong></h2>
                <p class="text-description text-center">Наша студия загара предлагает широкий спектр услуг, включающий в себя профессиональный уход за волосами, ногтями, кожей лица и тела.</p>
            </div>
        </div>
        <div class="row mt-3 justify-content-center welcome-services">
            @foreach($categories as $key=>$category)
                <div class="mb-3 {{$key==3 || $key==4 ? 'col-6':'col-4'}}">
                    <div class="card text-bg-dark welcome-card">
                        <a href="{{route('CategoryServicePage', ['category'=>$category])}}" class="card-multy hover-image-scale">
                            <img src="{{$category->img}}" class="card-img image hover-image-scale" alt="{{$category->title}}">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <h2 class="card-title">{{$category->title}}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="welcome-feedback margin-top-middle">
        <div class="container" id="WelcomePage">
            <div class="row text-center">
                <div class="col-12">
                    <h2 class="text-white">Остались вопросы? Оставьте свои контакты и мы с Вами свяжемся</h2>
                </div>
            </div>
            <form id="form" @submit.prevent="AddApplication" :style="message ? 'display:none;':''">
                <div class="row justify-content-center align-items-center">
                    <div class="col-7">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="mb-3" style="margin-right: 2rem;">
                                    <label for="fio" class="form-label text-white">ФИО*</label>
                                    <input type="text" class="form-control" style="width: 20rem;" id="fio" :class="errors.fio? 'is-invalid':''" name="fio">
                                    <div class="invalid-feedback" v-for="error in errors.fio">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label text-white">Телефон*</label>
                                    <input type="text" class="form-control" style="width: 20rem;" id="phone" :class="errors.phone? 'is-invalid':''" name="phone">
                                    <div class="invalid-feedback" v-for="error in errors.phone">
                                        @{{ error }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rules" :class="errors.rules? 'is-invalid':''" name="rules">
                                    <label class="form-check-label text-white" for="rules">Я согласен с условиями обработки персональных данных</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="button" style="font-size: 1rem;"><strong>Оставить заявку</strong></button>
                    </div>
                </div>
            </form>
            <div class="row justify-content-center align-items-center">
                <div class="col-6">
                    <div :class="message ? 'message-application my-orange':''">
                        <h3>@{{ message }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row margin-top-middle justify-content-center align-items-center">
            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                <h2 class="my-lightgreen"><strong>СПЕЦИАЛИСТЫ</strong></h2>
                <p class="text-description text-center">Наша команда специалистов состоит из профессионалов своего дела, которые постоянно повышают свою квалификацию и следят за новейшими тенденциями в индустрии красоты.</p>
            </div>
        </div>
        <div class="row mt-3 welcome-employees">
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

        <div class="row margin-top-middle">
            <div class="col-12 text-center">
                <h2 class="my-lightgreen"><strong>ГДЕ НАС НАЙТИ</strong></h2>
            </div>
        </div>
        <div class="row margin-top-light welcome-contacts">
            <div class="col-7">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Abcbb9899300d3a1bf21b34e729acc608dc3557f1682c193bfec0b47a40c3325b&amp;source=constructor" width="100%" height="370" frameborder="0"></iframe>
            </div>
            <div class="col-5 d-flex justify-content-center flex-column">
                <div class="contacts-address">
                    <p class="m-0">Адрес:</p>
                    <p class="my-lightgreen">Нижний Новгород, ул. Евгения Мирошникова, 2а</p>
                </div>
                <div class="mb-3">
                    <p class="m-0">Телефон:</p>
                    <a href="tel:+79030527575" class="my-lightgreen m-0">+7 (903) 052-75-75,</a></br>
                    <a href="tel:+78312745774" class="my-lightgreen">+7 (831) 274-57-74</a>
                </div>
                <div class="contacts-messenger">
                    <p class="m-0">Социальные сети и мессенджеры:</p>
                    <div class="d-flex">
                        <div style="margin-right: 1rem;">
                            <a href="viber://chat?number=%2B79030527575" class="d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                <img src="{{asset('public/img/viber 1.png')}}" alt="Viber">
                                <p class="m-0 text-dark" style="margin-left: 0.5rem !important;">Viber</p>
                            </a>
                        </div>
                        <div style="margin-right: 1rem;">
                            <a href="https://vk.com/solnishko_nn" class="d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                <img src="{{asset('public/img/vk 1.png')}}" alt="VK">
                                <p class="m-0 text-dark" style="margin-left: 0.5rem !important;">VK</p>
                            </a>
                        </div>
                        <div style="margin-right: 1rem;">
                            <a href="https://wa.me/79030527575" class="d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                <img src="{{asset('public/img/whatsapp 1.png')}}" alt="WhatsApp">
                                <p class="m-0 text-dark" style="margin-left: 0.5rem !important;">WhatsApp</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const WelcomePage = {
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
        Vue.createApp(WelcomePage).mount('#WelcomePage');
    </script>
@endsection
