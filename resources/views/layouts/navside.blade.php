<!-- Navbar (Dropdown Logout) -->
<nav class="navbar navbar-light sticky-top">
    <div class="container-fluid justify-content-between">
        <!-- Sidebar Toggle for all screens (hamburger icon visible always) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu">
            <span class="bi bi-list"></span> <!-- Using Bootstrap Icons for the hamburger -->
        </button>

        <!-- Centered Logo -->
        <div class="navbar-brand mx-auto">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" height="60px">
        </div>

        <!-- User Profile Icon with Dropdown -->
        <div class="navbar-user d-none d-lg-flex dropdown">
            <!-- Hide on small screens -->
            <span class="dropdown" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person" style="font-size: 50px; color:white;"></i> <!-- Bootstrap icon for user -->
            </span>
            <p class="mb-0 ms-2">{{ session('user_name', 'Guest') }}</p> <!-- Display user name -->

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="/profil">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar Menu (Offcanvas) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <!-- Only visible on small screens -->
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="user-info d-flex align-items-center mb-3">
            <i class="bi bi-person" style="font-size: 100px; color:white;"></i>
            <div>
                <p class="text-light display-6 mb-0">{{ session('user_name', 'Guest') }}</p>
                <p class="text-dark mb-0">{{ session('email', 'email@email.com') }}</p>
            </div>
        </div>
        <ul class="list-unstyled mt-3">
            <li><a href="/profil" class="d-block py-2"><i class="bi bi-person"></i> Profil</a></li>
            <li><a href="/beranda" class="d-block py-2"><i class="bi bi-house-door"></i> Beranda</a></li>
            <li><a href="/peminjaman" class="d-block py-2"><i class="bi bi-book"></i> Peminjaman</a></li>
            <li><a href="/tentangkami" class="d-block py-2"><i class="bi bi-info-circle"></i> Tentang Kami</a></li>
            <li>
                <!-- Using JavaScript to make the "Keluar" link trigger the POST request -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="#" class="d-block py-2"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Keluar <span>&rarr;</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="overdueModal" tabindex="-1" aria-labelledby="overdueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Changed to modal-lg for a larger modal -->
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark"> <!-- Added background color to header -->
          <h5 class="modal-title" id="overdueModalLabel">Keterlambatan Pengembalian Buku</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-3">Buku-buku berikut terlambat dikembalikan. Kami harap anda segera mengembalikannya</p>
          <ul id="overdueBooksList" class="list-group">
            <!-- Overdue books will be added here -->
          </ul>
        </div>
        <div class="modal-footer justify-content-between"> <!-- Centered the buttons -->
          <span class="text-muted">Harap mengembalikan buku-buku ini untuk menghindari penalti dari kami.</span>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script>
    function checkForOverdueBooks() {
        // Check if the modal has already been shown in this session
        // if (localStorage.getItem('overdueModalShown') === 'true') {
        //     return; // Don't show the modal again
        // }

        // Make an API call to the backend to check for overdue books
        fetch('/check-overdue')
        .then(response => {
        console.log("Response received: ", response);
        return response.json();
    })
    .then(data => {
        console.log("Parsed data: ", data); // Check what you receive here

        if (data.hasOverdue) {
            let overdueBooksList = document.getElementById('overdueBooksList');
            overdueBooksList.innerHTML = ''; // Clear previous list entries

            data.overdueBooks.forEach(book => {
                let listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.textContent = `Judul: ${book.judul}, Tanggal Pengembalian: ${book.tanggalpengembalian}`;
                overdueBooksList.appendChild(listItem);
            });

            // Show the overdue modal
            let overdueModal = new bootstrap.Modal(document.getElementById('overdueModal'));
            console.log("Modal open now");
            overdueModal.show();
        } else {
            console.log("No overdue books.");
        }
    })
    .catch(error => console.error('Error checking overdue books:', error));
}

    // Call the checkForOverdueBooks function on page load or when the user logs in
    window.onload = checkForOverdueBooks;
</script>
