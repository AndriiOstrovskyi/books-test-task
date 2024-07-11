@extends('layouts.app')

@section('content')
<div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-center display-1 mb-4 mt-4" style="font-size: 3rem;">Список книг</h1>
    <form action="{{ route('books.index') }}" method="GET" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Пошук за назвою або автором" style="flex-grow: 1; width: calc(100% - 100px);">
        <button type="submit" class="btn btn-dark text-white p-2 rounded bg-black">Пошук</button>
    </form>
    
    <div class="row" style="display: flex; flex-wrap: wrap; gap: 1rem;">
        @foreach ($books as $book)
            <div class="col p-3 bg-black rounded text-white books_card">
                <div class="list-group-item list-group-item-action">
                    <a href="{{ route('books.show', $book->id) }}">
                        <h5 class="mb-1 text-center">{{ $book->title }}</h5>
                        <p class="mb-1">Автор: {{ $book->author }}</p>
                        <small>Дата публікації: {{ $book->publication_date }}</small>
                        @if ($book->cover_image)
                            <img src="{{ asset($book->cover_image) }}" class="img-thumbnail mt-2" style="width: 100%;" alt="Обкладинка книги">
                        @endif
                        @if ($book->ratings->count() > 0)
                            <p>Середній рейтинг: {{ $book->averageRating() }}</p>
                        @else
                            <p>Поки що немає рейтингів</p>
                        @endif
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center">
        <button onclick="location.reload();" class="btn btn-secondary mt-3 mb-3 p-2 rounded bg-black text-white">Оновити список книг</button>
    </div>

    <div class="d-flex justify-content-center mt-4 mb-4">
        {{ $books->links() }}
    </div>
</div>
<script>
    setInterval(function() {
        location.reload();
    }, 60000);
</script>
@endsection
