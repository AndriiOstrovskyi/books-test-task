@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список книг</h1>
    <form action="{{ route('books.index') }}" method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Пошук за назвою або автором">
        <button type="submit" class="btn btn-primary mt-2">Пошук</button>
    </form>
    <div class="list-group">
        @foreach ($books as $book)
            <a href="{{ route('books.show', $book->id) }}" class="list-group-item list-group-item-action">
                <h5 class="mb-1">{{ $book->title }}</h5>
                <p class="mb-1">Автор: {{ $book->author }}</p>
                <small>Дата публікації: {{ $book->publication_date }}</small>
                @if ($book->cover_image)
                    <img src="{{ asset($book->cover_image) }}" class="img-thumbnail mt-2" style="max-width: 200px;" alt="Обкладинка книги">
                @endif
                @if ($book->ratings->count() > 0)
                    <p>Середній рейтинг: {{ $book->averageRating() }}</p>
                @else
                    <p>Поки що немає рейтингів</p>
                @endif
            </a>
        @endforeach
    </div>
    <button onclick="location.reload();" class="btn btn-secondary mb-3">Оновити список книг</button>
</div>
<script>
    setInterval(function() {
        location.reload();
    }, 60000);
</script>
@endsection
