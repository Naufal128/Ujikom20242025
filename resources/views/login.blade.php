<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>

    <div class="login-container">
        <!-- Person Icon -->
        <i class="bi bi-person-fill login-icon"></i> <!-- Bootstrap icon for person -->

        <h2 class="text-center">Login</h2> <!-- Reduced bottom margin -->
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <!-- Username field -->
        <div class="mb-4">
            <input type="text" class="form-control rounded-pill" id="username" name="username" placeholder="Username" required>
        </div>
        <!-- Password field -->
        <div class="mb-2">
            <input type="password" class="form-control rounded-pill" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="register-link ms-auto">
            <p>Jika anda belum memiliki akun, silahkan <a href="/register">klik di sini</a></p>
        </div>
        <button type="submit" class="btn login-button btn-lg d-block mx-auto w-50 mt-4 rounded-pill">Login</button>
    </form>
    
    <!-- Error Modal -->
@if (session('login_error'))
<div class="modal fade" id="loginErrorModal" tabindex="-1" aria-labelledby="loginErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginErrorModalLabel">Login Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('login_error') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Bootstrap 5.2 JS (optional for Bootstrap components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Auto-show modal script -->
@if (session('login_error'))
<script>
    var myModal = new bootstrap.Modal(document.getElementById('loginErrorModal'));
    myModal.show();
</script>
@endif


    <!-- Bootstrap 5.2 JS (optional for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
