<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        rel="stylesheet">
    <style>
        /* Optional custom styles to improve card appearance */
        .login-container { 
            margin: auto;
            padding: 100px;
        }  
    </style>
</head>

<body>

    <div class="login-container mb-5">
        <!-- Person Icon -->
        <i class="bi bi-person-fill login-icon"></i> <!-- Bootstrap icon for person -->

        <h2 class="text-center mb-3">Register</h2>
        <form id="registerForm" action="{{ route('register') }}" method="POST">
            @csrf
            <!-- Username field -->
            <div class="mb-3">
                <input type="text" class="form-control rounded-pill" id="username" name="username" placeholder="Username" required>
            </div>
            <!-- Full Name field -->
            <div class="mb-3">
                <input type="text" class="form-control rounded-pill" id="namalengkap" name="namalengkap" placeholder="Full Name" required>
            </div>
            <!-- Email field -->
            <div class="mb-3">
                <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Email" required>
            </div>
            <!-- Address field -->
            <div class="mb-3">
                <input type="text" class="form-control rounded-pill" id="alamat" name="alamat" placeholder="Address" required>
            </div>
            <!-- Phone number field -->
            <div class="mb-3">
                <input type="text" class="form-control rounded-pill" id="telepon" name="telepon" placeholder="Phone Number" required>
            </div>
            <!-- Password field -->
            <div class="mb-3">
                <input type="password" class="form-control rounded-pill" id="password" name="password" placeholder="Password" required>
            </div>
            <!-- Password confirmation field -->
            <div class="mb-3">
                <input type="password" class="form-control rounded-pill" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
            </div>
            <div class="login-link ms-auto mb-2">
                <p>Sudah memiliki akun? Silahkan <a href="/login">klik di sini</a></p>
            </div>
            <!-- Submit button placed within the card -->
            <button type="submit" class="btn login-button btn-lg d-block mx-auto w-100 mt-3 rounded-pill">Register</button>
        </form>
    </div>

    <!-- Bootstrap 5.2 JS (optional for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            if (password.length < 8) {
                event.preventDefault(); // Prevent form submission
                alert('Password must be at least 8 characters long.'); // Show an alert
            }
        });
    </script>

</body>

</html>
