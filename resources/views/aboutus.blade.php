<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <!-- Bootstrap 5.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
</head>

<body>

    <!-- Include the Navbar -->
    @include('layouts.navside')

    <!-- About Us Section with Card -->
    <div class="container mt-4 text-center">
        <!-- Logo Image above the card -->
        <img src="img/logo.png" alt="Logo" height="120px" class="mb-4" style="background-color: #ff8f28; border-radius: 10px;">
        
        <div class="card shadow-sm">
            <div class="card-body m-4">
                <h1 class="card-title">Tentang Kami</h1>
                <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Aenean varius lorem sed tortor tincidunt, 
                    nec vestibulum nisi elementum. Vivamus id lectus non orci interdum suscipit.
                </p>
                <hr>
                <h3 class="card-subtitle mb-3">Visi Kami</h3>
                <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nec justo quis urna iaculis gravida at eget turpis. 
                    Suspendisse potenti. Etiam ullamcorper nisi non justo gravida fermentum.
                </p>
                <hr>
                <h3 class="card-subtitle mb-3">Misi Kami</h3>
                <p class="card-text">
                    - Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br>
                    - Integer non felis nec mi viverra gravida non at lectus.<br>
                    - Vestibulum ante ipsum primis in faucibus orci luctus et ultrices.
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
