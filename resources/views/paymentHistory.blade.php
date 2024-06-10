@extends('template.main')

@section('style')
    <style>
        .self-full-height {
            min-height: calc(100vh - 56px);
        }

        @media (max-width: 767px) {
            .self-w-600 {
                width: 600px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5 mb-3">
        <a href="/user/detail" class="btn btn-dark"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <h1 class="text-center mb-4">Riwayat Pembayaran</h1>

    <div class="container mb-5 self-full-height">
        <div class="card">
            <div class="card-body overflow-x-auto">
                <div class="row self-w-600">
                    <div class="col-6 fw-bold text-center">Tanggal Pembayaran</div>
                    <div class="col-6 fw-bold text-center">Jumlah</div>
                </div>
                <hr class="self-w-600">
                @forelse ($allHewanQurban as $hewan_qurban)
                    @forelse ($hewan_qurban->riwayatPembayaran as $riwayat)
                        @if ($loop->last)
                            <div class="row self-w-600 border border-3 border-dark rounded-pill py-3">
                                <div class="col-6 text-center">{{ $riwayat->waktu }}</div>
                                <div class="col-6 text-center">{{ explode(',', Illuminate\Support\Number::currency($riwayat->biaya, 'IDR', 'id'))[0] }}</div>
                            </div>
                        @else
                            <div class="row self-w-600 border border-3 border-dark rounded-pill mb-3 py-3">
                                <div class="col-6 text-center">{{ $riwayat->waktu }}</div>
                                <div class="col-6 text-center">{{ explode(',', Illuminate\Support\Number::currency($riwayat->biaya, 'IDR', 'id'))[0] }}</div>
                            </div>
                        @endif
                    @empty
                        <p class="text-secondary-emphasis text-center">Tidak ada data</p>
                    @endforelse
                @empty
                    <p class="text-secondary-emphasis text-center">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection