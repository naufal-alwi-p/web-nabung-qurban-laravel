@extends('template.main')

@section('style')
    <style>
        .self-bg-row-menu {
            background-color: #0AFF4E;
        }

        @media (min-width: 992px) {
            .self-w-75 {
                width: 75%;
            }

            .self-w-25 {
                width: 25%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row w-100">
        <div class="col-lg-3 self-bg-row-menu">
            <div class="mx-3">
                <h2 class="my-5">Menu</h2>
                <div class="d-flex flex-column row-gap-3 mb-5">
                    <button type="button" class="btn btn-dark">Data Pribadi</button>
                    <a href="/payment/history" class="btn btn-outline-dark">Riwayat Pembayaran</a>
                    <a href="/payment/riwayat-qurban" class="btn btn-outline-dark">Riwayat Qurban</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <h1 class="text-center my-5">Data Pribadi</h1>

            <form id="update-form" action="/user/update-data" method="post" class="container self-w-75 mx-auto">
                @if (session('update') === true)
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data berhasil di update.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('update') === false)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Data gagal di update.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @csrf
                <div class="mb-3">
                    <label for="nik" class="form-label">Nomor KTP (NIK):</label>
                    <input type="number" class="form-control" id="nik" value="{{ $user->nik }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama:</label>
                    <input type="text" name="name" id="nama" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">Nomor Telepon:</label>
                    <input type="tel" name="telepon" id="telepon" pattern="[0-9]{11,15}" class="form-control @error('telepon') is-invalid @enderror" value="{{ $user->telepon }}">
                    @error('telepon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="button" data-bs-toggle="modal" data-bs-target="#konfirmasi_password" class="btn btn-dark mx-auto d-block self-w-25 mb-5">Update</button>
            </form>
        </div>
    </div>

    {{-- Modal Password --}}
    <div class="modal fade" id="konfirmasi_password" tabindex="-1" aria-labelledby="konfirmasi_password_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="konfirmasi_password_label">Konfirmasi Password</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="pw" class="form-label">Masukkan Password Akun:</label>
                <input type="password" class="form-control" name="password" id="pw" required form="update-form">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="update-form">Update</button>
            </div>
        </div>
        </div>
    </div>
@endsection