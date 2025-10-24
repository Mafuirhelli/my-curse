@extends('template')
@section('title')
    <title>{{ isset($product) ? 'Редактирование продукта' : 'Добавление продукта' }}</title>
@endsection
@section('content')
    <div class="container mt-4">
        <h1>{{ isset($product) ? 'Редактирование продукта' : 'Добавление продукта' }}</h1>

        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Цена</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Категория</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ (old('category', $product->category ?? '') == $category) ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Изображение</label>
                <input type="file" class="form-control" id="image" name="image">
                @if(isset($product) && $product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px;">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Обновить' : 'Создать' }}</button>
            <a href="{{ route('admin.products') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
