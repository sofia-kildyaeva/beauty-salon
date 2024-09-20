@extends('layout.app')
@section('title')
    Специалисты
@endsection
@section('main')
    <div class="container">
        <div class="row padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2 class="my-lightgreen"><strong>СПЕЦИАЛИСТЫ</strong></h2>
                <p class="text-description text-center mt-3">Наш салон красоты предлагает услуги высококвалифицированных специалистов, которые помогут вам выглядеть и чувствовать себя наилучшим образом. Мы гордимся нашей командой профессионалов, которые обладают не только навыками и опытом, но и страстью к своей работе.</p>
            </div>
        </div>
        <div class="row mt-2 mb-5" id="Employees">
            <div class="employees-categories mt-4 mb-3 d-flex justify-content-between">
                <button id="0" style="background: none;border: none;border-radius: 50px;width: 180px;height: 60px;font-size: 1rem;background: #FBBB1A;text-align: center;padding: 0.5rem;color: #FFFFFF;" @click="getEmployees(0)">Все специалисты</button>
                <button v-for="category in categories" :id="category.id" style="background: none;border: none;" @click="getEmployees(category.id)">@{{ category.title }}</button>
            </div>
            <div class="row mt-1 employees-cards">
                <div class="col-4 mb-3" v-for="employee in employees">
                    <div class="card">
                        <img :src="employee.img" class="card-img-top image card-employees" :alt="employee.fio">
                        <div class="card-body text-center">
                            <h5 class="card-title">@{{ employee.fio }}</h5>
                            <p class="card-subtitle mb-2 text-body-secondary my-lightgreen">@{{ employee.profession }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const Employees={
            data() {
                return{
                    categories: <?php print json_encode($categories)?>,
                    employees: [],
                    element: document.getElementById(0),
                    categoryId: 0,
                }
            },
            methods: {
                async getEmployees(id) {
                    const response = await fetch('{{route('getEmployees')}}', {
                        method: 'post',
                        headers:{
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type':'application/json',
                        },
                        body: JSON.stringify({
                            id:id,
                        })
                    });
                    if(this.element === null) {
                        this.element = document.getElementById(id);
                        this.categoryId = id;
                        this.element.style='background: none;border: none;border-radius: 50px;width: 180px;height: 60px;font-size: 1rem;background: #FBBB1A;text-align: center;padding: 0.5rem;color: #FFFFFF;';
                    } else {
                        this.element.style='border: none;background: none;';
                        this.element = document.getElementById(id);
                        this.categoryId = id;
                        this.element.style='background: none;border: none;border-radius: 50px;width: 180px;height: 60px;font-size: 1rem;background: #FBBB1A;text-align: center;padding: 0.5rem;color: #FFFFFF;';
                    }
                    if (response.status === 200) {
                        const data = await response.json();
                        this.employees = data.employees;
                    }
                },
            },
            mounted(){
                this.getEmployees(0);
            }
        };
        Vue.createApp(Employees).mount('#Employees');
    </script>
@endsection
