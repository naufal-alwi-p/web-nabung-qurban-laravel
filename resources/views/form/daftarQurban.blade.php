@extends('template.main')

@section('style')
    <style>
        #jumlah_angsuran {
            outline: none;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Pendaftaran Qurban</h1>

        <form method="post" class="mb-5" onsubmit="return validateForm()">
            @csrf
            <div class="mb-3">
                <label for="metode" class="form-label">Metode yang Dipilih:</label>
                <select class="form-select @error('tipe_angsuran') is-invalid @enderror" name="tipe_angsuran" id="metode">
                    <option selected>Pilih metode pembayaran</option>
                    <option value="per Minggu">per Minggu</option>
                    <option value="per Bulan">per Bulan</option>
                </select>
                @error('tipe_angsuran')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tempo" class="form-label">Jatuh Tempo:</label>
                <input type="date" name="jatuh_tempo" id="tempo" class="form-control @error('jatuh_tempo') is-invalid @enderror" value="{{ $jatuh_tempo }}" readonly>
                @error('jatuh_tempo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="hewan_qurban" class="form-label">Hewan yang Dipilih:</label>
                <select class="form-select" name="hewan_qurban_id" id="hewan_qurban">
                    <option selected>Pilih hewan qurban</option>
                    @foreach ($hewan_qurban as $hewan)
                        <option value="{{ $hewan->id }}">{{ $hewan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <p class="fw-bold fs-5">Rincian</p>
                <div class="row">
                    <p class="col-md fw-bold">Harga Hewan:</p>
                    <p class="col-md text-start text-md-end" id="harga">-</p>
                </div>
                <hr>
                <div class="row">
                    <p class="col-md fw-bold">Angsuran (per Bulan):</p>
                    <p class="col-md text-start text-md-end" id="angsuran">-</p>
                    <input type="hidden" name="biaya_per_periode" id="biaya_per_periode" value="0">
                </div>
                <div class="row">
                    <p class="col-md fw-bold">Jumlah Angsuran:</p>
                    <input type="text" class="col-md text-start text-md-end border-0" name="sisa_angsuran" id="jumlah_angsuran" value="-" readonly>
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" name="dialihkan" id="dialihkan" value="true" class="form-check-input">
                <label for="dialihkan" class="form-check-label">Dialihkan ke tahun depan</label>
            </div>
            <p class="text-danger" id="warning"></p>
            <button type="submit" class="btn btn-dark d-block ms-auto w-25">Daftar</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        const hewan = document.querySelector('#hewan_qurban');
        const metode_angsuran = document.querySelector('#metode');
        const jatuh_tempo = document.querySelector('#tempo');
        const check = document.querySelector('#dialihkan');
        const tag_harga = document.querySelector('#harga');
        const tag_angsuran = document.querySelector('#angsuran');
        const input_angsuran = document.querySelector('#biaya_per_periode');
        const input_jumlah_angsuran = document.querySelector('#jumlah_angsuran');
        const peringatan = document.querySelector('#warning');

        check.onchange =getTanggalIdulAdha;

        function getTanggalIdulAdha() {
            let tahun
            if (check.checked === true) {
                tahun = (new Date()).getFullYear() + 1;
            } else {
                tahun = (new Date()).getFullYear();
            }

            const data = JSON.stringify({
                tahun: tahun
            });

            const fetchPOST = fetch(`${window.location.origin}/get/tanggal-idul-adha`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json;charset=utf-8",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: data,
            });

            fetchPOST.then((respon) => {
                return respon.json();
            }).then((hasil) => {
                jatuh_tempo.value = hasil.tanggal;
            }).catch((error) => {
                console.log(error);
            });
        }

        hewan.onchange = getHargaQurban;

        metode_angsuran.onchange = getHargaQurban;

        function getHargaQurban() {
            const id_hewan = Number(hewan.options[hewan.selectedIndex].value);
            const nama = hewan.options[hewan.selectedIndex].innerHTML;
            const metode = metode_angsuran.options[metode_angsuran.selectedIndex].value;
            const tanggal = jatuh_tempo.value;

            if ((!isNaN(id_hewan)) && (metode_angsuran.selectedIndex !== 0)) {
                const data = JSON.stringify({
                    id: id_hewan,
                    nama: nama,
                    metode: metode,
                    tanggal: tanggal
                });

                const fetchPOST = fetch(`${window.location.origin}/get/harga-hewan`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json;charset=utf-8",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: data,
                });

                fetchPOST.then((respon) => {
                    return respon.json();
                }).then((hasil) => {
                    console.log(hasil);
                    tag_harga.innerHTML = hasil.harga_readable;
                    tag_angsuran.innerHTML = hasil.biaya_per_angsuran_r;
                    input_angsuran.value = hasil.biaya_per_angsuran;
                    input_jumlah_angsuran.value = hasil.jumlah_angsuran;

                    if (hasil.checkbox === true) {
                        check.checked = true;
                        getTanggalIdulAdha();
                        check.disabled = true;
                        peringatan.innerHTML = "Sudah tidak bisa melakukan angsuran qurban tahun ini. Biaya qurban anda dialihkan untuk tahun depan";
                    }
                }).catch((error) => {
                    console.log(error);
                });
            } else {
                tag_harga.innerHTML = '-';
                tag_angsuran.innerHTML = '-';
                input_angsuran.value = 0;
                input_jumlah_angsuran.value = '-';

                check.checked = false;
                getTanggalIdulAdha();
                check.disabled = false;
                peringatan.innerHTML = "";
            }
        }

        function validateForm() {
            if (hewan.selectedIndex === 0 || metode_angsuran.selectedIndex === 0) {
                alert('Isi data terlebih dahulu');
                return false;
            }
        }
    </script>
@endsection
