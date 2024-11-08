<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book App</title>
    <!-- Bootstrap 5.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
</head>

<body>

    <!-- Include the Navbar -->
    @include('layouts.navside')

    <!-- Inspirational Carousel -->
    <div class="container mt-3">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/lib1.jpeg" class="d-block w-100" alt="...">
                    <div class="quote">"Ada dua motif untuk membaca buku. Pertama, kau menikmatinya dan yang lain, kau
                        bisa menyombongkannya."</div>
                    <div class="quote-footer"><small><em>- Bertrand Russell</small></em></div>
                </div>
                <div class="carousel-item">
                    <img src="img/lib2.jpg" class="d-block w-100" alt="...">
                    <div class="quote">"Makin aku banyak membaca, makin aku banyak berpikir; makin aku banyak belajar,
                        makin aku sadar bahwa aku tak mengetahui apa pun."</div>
                    <div class="quote-footer"><small><em>- Voltaire</small></em></div>
                </div>
                <div class="carousel-item">
                    <img src="img/lib3.png" class="d-block w-100" alt="...">
                    <div class="quote">"Ilmu itu ada di mana-mana, pengetahuan di mana-mana tersebar, kalau kita
                        bersedia membaca, dan bersedia mendengar."</div>
                    <div class="quote-footer"><small><em>- Felix Siauw</small></em></div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-bar mt-4">
        <input type="text" id="search-input" placeholder="Cari buku..." class="form-control search-input shadow-sm"
            onkeyup="searchBooks()">
    </div>

    <!-- Category Buttons -->
    <div class="category-buttons mt-3 d-flex justify-content-center">
        <button class="btn category-btn" onclick="filterBooksByCategory('all')">All</button>
        @if($categories->isNotEmpty())
        @foreach ($categories as $category)
        <button class="btn category-btn" onclick="filterBooksByCategory('{{ $category->namakategori }}')">{{
            $category->namakategori }}</button>
        @endforeach
        @else
        <p>No categories available.</p>
        @endif
    </div>

    <!-- Book Cards -->
    <div class="book-cards container mt-4">
        <div class="row" id="book-list">
            @if($books->isNotEmpty())
            @foreach ($books as $book)
            <div class="col-md-3 mb-4 book-item"
                data-categories="{{ implode(', ', $book->kategoris->pluck('namakategori')->toArray()) }}">
                <a href="/book/{{ $book->bukuid }}" class="text-decoration-none text-dark">
                    <div class="book-card card h-100">
                        <img src="{{ $book->foto ?: 'https://via.placeholder.com/300x400' }}" alt="Book Cover"
                        class="card-img-top"> <!-- Dynamic image source -->
                        <div class="card-body d-flex flex-column">
                            <!-- Make card body a flex column -->
                            @if($book->kategoris->isNotEmpty())
                            <p class="card-text"><small>Kategori:
                                    @foreach ($book->kategoris as $kategori)
                                    {{ $kategori->namakategori }}@if(!$loop->last), @endif
                                    @endforeach
                                </small></p>
                            @else
                            <p class="card-text"><small>Kategori: Tidak ada kategori</small></p>
                            @endif
                            <p class="card-text"><em><small>{{ $book->penulis }}</small></em></p>
                            <p class="card-text fs-4 book-title"><strong>{{ $book->judul }}</strong></p>
                            <!-- Added flex-grow-1 -->
                            <p class="card-text"><small>Penerbit: {{ $book->penerbit }}</small></p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            @else
            <p>No books available.</p>
            @endif
        </div>
    </div>

    <!-- Bootstrap 5.2 JS (required for the hamburger menu) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for search and category filter -->
    <script>
        // Function to search books by title
    function searchBooks() {
    const input = document.getElementById('search-input').value.toLowerCase();
    const books = document.querySelectorAll('.book-item');

    books.forEach(book => {
        const title = book.querySelector('.book-title').innerText.toLowerCase();
        if (title.includes(input)) {
            book.style.display = 'block';
        } else {
            book.style.display = 'none';
        }
    });
}


        // Function to filter books by category
        function filterBooksByCategory(category) {
            const books = document.querySelectorAll('.book-item');

            books.forEach(book => {
                const categories = book.getAttribute('data-categories').toLowerCase().split(', ');
                
                if (category === 'all' || categories.includes(category.toLowerCase())) {
                    book.style.display = 'block';
                } else {
                    book.style.display = 'none';
                }
            });
        }
    </script>

</body>

</html>