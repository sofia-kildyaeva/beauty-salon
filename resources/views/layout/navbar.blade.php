<?php
    $categories = \App\Models\Category::all();
?>

<nav class="navbar-expand-lg bg-body-tertiary navigation">
    <div class="container-fluid container d-flex justify-content-between">
        <a class="navbar-brand" href="{{route('welcome')}}">
            <img class="logo" src="{{asset('public/img/logo.png')}}" alt="Солнышко - студия загара">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="flex-grow: 0;">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{route('welcome')}}">Главная</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Услуги
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($categories as $category)
                            <li><a class="dropdown-item" href="{{route('CategoryServicePage', ['category'=>$category])}}">{{$category->title}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{route('EmployeesUserPage')}}">Специалисты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{route('ContactsPage')}}">Контакты</a>
                </li>
            </ul>
            @auth()
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link text-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Администрирование
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('CategoryTypePage')}}">Категории и типы</a></li>
                            <li><a class="dropdown-item" href="{{route('EmployeesPage')}}">Сотрудники</a></li>
                            <li><a class="dropdown-item" href="{{route('GraphicsPage')}}">График</a></li>
                            <li><a class="dropdown-item" href="{{route('ServicesPage')}}">Услуги</a></li>
                            <li><a class="dropdown-item" href="{{route('ApplicationsPage')}}">Заявки</a></li>
                            <li><a class="dropdown-item" href="{{route('EntriesPage')}}">Записи</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{route('ExitUser')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16" style="margin-right: 0.5rem;">
                                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg>
                                    Выход
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth
        </div>
        <button class="navbar-toggler mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </span>
        </button>
        <div class="navbar-address">
            <p>+7 (903) 052-75-75 | Н. Новгород, ул. Мирошникова, 2а</p>
        </div>
    </div>
</nav>
