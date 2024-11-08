<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku</title>
    <!-- Bootstrap 5.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<style>
    /* Star Rating */
    .rating {
        display: inline-flex;
        /* Keep it inline */
        flex-direction: row-reverse;
        /* Visually reverse stars for hover behavior */
        font-size: 2.75rem;
        gap: 5px;
        /* Optional: to adjust spacing between stars */
    }

    .rating input {
        display: none;
    }

    .rating label {
        color: #ccc;
        cursor: pointer;
    }

    .rating input:checked~label {
        color: #ffcc00;
        /* Highlight selected stars */
    }

    .rating label:hover,
    .rating label:hover~label {
        color: #ffcc00;
        /* Highlight on hover */
    }
</style>

<body>

    <!-- Include the Navbar -->
    @include('layouts.navside')

    @if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif


    <!-- Check if there are overdue books in the session -->
    @if (session('overdue_books'))
    <!-- Overdue Reminder Modal -->
    <div class="modal fade" id="overdueReminderModal" tabindex="-1" aria-labelledby="overdueReminderLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="overdueReminderLabel">Overdue Books Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You have the following overdue books:</p>
                    <ul>
                        @foreach (session('overdue_books') as $peminjaman)
                        <li>{{ $peminjaman->buku->judul }} - Due on {{ $peminjaman->tanggalpengembalian }}</li>
                        @endforeach
                    </ul>
                    <p>Please return them as soon as possible to avoid further issues.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Trigger the modal on page load -->
    <script>
        window.onload = function() {
        var overdueModal = new bootstrap.Modal(document.getElementById('overdueReminderModal'));
        overdueModal.show();
    }
    </script>
    @endif
    </div>

    @php
    // Clear overdue_books from the session after displaying the modal
    session()->forget('overdue_books');
    @endphp

    <!-- Book Details Section -->
    <div class="container mt-5">
        <div class="card shadow p-4">
            <div class="row">
                <!-- Book Image -->
                <div class="col-md-4">
                    <img src="{{ asset(( $book->foto )) }}" alt="Book Cover" class="img-fluid book-image"
                        style="height: 30rem;">
                </div>
                <!-- Book Info -->
                <div class="col-md-8">
                    <h1><strong>{{ $book->judul }}</strong></h1> <!-- Book Title -->
                    <p><strong>Penulis:</strong> {{ $book->penulis }}</p> <!-- Book Author -->
                    <p><strong>Penerbit:</strong> {{ $book->penerbit }}</p> <!-- Publisher -->
                    <p><strong>Tahun Terbit:</strong> {{ $book->tahunterbit }}</p> <!-- Publish Year -->

                    <!-- Categories -->
                    <h3 class="mt-4"><strong>Kategori: </strong>@foreach ($book->kategoris as $kategori)
                        {{ $kategori->namakategori }}@if(!$loop->last), @endif
                        @endforeach</h3>

                    <h3 class="mt-4"><strong>Deskripsi</strong></h3>
                    <p>{{ $book->deskripsi }}</p> <!-- Description of the book -->

                    <!-- Borrow/Return Button -->
                    <div class="d-flex align-items-center">
                        <!-- Use a flexbox to align items -->
                        @if ($peminjaman)
                        <!-- If the book is currently borrowed by the user, show return button -->
                        <form action="{{ route('book.return', $book->bukuid) }}" method="POST" class="me-2">
                            <!-- Add margin for spacing -->
                            @csrf
                            <button class="btn btn-custom btn-lg mt-4 rounded-pill" type="submit">Kembalikan
                                Buku</button>
                        </form>
                        @else
                        <!-- Otherwise, show the borrow button that triggers a modal -->
                        <button class="btn btn-custom btn-lg mt-4 rounded-pill" type="button" data-bs-toggle="modal"
                            data-bs-target="#borrowModal">
                            Pinjam Buku
                        </button>
                        @endif

                        <button class="btn btn-custom btn-lg mt-4 rounded-pill ms-3" type="button"
                            onclick="document.getElementById('addToKoleksiForm').submit()">Tambah Ke Koleksi +</button>

                        <form id="addToKoleksiForm" action="{{ route('book.addToKoleksi', $book->bukuid) }}"
                            method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </div>

                <!-- Comment and Rating Section -->
                <div class="mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Tulis Ulasan</h3>
                    </div>

                    @php
                    // Check if the user has borrowed or returned the book
                    $userHasBorrowedOrReturned = \App\Models\Peminjaman::where('bukuid', $book->bukuid)
                    ->where('userid', Auth::id())
                    ->whereIn('statuspeminjaman', ['Dipinjam', 'Kembali'])
                    ->exists();

                    // Check if the user has already submitted a review for this book
                    $userHasReviewed = \App\Models\Ulasan::where('bukuid', $book->bukuid)
                    ->where('userid', Auth::id())
                    ->exists();
                    @endphp

                    @if ($userHasBorrowedOrReturned && !$userHasReviewed)
                    <!-- Allow comments when the book is borrowed or returned and user hasn't reviewed yet -->
                    <form action="{{ route('book.storeUlasan', $book->bukuid) }}" method="POST">
                        @csrf
                        <!-- Rating (Stars) from Left to Right -->
                        <div class="d-flex align-items-center">
                            <div class="rating me-4" id="rating-stars">
                                <input type="radio" id="star5" name="rating" value="5" /><label for="star5"
                                    title="5 stars">&#9733;</label>
                                <input type="radio" id="star4" name="rating" value="4" /><label for="star4"
                                    title="4 stars">&#9733;</label>
                                <input type="radio" id="star3" name="rating" value="3" /><label for="star3"
                                    title="3 stars">&#9733;</label>
                                <input type="radio" id="star2" name="rating" value="2" /><label for="star2"
                                    title="2 stars">&#9733;</label>
                                <input type="radio" id="star1" name="rating" value="1" /><label for="star1"
                                    title="1 star">&#9733;</label>
                            </div>
                        </div>

                        <!-- Comment Box -->
                        <div class="mt-4 w-100">
                            <textarea class="form-control" name="ulasan" id="comment" rows="5"
                                placeholder="Tulis ulasan Anda di sini..." required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-3">
                            <button class="btn btn-custom btn-lg rounded-pill" type="submit">Kirim Ulasan</button>
                        </div>
                    </form>
                    @elseif ($userHasReviewed)
                    <!-- If the user has already reviewed, display a message -->
                    <p>Anda sudah memberikan ulasan untuk buku ini. Jika ingin mengubahnya, silahkan hapus ulasan
                        sebelumnya.</p>
                    @else
                    <p>Anda harus pernah meminjam atau mengembalikan buku ini untuk memberikan ulasan.</p>
                    @endif


                    <!-- Existing Comments Section -->
                    <div class="mt-5">
                        <h3 class="mb-4">Ulasan Pembaca</h3>

                        @foreach ($ulasan as $review)
                        <div class="card mb-3 shadow">
                            <div class="card-body">
                                <h5 class="card-title">{{ $review->user->username }}</h5>

                                <!-- Star Rating -->
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                    <!-- Loop from 5 to 1 to display stars in correct order -->
                                    <span class="{{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}">
                                        &#9733;
                                    </span>
                                    @endfor
                                </div>

                                <p class="card-text mt-2">{{ $review->ulasan }}</p>
                                <p class="text-muted small">{{ $review->created_at }}</p>

                                <!-- If the comment belongs to the logged-in user, show edit/delete options -->
                                @if (auth()->user()->userid == $review->userid)
                                <div class="d-flex justify-content-end">
                                    <!-- Edit Button (opens edit modal) -->
                                    <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $review->ulasanid }}">Edit</button>

                                    <!-- Delete Button (opens delete modal) -->
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $review->ulasanid }}">Hapus</button>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $review->ulasanid }}" tabindex="-1"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Ulasan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form
                                        action="{{ route('book.updateUlasan', ['bukuid' => $book->bukuid, 'ulasanid' => $review->ulasanid]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <!-- Star Rating -->
                                            <div class="rating">
                                                <input type="radio" id="star5_{{ $review->ulasanid }}" name="rating"
                                                    value="5" {{ $review->rating == 5 ? 'checked' : '' }} /><label
                                                    for="star5_{{ $review->ulasanid }}">&#9733;</label>
                                                <input type="radio" id="star4_{{ $review->ulasanid }}" name="rating"
                                                    value="4" {{ $review->rating == 4 ? 'checked' : '' }} /><label
                                                    for="star4_{{ $review->ulasanid }}">&#9733;</label>
                                                <input type="radio" id="star3_{{ $review->ulasanid }}" name="rating"
                                                    value="3" {{ $review->rating == 3 ? 'checked' : '' }} /><label
                                                    for="star3_{{ $review->ulasanid }}">&#9733;</label>
                                                <input type="radio" id="star2_{{ $review->ulasanid }}" name="rating"
                                                    value="2" {{ $review->rating == 2 ? 'checked' : '' }} /><label
                                                    for="star2_{{ $review->ulasanid }}">&#9733;</label>
                                                <input type="radio" id="star1_{{ $review->ulasanid }}" name="rating"
                                                    value="1" {{ $review->rating == 1 ? 'checked' : '' }} /><label
                                                    for="star1_{{ $review->ulasanid }}">&#9733;</label>
                                            </div>

                                            <!-- Comment Box -->
                                            <div class="mt-3">
                                                <textarea class="form-control" name="ulasan" rows="4"
                                                    required>{{ $review->ulasan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $review->ulasanid }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Hapus Ulasan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form
                                        action="{{ route('book.deleteUlasan', ['bukuid' => $book->bukuid, 'ulasanid' => $review->ulasanid]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus ulasan ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Borrow Book Modal -->
                    <div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="borrowModalLabel">Konfirmasi Peminjaman Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                     <form id="borrowForm" action="{{ route('book.borrow', $book->bukuid) }}"
                                        method="POST" onsubmit="return validateForm()">
                                        @csrf

                                    Apakah Anda yakin ingin meminjam buku "<strong>{{ $book->judul }}</strong>"?

                                    <!-- Display a message if book is out of stock -->
                                    @if ($book->stok == 0)
                                    <div class="alert alert-warning mt-3">
                                        Buku ini sedang tidak tersedia untuk dipinjam.
                                    </div>
                                    @else
                                    <div class="mt-3">
                                        <label for="jumlahPinjam" class="form-label">Jumlah Buku:</label>
                                        <input type="number" class="form-control" id="jumlahPinjam" name="jumlah"
                                            min="1" max="{{ $book->stok }}" required>
                                        <div class="form-text">Maksimum yang dapat dipinjam: {{ $book->stok }}</div>
                                    </div>

                                    <div class="mt-3">
                                        <label for="tanggalpengembalian" class="form-label">Pilih Tanggal
                                            Pengembalian:</label>
                                        <input type="date" class="form-control" id="tanggalpengembalian"
                                            name="tanggalpengembalian" required>
                                        <div class="form-text">Pilih tanggal maksimal 7 hari dari hari ini.</div>
                                    </div>
                                    @endif

                                    <div id="error-message" class="alert alert-danger mt-3" style="display: none;">
                                        <strong>Gagal:</strong> Mohon pastikan semua isian valid.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-danger"
                                        data-bs-dismiss="modal">Batal</button>

                                    <!-- Disable the form submission button if stock is zero -->
                                   
                                    <form id="borrowForm" action="{{ route('book.borrow', $book->bukuid) }}"
                                        method="POST" onsubmit="return validateForm()">
                                        @csrf
                                        
                                        @if ($book->stok > 0)
                                        <button type="submit" class="btn btn-custom">Ya, Pinjam Buku</button>
                                        @else
                                        <button type="button" class="btn btn-custom" disabled>Stok Habis</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Function to set the form data when confirming the borrow action
    function setJumlah() {
        const jumlahInput = document.getElementById('jumlahPinjam');
        const modalJumlahInput = document.getElementById('modalJumlah');
        const tanggalPengembalianInput = document.getElementById('tanggalpengembalian');
        const modalTanggalPengembalianInput = document.getElementById('modalTanggalPengembalian');

        // Assign value to the hidden input for jumlah
        modalJumlahInput.value = jumlahInput.value;

        // Assign value to the hidden input for tanggalpengembalian
        modalTanggalPengembalianInput.value = tanggalPengembalianInput.value;
    }

    // Function to limit the tanggalpengembalian to today's date and max 7 days
    function limitTanggalPengembalian() {
        const tanggalPengembalianInput = document.getElementById('tanggalpengembalian');

        // Get today's date
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        const yyyy = today.getFullYear();
        const todayStr = yyyy + '-' + mm + '-' + dd;

        // Calculate the maximum date (today + 7 days)
        const maxDate = new Date(today);
        maxDate.setDate(maxDate.getDate() + 7);
        const ddMax = String(maxDate.getDate()).padStart(2, '0');
        const mmMax = String(maxDate.getMonth() + 1).padStart(2, '0');
        const yyyyMax = maxDate.getFullYear();
        const maxDateStr = yyyyMax + '-' + mmMax + '-' + ddMax;

        // Set the min and max attributes for the date input
        tanggalPengembalianInput.setAttribute('min', todayStr);
        tanggalPengembalianInput.setAttribute('max', maxDateStr);
    }

    // Validate the form before submission
    function validateForm() {
        const jumlahInput = document.getElementById('jumlahPinjam').value;
        const tanggalPengembalianInput = document.getElementById('tanggalpengembalian').value;
        const errorMessage = document.getElementById('error-message');

        // Check if jumlah is valid (not zero and within stock)
        if (jumlahInput === '' || jumlahInput <= 0 || jumlahInput > {{ $book->stok }}) {
            errorMessage.textContent = 'Jumlah yang Anda pilih tidak valid.';
            errorMessage.style.display = 'block';
            return false; // Prevent form submission
        }

        // Check if tanggal pengembalian is selected
        if (tanggalPengembalianInput === '') {
            errorMessage.textContent = 'Tanggal pengembalian harus dipilih.';
            errorMessage.style.display = 'block';
            return false; // Prevent form submission
        }

        // No errors, hide the error message
        errorMessage.style.display = 'none';
        return true;
    }

    // Initialize the date limits when the modal is shown
    document.getElementById('borrowModal').addEventListener('shown.bs.modal', limitTanggalPengembalian);
                    </script>
                    
                    <!-- Bootstrap 5.2 JS Bundle -->
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
</body>

</html>