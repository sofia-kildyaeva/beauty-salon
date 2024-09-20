@extends('layout.app')
@section('title')
    Авторизация
@endsection
@section('main')
    <div class="container" id="AuthPage">
        <div class="row padding-page">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <h2><strong style="text-transform: uppercase;">АВТОРИЗАЦИЯ</strong></h2>
            </div>
        </div>
        <div class="row mt-3 justify-content-center align-items-center">
            <div class="col-4">
                <div :class="message ? 'alert alert-danger' : ''">
                    @{{ message }}
                </div>
                <form id="form" @submit.prevent="AuthUser">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" class="form-control" id="login" name="login">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="button">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const AuthPage = {
            data() {
                return {
                    message: '',
                }
            },
            methods: {
                async AuthUser() {
                    const form = document.querySelector('#form');
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('AuthUser')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body: form_data,
                    });
                    if (response.status === 403) {
                        this.message = await response.json();
                        setTimeout(() => {
                            this.message = '';
                        },2500);
                    }
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            }
        }
        Vue.createApp(AuthPage).mount('#AuthPage');
    </script>
@endsection
