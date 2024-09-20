@extends('layout.app')
@section('title')
    Выбор специалиста
@endsection
@section('main')
    <div class="container">
        <div class="row padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong>ВЫБОР СПЕЦИАЛИСТА</strong></h2>
            </div>
        </div>
        <div class="row margin-top-light">
            @foreach($categories as $key=>$category)
                <div class="row mb-2 {{$key > 0 ? 'mt-4':''}}">
                    <h3 class="my-lightgreen">{{$category->title}}</h3>
                </div>
                @foreach($employees as $employee)
                    @if($employee->category_id === $category->id)
                        <div class="col-6 mb-3">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{$employee->img}}" alt="{{$employee->fio}}" class="image entry-img" style="margin-right: 1rem;">
                                        <div>
                                            <h5 class="card-title">{{$employee->fio}}</h5>
                                            <p class="card-text">{{$employee->profession}}</p>
                                        </div>
                                    </div>
                                    <a href="{{route('ChoiceEmployeeServicesPage', ['employee'=>$employee])}}" class="choice-button-continue">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                            <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
