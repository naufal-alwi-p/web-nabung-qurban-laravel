@extends('template.main')

@section('content')
    <h1 class="text-center my-4">Form Registrasi Akun</h1>

    <div class="container-sm">
        <form method="post">
            @csrf
            <div class="mb-3">
                <label for="nik" class="form-label">Nomor KTP (NIK):</label>
                <input type="number" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror">
                @error('nik')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" name="name" id="nama" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon:</label>
                <input type="tel" name="telepon" id="telepon" pattern="[0-9]{11,15}" class="form-control @error('telepon') is-invalid @enderror">
                @error('telepon')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pw" class="form-label">Password:</label>
                <input type="password" name="password" id="pw" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pw" class="form-label">Konfirmasi Password:</label>
                <input type="password" name="password_confirmation" id="pw" class="form-control">
            </div>
            <button type="submit" class="btn btn-dark ms-auto d-block w-25 mb-3">Kirim</button>
            <a href="/user/login" class="d-block ms-auto mb-5" style="width: fit-content">Sudah punya akun?</a>
        </form>
    </div>
@endsection