<?php
$categories = \App\Models\Category::all();
?>

<nav id="FooterPage">
    <footer class="footer">
        <div class="container">
        <div class="row">
            <div class="col-6">
                <ul class="nav-footer d-flex">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('welcome')}}">Главная</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Услуги
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($categories as $category)
                                <li><a class="dropdown-item text-dark" href="{{route('CategoryServicePage', ['category'=>$category])}}">{{$category->title}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('EmployeesUserPage')}}">Специалисты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('ContactsPage')}}">Контакты</a>
                    </li>
                </ul>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <a href="tel:+79030527575" class="text-white text-footer">+7 (903) 052-75-75</a>
                <a href="{{route('ChoicePage')}}" class="button d-flex justify-content-center align-items-center">ЗАПИСАТЬСЯ</a>
            </div>
        </div>
    </div>
    </footer>
</nav>
<script>
    const FooterPage = {
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
    Vue.createApp(FooterPage).mount('#FooterPage');
</script>
