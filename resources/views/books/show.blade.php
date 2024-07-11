@extends('layouts.app')

@section('content')
<div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-center display-1 mb-4 mt-4" style="font-size: 3rem;">{{ $book->title }}</h1>

    <div class="text-center">
        <div class="mb-4 p-4 bg-black rounded text-white" style="max-width: 700px; margin: 0 auto">
            <p>Автор: {{ $book->author }}</p>
            <p>Дата публікації: {{ $book->publication_date }}</p>
            @if ($book->cover_image)
                <img src="{{ asset($book->cover_image) }}" class="img-thumbnail mt-2" style="width: 100%;" alt="Обкладинка книги">
            @endif
            <p>{{ $book->description }}</p>

            @if ($book->ratings->count() > 0)
                <p>Середній рейтинг: {{ $book->averageRating() }}</p>
            @else
                <p>Поки що немає рейтингів.</p>
            @endif
        </div>
    </div>

    @auth
        <form action="{{ route('books.rate', $book->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="form-group">
                <label for="rating">Рейтинг:</label>
                <select name="rating" id="rating" class="form-control" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <button type="submit" class="btn btn-primary text-white p-2 rounded bg-black">Залишити рейтинг</button>
            </div>
            
        </form>
    @else
        <p>Для залишення рейтингу потрібно <a href="{{ route('login') }}" style="color: orange;">увійти</a> або <a href="{{ route('register') }}" style="color: orange;">зареєструватися</a>.</p>
    @endauth

    @auth
        <form action="{{ route('books.comment', $book->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">Коментар:</label>
                <textarea name="content" id="content" rows="3" class="form-control" required style="width: 100% !important"></textarea>
            </div>
            <button type="submit" class="btn btn-primary text-white p-2 rounded bg-black">Залишити коментар</button>
        </form>
    @else
        <p>Для залишення коментаря потрібно <a href="{{ route('login') }}" style="color: orange;">увійти</a> або <a href="{{ route('register') }}" style="color: orange;">зареєструватися</a>.</p>
    @endauth

    <div id="updatedBooks" class="mt-5">
        <h2>Оновлювані книги</h2>
        <ul id="bookList" style="display: flex; flex-wrap: wrap; gap: 1rem"></ul>
    </div>

    <div class="text-center">
        <button onclick="fetchUpdatedBooks({{ $book->id }})" class="btn btn-secondary mt-3 mb-3 p-2 rounded bg-black text-white">Оновити список книг</button>
    </div>


</div>

<script>

    function fetchUpdatedBooks(bookId) {
        fetch(`{{ route('books.updatedList', ['book' => ':book_id']) }}`.replace(':book_id', bookId))
            .then(response => response.json())
            .then(data => {
                const bookListElement = document.getElementById('bookList');
                bookListElement.innerHTML = '';

                data.forEach(book => {
                    const listItem = document.createElement('div');
                    listItem.classList.add('col', 'p-3', 'bg-black', 'rounded', 'text-white', 'books_card');

                    const innerContent = `
                        <div class="list-group-item list-group-item-action">
                            <a href="{{ url('books') }}/${book.id}">
                                <h5 class="mb-1 text-center">${book.title}</h5>
                                <p class="mb-1">Автор: ${book.author}</p>
                                <small>Дата публікації: ${book.publication_date}</small>
                                ${book.cover_image ? `<img src="{{ asset('${book.cover_image}') }}" class="img-thumbnail mt-2" style="width: 100%;" alt="Обкладинка книги">` : ''}
                                ${book.ratings_count > 0 ? `<p>Середній рейтинг: ${book.average_rating}</p>` : '<p>Поки що немає рейтингів</p>'}
                            </a>
                        </div>
                    `;
                    listItem.innerHTML = innerContent;
                    bookListElement.appendChild(listItem);
                });
            })
            .catch(error => console.error('Помилка при отриманні оновленого списку книг:', error));
    }


    setInterval(fetchUpdatedBooks, 10000);

    fetchUpdatedBooks();
</script>

@endsection
