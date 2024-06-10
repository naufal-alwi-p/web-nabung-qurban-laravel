@extends('template.main')

@section('style')
    <style>
        .self-w-img {
            width: 170px;
        }

        @media (min-width: 992px) {
            .self-full-height {
                height: calc(100vh - 56px);
            }

            .self-w-img {
                width: 250px;
            }
        }
    </style>
@endsection

@section('content')
    @if ($hewan_qurban)
        {{-- <h1 class="text-center my-5">Hewan Qurban</h1> --}}

        <div class="container my-5">
            <div class="card">
                <h1 class="card-title text-center fw-bold mt-3 mb-5">Hewan Qurban</h1>
                <div class="self-w-img mx-auto mb-3">
                    @if($hewan_qurban->hewanQurban->nama === 'Sapi')
                        <img src="/assets/sapi.png" alt="Sapi" class="card-img-top">
                    @elseif ($hewan_qurban->hewanQurban->nama === 'Kambing')
                        <img src="/assets/kambing.png" alt="Kambing" class="card-img-top">
                    @endif
                </div>
                <div class="card-body">
                    <h2 class="text-center">Total Uang: {{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->total_uang, 'IDR', 'id'))[0] }}</h2>
                    <div>
                        <h3 class="fw-bold">Rincian</h3>
                        <div class="row">
                            <p class="col-md fw-bold">Harga Hewan:</p>
                            <p class="col-md text-start text-md-end">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->hewanQurban->harga, 'IDR', 'id'))[0] }}</p>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="col-md fw-bold">Angsuran ({{ $hewan_qurban->tipe_angsuran }}):</p>
                            <p class="col-md text-start text-md-end">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->biaya_per_periode, 'IDR', 'id'))[0] }}</p>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="col-md fw-bold">Sisa Angsuran:</p>
                            <p class="col-md text-start text-md-end">{{ $hewan_qurban->sisa_angsuran }}x</p>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="col-md fw-bold">Jatuh Tempo:</p>
                            <p class="col-md text-start text-md-end">{{ Illuminate\Support\Carbon::parse($hewan_qurban->jatuh_tempo)->format('d M Y') }}</p>
                        </div>
                        <div class="row">
                            <a href="#" class="btn btn-success col-md-2 mb-3 mb-md-0">Bayar</a>
                            <div class="col-md-5"></div>
                            <button type="button" class="btn btn-dark col-md-2 mb-3 mb-md-0" data-bs-toggle="modal" data-bs-target="#dialihkan_modal">Dialihkan</button>
                            <div class="col-md-1"></div>
                            <button type="button" class="btn btn-danger col-md-2" data-bs-toggle="modal" data-bs-target="#refund_modal">Refund</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Modal Dialihkan --}}
        <div class="modal fade" id="dialihkan_modal" tabindex="-1" aria-labelledby="dialihkan_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="dialihkan_modal_label">Konfirmasi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Uangmu akan dialihkan untuk qurban tahun depan. Apakah kamu yakin ?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <form action="/payment/dialihkan" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $hewan_qurban->id }}">
                    <button type="submit" class="btn btn-dark">Konfirmasi</button>
                </form>
                </div>
            </div>
            </div>
        </div>

        {{-- Modal Refund --}}
        <div class="modal fade" id="refund_modal" tabindex="-1" aria-labelledby="refund_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="refund_modal_label">Konfirmasi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Uangmu akan dikembalikan. Apakah kamu yakin ?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="/payment/refund" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $hewan_qurban->id }}">
                    <button type="submit" class="btn btn-danger">Refund</button>
                </form>
                </div>
            </div>
            </div>
        </div>
    @else
        <div class="self-full-height container-sm mb-5 mb-lg-0">
            <h1 class="text-center my-5">Pilih Hewan Qurban</h1>

            <div class="d-flex justify-content-evenly flex-wrap row-gap-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h2 class="card-title fw-bold text-center">Sapi</h2>
                    </div>
                    <div class="px-5 pb-3">
                        <img src="/assets/sapi.png" alt="Sapi" class="card-img-bottom">
                    </div>
                    <a href="/user/daftar-qurban" class="btn btn-dark my-3 mx-4">Pilih</a>
                </div>

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h2 class="card-title fw-bold text-center">Kambing</h2>
                    </div>
                    <div class="px-5 pb-3">
                        <img src="/assets/kambing.png" alt="Kambing" class="card-img-bottom">
                    </div>
                    <a href="/user/daftar-qurban" class="btn btn-dark my-3 mx-4">Pilih</a>
                </div>
            </div>
        </div>
    @endif
@endsection