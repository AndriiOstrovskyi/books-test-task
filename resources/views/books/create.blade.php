@extends('layouts.app')

@section('content')
<div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-center display-1 mb-4 mt-4" style="font-size: 3rem;">Додати книгу</h1>
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="mb-3 p-4 rounded bg-light">
        @csrf
        <div class="form-group mb-3" style="display: flex;">
            <label for="title" class="form-label" style="max-width: 150px; width: 100%;">Назва книги</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group mb-3" style="display: flex;">
            <label for="author" class="form-label" style="max-width: 150px; width: 100%;">Автор</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="form-group mb-3" style="display: flex;">
            <label for="publication_date" class="form-label" style="max-width: 150px; width: 100%;">Дата публікації</label>
            <input type="date" class="form-control" id="publication_date" name="publication_date" required>
        </div>
        <div class="form-group mb-3" style="display: flex;">
            <label for="cover_image" class="form-label" style="max-width: 150px; width: 100%;">Обкладинка книги</label>
            <input type="file" class="form-control-file" id="cover_image" name="cover_image">
        </div>
        <div class="form-group mb-3" style="display: flex;">
            <label for="description" class="form-label" style="max-width: 150px; width: 100%;">Опис</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-dark text-white p-2 rounded bg-black">Додати книгу</button>
        </div>
    </form>
</div>
@endsection
