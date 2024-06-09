@extends('template.main')

@section('style')
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
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Login Section -->
            <div class="col-md-6 login-section">
                <h2>Selamat Datang</h2>
                <p>Mulai langkahkan beberapa transaksi untuk menunaikan Qurban</p>
                <form method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
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
                <a href="/user/register" class="d-block mt-2">Belum punya akun?</a>
            </div>
            <!-- Image Section -->
            <div class="col-md-6 bg-image"></div>
        </div>
    </div>
@endsection
