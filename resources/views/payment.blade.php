@extends('template.main')

@section('header')
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ $client_key }}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
@endsection

@section('style')
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-image {
            background-image: linear-gradient(rgba(10, 255, 78, 1), rgba(10, 255, 78, 0));
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
                <h1>Metode Pembayaran</h1>
                <p>Silahkan pilih metode pembayaran yang ingin anda gunakan</p>
                <div id="snap-container" style="width: fit-content" class="mx-auto"></div>
            </div>
            <!-- Image Section -->
            <div class="col-md-6 bg-image">
                <div class="m-5">
                    <h2 class="text-center">Rincian Pembayaran</h2>
                    <p>Total:</p>
                    <p class="fw-bold fs-1 text-center">{{ explode(',', Illuminate\Support\Number::currency($hewan_qurban->biaya_per_periode, 'IDR', 'id'))[0] }}</p>
                    <button type="button" class="btn btn-dark mx-auto d-block" id="pay-button">Bayar</button>

                    <div class="alert alert-warning mt-5" role="alert">
                        <p class="fs-5"><b>Peringatan !</b></p>
                        <p>Pembayaran ini hanyalah simulasi. Jangan gunakan uang sesungguhnya!</p>
                        <p>
                            Langkah-Langkah:<br>
                            1. Pilih metode <b>Credit/debit card</b><br>
                            2. Isi "Card number" dengan <b>4811 1111 1111 1114</b><br>
                            3. Isi "Expiration date" dengan <b>03/26</b><br>
                            4. Isi "CVV" dengan <b>123</b><br>
                            5. Klik Pay now<br>
                            6. Lalu masukkan kode yang diberikan di form password<br>
                            7. Klik OK
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // For example trigger on button clicked, or any time you need
        const payButton = document.getElementById('pay-button');
        const id_qurban = {{ $hewan_qurban->id }};
        payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
        // Also, use the embedId that you defined in the div above, here.
        window.snap.embed('{{ $snap_token }}', {
            embedId: 'snap-container',
            onSuccess: function (result) {
                /* You may add your own implementation here */
                result.id_qurban = id_qurban;
                const data = JSON.stringify(result);

                const fetchPOST = fetch(`${window.location.origin}/payment/notification`, {
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
                    if (hasil.result) {
                        window.location.replace('http://qurban-kolektif.test/user/dashboard');
                    }
                }).catch((error) => {
                    console.log(error);
                });
            },
            onError: function (result) {
                /* You may add your own implementation here */
                window.location.replace('http://qurban-kolektif.test/user/dashboard');
            }
        });
        });
    </script>
@endsection