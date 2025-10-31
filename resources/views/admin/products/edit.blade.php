@extends('admin.layout')

@section('title', 'Редактирование продукта')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Редактирование продукта</h1>
            <a href="{{ route('admin.products') }}" class="btn btn-secondary">Назад</a>
        </div>

        <div class="admin-card">
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Название</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name',  $product->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Цена</label>
                                <input type="number" step="0.05" class="form-control" id="price" name="price" value="{{ old('price',  $product->price)  }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Категория</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="Не выбрано" selected>Не выбрано</option>
                                    <option value="Рамен">Рамен</option>
                                    <option value="Напитки" >Напитки</option>
                                    <option value="Мясо">Мясо</option>
                                    <option value="Салаты">Салаты</option>
                                </select>
{{--                                <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" required>--}}
                                <datalist id="categories">
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea class="form-control" id="description" name="description" rows="8" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Активен</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">Изменить продукт</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
