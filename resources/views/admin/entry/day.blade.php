@extends('layout.app')
@section('title')
    Расписание
@endsection
@section('main')
    <div class="container" id="EntriesDayPage">
        <div class="row padding-page mb-3 justify-content-center align-items-center">
            <div class="col-6">
                <h2 class="my-lightgreen"><strong>РАСПИСАНИЕ НА СЕГОДНЯ</strong></h2>
            </div>
            <div class="col-6">
                <div class="row justify-content-end align-items-center">
                    <div class="col-4">
                        <input type="date" class="form-control" v-model="filter_day">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Время</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Сотрудник</th>
                        <th scope="col">Телефон</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="entry in filterSortDay">
                        <th>@{{ entry.time }}</th>
                        <td>@{{ entry.fio }}</td>
                        <td>@{{ entry.employee.fio }}</td>
                        <td>@{{ entry.phone }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const EntriesDayPage = {
            data() {
                return {
                    entries: <?php print json_encode($entries)?>,
                    dateNow: <?php print json_encode($dateNow)?>,

                    month:['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'],

                    filter_day: 0,
                }
            },
            computed:{
                filterSortDay() {
                    let entries = this.entries;

                    if(this.filter_day!=0) {
                        entries = this.entries.filter(entry=>entry.date==this.filter_day);
                    } else {
                        this.filter_day = this.dateNow;
                        entries = this.entries.filter(entry=>entry.date==this.filter_day);
                    }

                    return entries;
                },
                normalize() {
                    this.entries.forEach((entry)=>{
                        let time = entry.time.split(':');
                        entry.time = time[0] + ':' + time[1];
                    });
                },
            },
            mounted() {
                this.normalize;
            }
        }
        Vue.createApp(EntriesDayPage).mount('#EntriesDayPage');
    </script>
@endsection
