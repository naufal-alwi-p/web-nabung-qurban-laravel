<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qurban Kolektif</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-image {
            background-image: url('/assets/masjif.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        .login-section {
            background-color: white;
            padding: 20px;
        }
        .navbar {
            background-color: #b4f1be;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Qurban Kolektif</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="#">Cara Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><b>Login</b></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Login Section -->
            <div class="col-md-6 login-section">
                <h2>Selamat Datang</h2>
                <p>Mulai langkahkan beberapa transaksi untuk menunaikan Qurban</p>
                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="pwd" placeholder="Enter password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @error('login')
                        <div class="text-danger mb-3">
                            {{ $message }}
                        </div>
                    @enderror
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </form>
                <a href="#" class="d-block mt-2">Belum punya akun?</a>
            </div>
            <!-- Image Section -->
            <div class="col-md-6 bg-image"></div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
