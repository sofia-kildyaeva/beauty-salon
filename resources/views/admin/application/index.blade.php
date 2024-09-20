@extends('layout.app')
@section('title')
    Заявки
@endsection
@section('main')
    <div class="container" id="ApplicationPage">
        <div class="row padding-page mb-3 justify-content-center align-items-center">
            <div class="col-10">
                <h2 class="my-lightgreen"><strong>ЗАЯВКИ НА ОБРАТНЫЙ ЗВОНОК</strong></h2>
            </div>
            <div class="col-2">
                <select name="filter_category" class="form-select select-filter" v-model="filter_status">
                    <option value="0">Все заявки</option>
                    <option value="новая">Новые</option>
                    <option value="подтвержденная">Подтвержденные</option>
                    <option value="отмененная">Отмененные</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
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
                        <tr v-for="application in filterSort" :class="application.status == 'отмененная'||application.status == 'подтвержденная' ? 'table-marker':''">
                            <th>@{{ application.id}}</th>
                            <td>@{{ application.fio}}</td>
                            <td>@{{ application.phone}}</td>
                            <td>@{{ application.status}}</td>
                            <td class="text-center">
                                <div class="row" v-if="application.status == 'новая'">
                                    <div class="col-6">
                                        <form :action="`{{route('ConfirmationApplication')}}/${application.id}`" method="post">
                                            @csrf
                                            @method('put')
                                            <button type="submit" class="btn button-agree">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16" style="color: #FFFFFF;">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        <form :action="`{{route('DeleteApplication')}}/${application.id}`" method="post">
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
            </div>
        </div>
    </div>
    <script>
        const ApplicationPage = {
            data() {
                return {
                    applications: <?php print json_encode($applications)?>,

                    filter_status:0,
                }
            },
            computed:{
                filterSort() {
                    let applications = this.applications;

                    if(this.filter_status!=0) {
                        applications = this.applications.filter(application=>application.status==this.filter_status);
                    }

                    return applications;
                },
            },
        }
        Vue.createApp(ApplicationPage).mount('#ApplicationPage');
    </script>
@endsection
