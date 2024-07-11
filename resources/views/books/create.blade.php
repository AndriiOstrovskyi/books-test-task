@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Додати книгу</h1>
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Назва книги</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="author">Автор</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="form-group">
            <label for="publication_date">Дата публікації</label>
            <input type="date" class="form-control" id="publication_date" name="publication_date" required>
        </div>
        <div class="form-group">
            <label for="cover_image">Обкладинка книги</label>
            <input type="file" class="form-control-file" id="cover_image" name="cover_image">
        </div>
        <div class="form-group">
            <label for="description">Опис</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Додати книгу</button>
    </form>
</div>
@endsection
