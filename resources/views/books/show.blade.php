@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $book->title }}</h1>
    <p>Автор: {{ $book->author }}</p>
    <p>Дата публікації: {{ $book->publication_date }}</p>
    @if ($book->cover_image)
        <img src="{{ asset($book->cover_image) }}" class="img-thumbnail mt-2" style="max-width: 200px;" alt="Обкладинка книги">
    @endif
    <p>{{ $book->description }}</p>

    <!-- Форма для рейтингу -->
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
            </div>
            <button type="submit" class="btn btn-primary">Залишити рейтинг</button>
        </form>
    @else
        <p>Для залишення рейтингу потрібно <a href="{{ route('login') }}">увійти</a>.</p>
    @endauth

    <!-- Відображення середнього рейтингу -->
    @if ($book->ratings->count() > 0)
        <p>Середній рейтинг: {{ $book->averageRating() }}</p>
    @else
        <p>Поки що немає рейтингів.</p>
    @endif

    <!-- Форма для коментаря -->
    @auth
        <form action="{{ route('books.comment', $book->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">Коментар:</label>
                <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Залишити коментар</button>
        </form>
    @else
        <p>Для залишення коментаря потрібно <a href="{{ route('login') }}">увійти</a>.</p>
    @endauth

    <button onclick="fetchUpdatedBooks({{ $book->id }})" class="btn btn-secondary mb-3">Оновити список книг</button>

    <!-- Список оновлюваних книг -->
    <div id="updatedBooks" class="mt-5">
        <h2>Оновлювані книги</h2>
        <ul id="bookList">
            <!-- Сюди будуть додані книги через JavaScript -->
        </ul>
    </div>
</div>

<script>
    // Функція для отримання оновленого списку книг

    function fetchUpdatedBooks(bookId) {
        fetch(`{{ route('books.updatedList', ['book' => ':book_id']) }}`.replace(':book_id', bookId))
            .then(response => response.json())
            .then(data => {
                const bookListElement = document.getElementById('bookList');
                bookListElement.innerHTML = '';
                data.forEach(book => {
                    const listItem = document.createElement('li');
                    
                    // Додаємо посилання на сторінку книги
                    const link = document.createElement('a');
                    link.href = `{{ url('books') }}/${book.id}`;
                    link.textContent = `${book.title} - ${book.author}`;
                    listItem.appendChild(link);

                    // Додаємо картинку, якщо вона є
                    if (book.cover_image) {
                        const image = document.createElement('img');
                        image.src = `{{ asset(':cover_image') }}`.replace(':cover_image', book.cover_image);
                        image.alt = 'Обкладинка книги';
                        image.style.maxWidth = '100px'; // Змініть ширину за потребою
                        listItem.appendChild(image);
                    }

                    bookListElement.appendChild(listItem);
                });
            })
            .catch(error => console.error('Помилка при отриманні оновленого списку книг:', error));
    }

    setInterval(fetchUpdatedBooks, 10000);

    fetchUpdatedBooks();
</script>

@endsection
