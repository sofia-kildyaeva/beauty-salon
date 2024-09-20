@extends('layout.app')
@section('title')
    Выбор времени
@endsection
@section('main')
    <div class="container" id="EntryDatePage">
        <div class="row padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong>ВЫБОР ВРЕМЕНИ</strong></h2>
            </div>
        </div>
        <div class="row margin-top-light justify-content-center align-items-center">
            <div class="col-10 d-flex justify-content-center align-items-center">
                <img src="{{$employee->img}}" alt="{{$employee->fio}}" class="image entry-img" style="margin-right: 1rem;">
                <div>
                    <h4>{{$employee->fio}}</h4>
                    <p class="text-muted" style="margin-bottom: 0 !important;">{{$service->title}}, {{$service->price}} руб.</p>
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16" style="color: #FBBB1A;">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                        </svg>
                        <p class="text-muted" style="margin-bottom: 0 !important;margin-left: 0.5rem;">{{$service->time}} мин</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5 choice-graphics">
            <div class="col-1" v-for="graphic in graphics" v-if="graphics.length !== 0">
                <div class="card button-card" style="border-color: #FBBB1A">
                    <button style="border: none;background: none;width: 100%;height: 9vh;font-size: 0.9rem;text-align: center;padding: 0.5rem;" :id="graphic.id" @click="getTimes(graphic.id,service.time)">
                        <strong>@{{graphic.date}}</strong>
                    </button>
                </div>
            </div>
            <div class="row" v-if="graphics.length == 0">
                <h3>У данного сотрудника нет графика на ближайшее время!</h3>
            </div>
        </div>
        <div class="d-flex flex-wrap mt-4 choice-times">
            <div class="d-flex mb-2" v-for="(time, index) in times">
                <button :id="index" style="margin-right: 1rem;border: 1px solid #FBBB1A;background: none;border-radius: 0.25rem;padding: 0.5rem 0.7rem;" @click="openButton(index,time)">
                    @{{ time }}
                </button>
            </div>
        </div>
        <div class="row mt-5 choice-button-continue-p" v-if="continueButton === 1">
            <button id="continueButton" type="button" class="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Продолжить
            </button>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-end">
                            <button type="button" :style="message ? 'display:none;':''"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="form-modal" id="form" @submit.prevent="AddEntry" :style="message ? 'display:none;':''">
                            <h2 class="text-center mb-4">Контактная информация для записи</h2>
                            <input type="text" value="{{$employee->id}}" class="visually-hidden" name="employee_id">
                            <input type="text" value="{{$service->id}}" class="visually-hidden" name="service_id">
                            <input type="text" :value="graphicId" class="visually-hidden" name="graphic_id">
                            <input type="text" :value="timeValue" class="visually-hidden" name="time">
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
                            <div class="mb-3">
                                <label for="comment" class="form-label">Комментарий</label>
                                <textarea rows="5" class="form-control" id="comment" :class="errors.comment? 'is-invalid':''" name="comment"></textarea>
                                <div class="invalid-feedback" v-for="error in errors.comment">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rules" :class="errors.rules? 'is-invalid':''" name="rules">
                                <label class="form-check-label" for="rules">Я согласен с условиями обработки персональных данных</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Записаться</button>
                            </div>
                        </form>
                        <div class="d-flex flex-column text-center align-items-center justify-content-center" v-if="message" style="padding: 2rem;">
                            <div :class="message? 'entry-message':''">
                                @{{ message }}
                            </div>
                            <a href="{{route('welcome')}}" class="mt-4 button d-flex align-items-center justify-content-center">Ок</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script>
        const EntryDatePage = {
            data() {
                return {
                    graphics:<?php print json_encode($graphics)?>,
                    service:<?php print json_encode($service)?>,

                    times:[],

                    element: null,
                    graphicId: 0,

                    elementTime: null,
                    timeKey: 0,

                    continueButton: 0,
                    timeValue: '',

                    errors: [],
                    message: '',

                    month:['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'],
                }
            },
            computed:{
                normalize() {
                    this.graphics.forEach((graphic)=>{
                        let date = new Date(graphic.date);
                        graphic['date'] = date.getDate() + ' ' + this.month[date.getMonth()] + ' ' + date.getFullYear();
                    });
                },
            },
            methods: {
                async getTimes(graphicId,serviceTime) {
                    const response = await fetch('{{route('getTimes')}}', {
                        method: 'post',
                        headers:{
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type':'application/json',
                        },
                        body: JSON.stringify({
                            graphicId:graphicId,
                            serviceTime:serviceTime,
                        })
                    });
                    if (response.status === 200) {
                        const data = await response.json();
                        this.times = data.times;
                    }

                    if(this.element === null) {
                        this.element = document.getElementById(graphicId);
                        this.graphicId = graphicId;
                        this.element.style='color: #FFFFFF;border: none;background: #FBBB1A;width: 100%;height: 9vh;font-size: 0.9rem;text-align: center;padding: 0.5rem;';
                    } else {
                        this.element.style='border: none;background: none;width: 100%;height: 9vh;font-size: 0.9rem;text-align: center;padding: 0.5rem;';
                        this.element = document.getElementById(graphicId);
                        this.graphicId = graphicId;
                        this.element.style='color: #FFFFFF;border: none;background: #FBBB1A;width: 100%;height: 9vh;font-size: 0.9rem;text-align: center;padding: 0.5rem;';
                    }
                },
                async openButton(timeKey,time) {
                    if(this.elementTime === null) {
                        this.elementTime = document.getElementById(timeKey);
                        this.timeKey = timeKey;
                        this.elementTime.style='margin-right: 1rem;border: 1px solid #FBBB1A;background: #FBBB1A;color: #FFFFFF;border-radius: 0.25rem;padding: 0.5rem 0.7rem;';
                    } else {
                        this.elementTime.style='margin-right: 1rem;border: 1px solid #FBBB1A;background: none;border-radius: 0.25rem;padding: 0.5rem 0.7rem;';
                        this.elementTime = document.getElementById(timeKey);
                        this.timeKey = timeKey;
                        this.elementTime.style='margin-right: 1rem;border: 1px solid #FBBB1A;background: #FBBB1A;color: #FFFFFF;border-radius: 0.25rem;padding: 0.5rem 0.7rem;';
                    }
                    this.continueButton = 1;
                    this.timeValue = time;
                },
                async AddEntry() {
                    const form = document.querySelector('#form');
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('EntrySave')}}', {
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
            },
            mounted() {
                this.normalize;
            }
        }
        Vue.createApp(EntryDatePage).mount('#EntryDatePage');
    </script>
@endsection
