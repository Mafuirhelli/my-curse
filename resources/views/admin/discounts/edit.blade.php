@extends('admin.layout')

@section('title', 'Редактирование скидки')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Редактирование скидки</h1>
            <a href="{{ route('admin.discounts') }}" class="btn btn-secondary">Назад</a>
        </div>

        <div class="admin-card">
            <div class="card-body">
                <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Продукт *</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    <option value="">Выберите продукт</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id', $discount->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ number_format($product->price, 2) }} ₽)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="discount_percent" class="form-label">Процент скидки *</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control" id="discount_percent" name="discount_percent" value="{{ old('discount_percent', $discount->discount_percent) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Начало действия *</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $discount->start_date->format('Y-m-d\TH:i')) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">Окончание действия *</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $discount->end_date->format('Y-m-d\TH:i')) }}" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $discount->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Активна</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">Обновить скидку</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
