<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil User</title>
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
    <style>
        .profile-icon {
            font-size: 80px;
            color: #ff8f28;
        }

        /* New styling for personal collection cards */
        .koleksi-card {
            background-color: #f9f9f9;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .koleksi-card:hover {
            transform: scale(1.03);
        }

        .koleksi-card img {
            border-radius: 10px;
            height: 150px;
            object-fit: cover;
        }

        .koleksi-details {
            padding-left: 15px;
        }

        .koleksi-details h5 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .koleksi-details p {
            font-size: 0.9rem;
            color: #666;
        }

        .btn-delete {
            font-size: 0.8rem;
            padding: 5px 10px;
        }
    </style>
</head>

<body>

    @include('layouts.navside')

    <!-- Centered Profile Card -->
    <div class="container profile-container">
        <div class="row">
            <!-- Profile Card -->
            <div class="col-md-6">
                <div class="profile-card shadow">
                    <div class="profile-image">
                        <i class="bi bi-person-circle profile-icon"></i>
                        <p class="profile-name">{{ $user->username }}</p> <!-- User full name -->
                    </div>

                    <div class="profile-details">
                        <p><i class="bi bi-person"></i> {{ $user->namalengkap ?? 'Not Available' }}</p>
                        <p><i class="bi bi-telephone"></i> {{ $user->telepon ?? 'Not Available' }}</p>
                        <p><i class="bi bi-house-door"></i> {{ $user->alamat ?? 'Not Available' }}</p>
                        <p><i class="bi bi-envelope"></i> {{ $user->email ?? 'Not Available' }}</p>
                    </div>
                </div>
            </div>

            <!-- Koleksi Pribadi (Personal Collection) -->
            <div class="col-md-6 mt-3">
                <h3 class="mb-4">Koleksi Pribadi</h3>

                <div class="row">
                    @forelse ($koleksi as $item)
                    <div class="col-md-12 mb-3">
                        <!-- Link to book details page -->
                        <a href="{{ url('/book/' . $item->bukuid) }}" class="text-decoration-none text-dark">
                            <div class="card koleksi-card shadow-sm d-flex flex-row align-items-center p-3">
                                <!-- Book Cover Image -->
                                <img src="{{ asset($item->buku->foto) }}" alt="{{ $item->buku->judul }}"
                                    class="img-fluid" style="width: 100px;">
                                <!-- Book Details -->
                                <div class="koleksi-details">
                                    <h5>{{ $item->buku->judul }}</h5>
                                    <p>{{ $item->buku->penulis }}</p>
                                    <!-- Delete Button (placed outside the link to avoid conflicting with the clickable area) -->
                        <form action="{{ route('koleksi.delete', $item->koleksiid) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-delete" type="submit">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <p>Anda belum menambahkan buku ke dalam koleksi pribadi.</p>
                    @endforelse
                </div>
            </div>


            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>