@extends('layout.app')
@section('title')
    Контакты
@endsection
@section('main')
    <div class="container">
        <div class="row padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong>КОНТАКТЫ</strong></h2>
                <p class="text-description text-center mt-3">Свяжитесь с нами по телефону или отправьте нам электронное письмо, чтобы записаться на прием к одному из наших специалистов. Мы всегда готовы ответить на ваши вопросы и помочь вам выбрать подходящую услугу.</p>
            </div>
        </div>
        <div class="row mt-2 mb-3">
            <div class="col-4">
                <div class="card mt-4 text-center">
                    <div class="card-body" style="padding: 1.7rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="my-lightgreen bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        <h5 class="card-title mt-2">Адрес</h5>
                        <p class="card-text mt-3">г. Нижний Новгород, <br>ул. Евгения Мирошникова, 2А</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mt-4 text-center">
                    <div class="card-body" style="padding: 1.7rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="my-lightgreen bi bi-clock-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                        </svg>
                        <h5 class="card-title mt-2">График работы</h5>
                        <p class="card-text mt-3">Понедельник-пятница: 10:00-20:00 <br> Суббота-воскресенье: 10:00-19:00</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mt-4 text-center">
                    <div class="card-body" style="padding: 1.7rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="my-lightgreen bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        <h5 class="card-title mt-2">Связь с нами</h5>
                        <a href="tel:+79030527575" class="card-text mt-3 text-dark">+7 (903) 052-75-75,</a>
                        <a href="tel:+78312745774" class="text-dark">+7 (831) 274-57-74</a>
                        <p>zagar-nn@mail.ru</p>
                    </div>
                </div>
            </div>
        </div>
        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Abcbb9899300d3a1bf21b34e729acc608dc3557f1682c193bfec0b47a40c3325b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
    </div>
@endsection
