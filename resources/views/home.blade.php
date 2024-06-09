@extends('template.main')

@section('style')
    <style>
        .self-color-1 {
            color: #207432;
        }

        .self-color-2 {
            color: #00FF0A;
        }

        .self-banner {
            width: 100%;
            height: 648px;
        }

        .self-how-it-works {
            width: 100%;
        }

        .self-bg-banner {
            background-image: url('/assets/banner_image.png');
            background-repeat: no-repeat;
            background-position: right bottom;
            background-size: auto;
            background-clip: padding-box;
            overflow: hidden;
        }

        .w-60 {
            width: 60%;
        }

        @media (min-width: 992px) {
            .bg-lg-transparent {
                background: transparent !important;
            }

            .shadow-lg-none {
                box-shadow: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="self-banner self-bg-banner">
        <div class="ms-4 w-60 d-flex justify-content-center h-100 flex-column">
            <div class="bg-body-secondary bg-lg-transparent bg-opacity-75 p-3 p-lg-0 rounded-3 shadow shadow-lg-none">
            <h1>
                Mari Sambut Idul Adha dengan Berqurban Secara Kolektif
            </h1>
            <p>Mari salurkan sedikit harta kita untuk ber-qurban dan jadikanlah momen qurban kita menjadi lebih baik.</p>
                <a href="#cara-kerja" class="btn btn-dark">Cara Kerjanya?</a>
            </div>
        </div>
    </div>

    <div class="self-how-it-works py-5 self-bg-1" id="cara-kerja">
        <h2 class="text-center pb-5"><span class="fs-3 self-color-1">Cara Kerja</span><br>Dapat Dilakukan Hanya Dengan 4 Langkah</h2>
        <div class="d-flex justify-content-center column-gap-3 row-gap-3 flex-wrap">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h3 class="card-title self-color-2 fs-4 text-center">Step 1</h3>
                    <p class="card-text text-center">Tentukan Pilihan Tenggat Waktu</p>
                </div>
                <div class="p-5">
                    <img src="/assets/step_1_icon.svg" alt="Step 1" class="card-img-bottom">
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h3 class="card-title self-color-2 fs-4 text-center">Step 2</h3>
                    <p class="card-text text-center">Cek Harga Pasar Hewan Qurban</p>
                </div>
                <div class="p-5">
                    <img src="/assets/step_2_icon.svg" alt="Step 1" class="card-img-bottom">
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h3 class="card-title self-color-2 fs-4 text-center">Step 3</h3>
                    <p class="card-text text-center">Menghitung Total Biaya</p>
                </div>
                <div class="p-5">
                    <img src="/assets/step_3_icon.svg" alt="Step 1" class="card-img-bottom">
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h3 class="card-title self-color-2 fs-4 text-center">Step 4</h3>
                    <p class="card-text text-center">Membayar Secara Kolektif</p>
                </div>
                <div class="p-5">
                    <img src="/assets/step_4_icon.svg" alt="Step 1" class="card-img-bottom">
                </div>
            </div>
        </div>
    </div>

    <div class="container-sm" id="layanan">
        <h2 class="text-center my-5">Tentukan Metode Pilihanmu</h2>

        <div class="d-flex justify-content-evenly flex-wrap row-gap-3 mb-5">
            <div class="card" style="width: 18rem; height: 20rem;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h3 class="card-title fs-4 fw-bolder text-center">Perminggu</h3>
                    <p class="card-text">Memulai pembayaran secara berkala setiap minggunya dengan harga yang sudah ditetapkan</p>
                    <hr class="opacity-100">
                    <p><span class="fw-bold">Rp xxx</span>/minggu</p>
                    <a href="#" class="btn btn-dark">Pilih</a>
                </div>
            </div>

            <div class="card" style="width: 18rem; height: 20rem;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h3 class="card-title fs-4 fw-bolder text-center">Perbulan</h3>
                    <p class="card-text">Memulai pembayaran secara berkala setiap bulannya dengan harga yang sudah ditetapkan</p>
                    <hr class="opacity-100">
                    <p><span class="fw-bold">Rp xxx</span>/bulan</p>
                    <a href="#" class="btn btn-dark">Pilih</a>
                </div>
            </div>
        </div>

        <hr class="opacity-100 border-3">

        <h2 class="text-center my-5">Pilihan Opsional</h2>

        <div class="d-flex justify-content-evenly flex-wrap row-gap-3 mb-5">
            <div class="card" style="width: 18rem; height: 23rem;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h3 class="card-title fs-4 fw-bolder text-center">Dialihkan</h3>
                    <p class="card-text">Memulai pembayaran secara berkala setiap bulannya dengan harga yang sudah ditetapkan, namun apabila masihbelum memuhi. Maka dana akan dialhikan utuk Qurban di tahun depan</p>
                    <hr class="opacity-100">
                    <p><span class="fw-bold">Rp xxx</span>/minggu</p>
                    <a href="#" class="btn btn-secondary">Pilih</a>
                </div>
            </div>

            <div class="card" style="width: 18rem; height: 23rem;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h3 class="card-title fs-4 fw-bolder text-center">Refund</h3>
                    <p class="card-text">Memulai pembayaran secara berkala setiap bulannya dengan harga yang sudah ditetapkan, apabila masih belum memuhi. Maka dana akan dialihkan untuk Qurban tahun depan</p>
                    <a href="#" class="btn btn-secondary">Pilih</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-sm mb-5">
        <p class="text-center fs-4">
            Dan bagi setiap umat telah Kami syariatkan penyembelihan (qurban), agar mereka menyebut nama Allah atas rezeki yang dikaruniakan Allah kepada mereka berupa hewan ternak. Maka Tuhanmu ialah Tuhan Yang Maha Esa, karena itu berserahdirilah kamu kepada-Nya. Dan sampaikanlah (Muhammad) kabar gembira kepada orang-orang yang tunduk patuh (kepada Allah), (yaitu) orang-orang yang apabila disebut nama Allah hati mereka bergetar, orang yang sabar atas apa yang menimpa mereka, dan orang yang melaksanakan salat dan orang yang menginfakkan sebagian rezeki yang Kami karuniakan kepada mereka."
        </p>
        <p class="text-center fs-4">Q.S Al-Hajj: 34 - 35</p>
    </div>
@endsection
