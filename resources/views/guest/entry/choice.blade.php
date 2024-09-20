@extends('layout.app')
@section('title')
    Новая запись
@endsection
@section('main')
    <div class="container">
        <div class="row padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong>НОВАЯ ЗАПИСЬ</strong></h2>
                <p class="text-description text-center mt-3">Благодаря онлайн записи Вы можете выбрать удобное для Вас время и дату записи, не тратя время на поездку в студию или звонки. Также мы можем более эффективно планировать свое время и ресурсы, что позволяет обеспечивать более высокое качество обслуживания для наших клиентов.</p>
            </div>
        </div>
        <div class="row margin-top-light choice">
            <div class="col-6">
                <a href="{{route('ChoiceEmployeePage')}}" class="choice-button text-center d-flex align-items-center justify-content-center">Выбрать сотрудника</a>
            </div>
            <div class="col-6">
                <a href="{{route('ChoiceServicePage')}}" class="choice-button text-center d-flex align-items-center justify-content-center">Выбрать услугу</a>
            </div>
        </div>
    </div>
@endsection
