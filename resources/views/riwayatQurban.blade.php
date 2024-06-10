@extends('template.main')

@section('style')
    <style>
        .self-w-1600 {
            width: 1600px;
        }

        .self-full-height {
            min-height: calc(100vh - 56px);
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5 mb-3">
        <a href="/user/detail" class="btn btn-dark"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
    
    <h1 class="text-center mb-4">Riwayat Qurban</h1>

    <div class="container mb-5 self-full-height">
        <div class="card">
            <div class="card-body overflow-x-auto">
                <div class="row self-w-1600">
                    <div class="col-1 fw-bold text-center">Hewan</div>
                    <div class="col-2 fw-bold text-center">Harga</div>
                    <div class="col-2 fw-bold text-center">Tipe Angsuran</div>
                    <div class="col-1 fw-bold text-center">Biaya per Angsuran</div>
                    <div class="col-2 fw-bold text-center">Total Uang</div>
                    <div class="col-1 fw-bold text-center">Sisa Angsuran</div>
                    <div class="col-1 fw-bold text-center">Jatuh Tempo</div>
                    <div class="col-2 fw-bold text-center">Status</div>
                </div>
                <hr class="self-w-1600">
                @forelse ($allHewanQurban as $hewan_qurban)
                    @if ($loop->last)
                        <div class="row self-w-1600 border border-3 border-dark rounded-pill py-3">
                            <div class="col-1 fw-bold text-center">{{ $hewan_qurban->hewanQurban->nama }}</div>
                            <div class="col-2 fw-bold text-center">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->hewanQurban->harga, 'IDR', 'id'))[0] }}</div>
                            <div class="col-2 fw-bold text-center">{{ $hewan_qurban->tipe_angsuran }}</div>
                            <div class="col-1 fw-bold text-center">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->biaya_per_periode, 'IDR', 'id'))[0] }}</div>
                            <div class="col-2 fw-bold text-center">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->total_uang, 'IDR', 'id'))[0] }}</div>
                            <div class="col-1 fw-bold text-center">{{ $hewan_qurban->sisa_angsuran }}</div>
                            <div class="col-1 fw-bold text-center">{{ $hewan_qurban->jatuh_tempo }}</div>
                            <div class="col-2 fw-bold text-center">{{ $hewan_qurban->status }}</div>
                        </div>
                    @else
                        <div class="row self-w-1600 border border-3 border-dark rounded-pill mb-3 py-3">
                            <div class="col-1 fw-bold text-center">{{ $hewan_qurban->hewanQurban->nama }}</div>
                            <div class="col-2 fw-bold text-center">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->hewanQurban->harga, 'IDR', 'id'))[0] }}</div>
                            <div class="col-2 fw-bold text-center">{{ $hewan_qurban->tipe_angsuran }}</div>
                            <div class="col-1 fw-bold text-center">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->biaya_per_periode, 'IDR', 'id'))[0] }}</div>
                            <div class="col-2 fw-bold text-center">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->total_uang, 'IDR', 'id'))[0] }}</div>
                            <div class="col-1 fw-bold text-center">{{ $hewan_qurban->sisa_angsuran }}</div>
                            <div class="col-1 fw-bold text-center">{{ $hewan_qurban->jatuh_tempo }}</div>
                            <div class="col-2 fw-bold text-center">{{ $hewan_qurban->status }}</div>
                        </div>
                    @endif
                @empty
                    <p class="text-secondary-emphasis text-center">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection