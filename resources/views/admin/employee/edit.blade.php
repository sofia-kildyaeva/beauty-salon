@extends('layout.app')
@section('title')
    Редактирование информации о сотруднике
@endsection
@section('main')
    <div class="container">
        <div class="row mb-4 padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong style="text-transform: uppercase;">Редактирование информации о сотруднике</strong></h2>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-4">
                <img class="image" src="{{$employee->img}}" alt="{{$employee->fio}}" style="height: 50vh;">
            </div>
            <div class="col-4">
                <form action="{{route('EditEmployeeSave', ['employee'=>$employee])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="fio" class="form-label">ФИО</label>
                        <input type="text" class="form-control @error('fio') is-invalid @enderror" id="fio" name="fio" value="{{$employee->fio}}">
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
                            <option disabled selected value="{{$employee->category_id}}">{{$employee->category->title}}</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="profession" class="form-label">Специализация</label>
                        <input class="form-control @error('profession') is-invalid @enderror" type="text" id="profession" name="profession" value="{{$employee->profession}}">
                        <div class="invalid-feedback">
                            @error('profession')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="button button-add mt-3">Изменить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
