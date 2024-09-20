@extends('layout.app')
@section('title')
    Категории и типы
@endsection
@section('main')
    <div class="container" id="CategoryTypePage">
        <div class="row mb-3 padding-page">
            <div class="col-12">
                <h2 class="my-lightgreen"><strong>КАТЕГОРИИ</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <form action="{{route('AddCategory')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                        <div class="invalid-feedback">
                            @error('title')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descriptionCategory" class="form-label">Описание</label>
                        <textarea rows="5" class="form-control @error('descriptionCategory') is-invalid @enderror" id="descriptionCategory" name="descriptionCategory"></textarea>
                        <div class="invalid-feedback">
                            @error('descriptionCategory')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Изображение</label>
                        <input class="form-control @error('img') is-invalid @enderror" type="file" id="formFile" name="img">
                        <div class="invalid-feedback">
                            @error('img')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="button button-add">Добавить</button>
                </form>
            </div>
            <div class="col-8">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Изображение</th>
                        <th scope="col">Название</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <th>{{$category->id}}</th>
                        <td><img class="image image-category" src="{{$category->img}}" alt="{{$category->title}}"></td>
                        <td>{{$category->title}}</td>
                        <td class="text-center">
                            <form action="{{route('DeleteCategory', ['category'=>$category])}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn button-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16" style="color: #FFFFFF">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row margin-top-regular border-row"></div>
        <div class="row margin-top-regular mb-3 justify-content-center align-items-center">
            <div class="col-10">
                <h2 class="my-lightgreen"><strong>ТИПЫ</strong></h2>
            </div>
            <div class="col-2">
                <select name="filter_category" class="form-select select-filter" v-model="filter_category">
                    <option value="0">Все типы</option>
                    <option v-for="category in categories" :value="category.id">@{{ category.title }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <form action="{{route('AddType')}}" method="post">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                        <div class="invalid-feedback">
                            @error('title')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Выберете категорию</label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            @error('category_id')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descriptionType" class="form-label">Описание</label>
                        <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="descriptionType" name="description"></textarea>
                        <div class="invalid-feedback">
                            @error('description')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="button button-add">Добавить</button>
                </form>
            </div>
            <div class="col-8">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Категория</th>
                        <th scope="col">Описание</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="type in filterSort">
                        <th>@{{ type.id }}</th>
                        <td class="table-marker">@{{ type.title }}</td>
                        <td>@{{ type.category.title }}</td>
                        <td>@{{ type.description }}</td>
                        <td class="text-center">
                            <form :action="`{{route('DeleteType')}}/${type.id}`" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn button-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16" style="color: #FFFFFF">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const CategoryTypePage = {
            data() {
                return {
                    categories: <?php print json_encode($categories)?>,
                    types: <?php print json_encode($types)?>,

                    filter_category:0,
                }
            },
            computed:{
                filterSort() {
                    let types = this.types;

                    if(this.filter_category!=0) {
                        types = this.types.filter(type=>type.category_id===this.filter_category);
                    }

                    return types;
                }
            },
        }
        Vue.createApp(CategoryTypePage).mount('#CategoryTypePage');
    </script>
@endsection
