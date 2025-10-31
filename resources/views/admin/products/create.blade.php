@extends('admin.layout')

@section('title', 'Создание продукта')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Создание продукта</h1>
            <a href="{{ route('admin.products') }}" class="btn btn-secondary">Назад</a>
        </div>

        <div class="admin-card">
            <div class="card-body">
                <form class="admin-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Название</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Цена</label>
                                <input type="number" step="0.05" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Категория</label>
                                <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" required list="categories">
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
                        <button type="submit" class="btn btn-primary">Создать продукт</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
