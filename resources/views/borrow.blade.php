<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <!-- Bootstrap 5.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
    rel="stylesheet"></head>

<body>

    <!-- Include the Navbar -->
    @include('layouts.navside')

    <!-- Peminjaman Section -->
    <div class="container mt-4">
        <h2 class="mb-4">Peminjaman Buku</h2>

        <!-- Buku Yang Sedang Dipinjam Section -->
        <div class="card shadow mb-3">
            <div class="card-body">
                <h3 class="card-title">Buku Yang Sedang Dipinjam</h3>
                <hr>
                @if ($currentLoans->isEmpty())
                    <p class="text-muted">Anda belum meminjam buku apapun saat ini.</p>
                @else
                    <ul class="list-unstyled">
                        @foreach ($currentLoans as $loan)
                            <li class="mb-3">
                                <h5>Judul Buku: {{ $loan->buku->judul }}</h5>
                                <p>Tanggal Pinjam: {{ \Carbon\Carbon::parse($loan->tanggalpeminjaman)->format('d-m-Y') }}</p>
                                <p>Tanggal Kembali: {{ \Carbon\Carbon::parse($loan->tanggalpengembalian)->format('d-m-Y') }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Riwayat Peminjaman Section -->
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title">Riwayat Peminjaman</h3>
                <hr>
                @if ($loanHistory->isEmpty())
                    <p class="text-muted">Belum ada riwayat peminjaman.</p>
                @else
                    <ul class="list-unstyled">
                        @foreach ($loanHistory as $history)
                            <li class="mb-3">
                                <h5>Judul Buku: {{ $history->buku->judul }}</h5>
                                <p>Tanggal Pinjam: {{ \Carbon\Carbon::parse($history->tanggalpeminjaman)->format('d-m-Y') }}</p>
                                <p>Tanggal Dikembalikan: {{ \Carbon\Carbon::parse($history->tanggalpengembalian)->format('d-m-Y') }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
