@extends('layout.app')
@section('title')
    Записи
@endsection
@section('main')
    <div class="container" id="EntriesPage">
        <div class="row padding-page mb-3 justify-content-center align-items-center">
            <div class="col-6">
                <h2 class="my-lightgreen"><strong>ЗАПИСИ НА УСЛУГИ</strong></h2>
            </div>
            <div class="col-6">
                <div class="row justify-content-end align-items-center">
                    <div class="col-4">
                        <select name="filter_category" class="form-select select-filter" v-model="filter_status">
                            <option value="0">Все заявки</option>
                            <option value="новая">Новые</option>
                            <option value="подтвержденная">Подтвержденные</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <a href="{{route('EntriesDay')}}" class="button button-day d-flex justify-content-center align-items-center">Расписание</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered" v-if="filterSort.length !== 0">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Статус</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="entry in filterSort" :class="entry.status == 'подтвержденная' ? 'table-marker':''">
                        <th>@{{ entry.id }}</th>
                        <td>@{{ entry.fio }}</td>
                        <td>@{{ entry.phone }}</td>
                        <td>@{{ entry.status }}</td>
                        <td class="text-center">
                            <div class="row">
                                <div class="col-4">
                                    <button type="button" class="btn button-info" data-bs-toggle="modal" :data-bs-target="`#exampleModal_${entry.id}`">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </button>

                                    <div class="modal fade" :id="`exampleModal_${entry.id}`" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body" style="padding: 2rem;">
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column align-items-start">
                                                        <p class="text-muted">@{{ entry.date }} в @{{ entry.time }}</p>
                                                        <h5 style="margin-bottom: 0 !important;">@{{ entry.fio }}</h5>
                                                        <h5 style="margin-bottom: 1rem !important;">@{{ entry.phone }}</h5>
                                                        <p class="text-muted" style="margin-bottom: 0 !important;">@{{ entry.employee.fio }}</p>
                                                        <p class="text-muted">@{{ entry.service.title }}, @{{ entry.service.time }} мин</p>
                                                        <p v-if="entry.comment">Комментарий: @{{ entry.comment }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-4" v-if="entry.status == 'новая'">
                                    <form :action="`{{route('ConfirmationEntry')}}/${entry.id}`" method="post">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn button-agree">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16" style="color: #FFFFFF;">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-4" v-if="entry.status == 'новая'">
                                    <form :action="`{{route('DeleteEntry')}}/${entry.id}`" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn button-delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" style="color: #FFFFFF;">
                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <h2 v-if="filterSort.length == 0">Записей нет!</h2>
            </div>
        </div>
    </div>
    <script>
        const EntriesPage = {
            data() {
                return {
                    entries: <?php print json_encode($entries)?>,

                    month:['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'],

                    filter_status:0,
                }
            },
            computed:{
                filterSort() {
                    let entries = this.entries;

                    if(this.filter_status!=0) {
                        entries = this.entries.filter(entry=>entry.status==this.filter_status);
                    }

                    return entries;
                },
                normalize() {
                    this.entries.forEach((entry)=>{
                        let date = new Date(entry.date);
                        entry['date'] = date.getDate() + ' ' + this.month[date.getMonth()] + ' ' + date.getFullYear();

                        let time = entry.time.split(':');
                        entry.time = time[0] + ':' + time[1];
                    });
                },
            },
            mounted() {
                this.normalize;
            }
        }
        Vue.createApp(EntriesPage).mount('#EntriesPage');
    </script>
@endsection
