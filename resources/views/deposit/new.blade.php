@extends('template')
@section('view')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Permintaan Deposit Baru</h5>
            </div>
            <form id="newDeposit" method="POST">
                <input type="hidden" name="gateway" id="gateway">
                <div class="card-body">
                    <div class="accordion mt-0 mb-1" id="payments">
                        @foreach($methods_external as $key => $value)
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="heading_{{$key}}">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#{{ str_replace(' ', '',$key) }}" aria-expanded="false" aria-controls="{{ str_replace(' ', '',$key) }}">
                                    {{ $key }} </button>
                            </h2>
                            <div id="{{ str_replace(' ', '',$key) }}" class="accordion-collapse collapse" data-bs-parent="#{{ str_replace(' ', '',$key) }}">
                                <div class="accordion-body">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                                        @foreach($value as $data)
                                        <div class="col-lg-4 pb-1 m-3">
                                            <div class="list-group2 h-100">
                                                <input type="radio" name="method" id="payment_{{ $data['id'] }}" value="{{ $data['name'] }}" data-fee-percent="{{ $data['fee_percent'] }}" data-fee-flat="{{ $data['fee_flat'] }}" data-min-payment="10000" data-bonus="{{ get_config('bonus_payment_gateway') }}" data-gateway="tripay">
                                                <label for="payment_{{ $data['id'] }}" class="list-group-item h-100">
                                                    <div class="info-top text-center">
                                                        <div>
                                                            <img src="{{ asset('icon/'.$data['images'].'') }}" style="height: 8vh;margin-top: 1rem;">
                                                        </div>
                                                    </div>
                                                    <div class="info-bottom text-center">
                                                        <span class="fw-bolder">{{ $data['name'] }}</span>
                                                        <div class="">Fee : {{ $data['fee_flat'] == 0 ? '0' : rupiah($data['fee_flat']) }} + {{ $data['fee_percent'] == 0 ? '0' : $data['fee_percent']}} %</div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="heading_Payment">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#payment" aria-expanded="false" aria-controls="te">
                                    Transfer </button>
                            </h2>
                            <div id="payment" class="accordion-collapse collapse" data-bs-parent="#payments">
                                <div class="accordion-body">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                                        @foreach($methods_internal as $method)
                                        <div class="col-lg-4 pb-1 m-3">
                                            <div class="list-group2 h-100">
                                                <input type="radio" name="method" id="payment_{{ $method['name'] }}" value="{{ $method['name'] }}" data-fee-percent="0" data-fee-flat="0" data-min-payment="{{ $method['min'] }}" data-bonus="{{ $method['bonus'] }}" data-payment-group="payment" data-gateway="internal">
                                                <label for="payment_{{ $method['name'] }}" class="list-group-item h-100">
                                                    <div class="info-top text-center">
                                                        <div>
                                                            <img src="{{ asset('icon/'.$method['icon'].'') }}" style="height: 8vh;margin-top: 1rem;">
                                                        </div>
                                                    </div>
                                                    <div class="info-bottom text-center">
                                                        <span class="fw-bolder">{{ $method['name'] }}</span>
                                                        <div class="">*otomatis jika tidak ada kendala offline / perbaikan layanan</div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label>Minimal Deposit</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control" aria-label="Minimal Deposit" id="min" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Jumlah Deposit</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control" aria-label="Minimal Deposit" name="amount" id="amount" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Jumlah Diterima</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control" aria-label="Jumlah Diterima" id="get_balance" readonly>
                                </div>
                            </div>
                        </div>
                        <small class="text-danger">* Jumlah Diterima Belum termasuk Bonus Dari Level Anda (akan dihitung setelah melakukan permintaan Deposit)</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="btn_submit"><i class="fas fa-check"></i> Deposit Now</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info mr-3"></i> Informasi Seputar Deposit</h5>
            </div>
            <div class="card-body">
                <h5> Penting! :</h5>
                <ul style="list-style-type:circle">
                    <ul style="list-style-type:circle">
                        <li>Transfer Bank & QRIS (Bebas biaya admin)</li>
                        <li>Virtual Account & QRIS (Dikenakan biaya admin)</li>
                    </ul>
                    <li>Untuk tipe “Transfer Bank & QRIS” deposit akan otomatis masuk 5-10 Menit, jika diatas 5 menit belum masuk, silahkan hubungi admin.</li>
                    <li>Untuk tipe “Virtual Account & QRIS” deposit akan otomatis masuk 1-10 detik setelah pembayaran.</li>
                    <li>Jika permintaan deposit tidak dibayar dalam waktu lebih dari 12 jam, maka permintaan deposit akan otomatis dibatalkan.</li>
                </ul>
                <br />
                <h5>Langkah-langkah</h5>
                <ul style="list-style-type: circle;">
                    <li>Pilih salah satu tipe deposit yang anda inginkan, tersedia 2 tipe deposit.</li>
                    <li>Pilih metode deposit yang anda inginkan.</li>
                    <li>Masukkan jumlah deposit.</li>
                    <li>Klik “Deposit Now” sekali klik saja, lalu tunggu beberapa detik.</li>
                    <li>Setelah itu klik “Lanjut ke Pembayaran”, lalu silahkan melakukan pembayaran sesuai dengan permintaan deposit anda + 3 angka acak dibelakang. (Contoh: Jumlah Deposit 25.000 akan menjadi 25.323 atau 3 digit acak lainnya), nominal yang harus dibayar akan ditampilkan setelah anda Klik Submit.</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>
@endsection
@section('script')
<script>
    var bonus;
    var fee_flat;
    var fee_percent;
    $("#get_balance").attr('placeholder', formatRupiah(0))
    $("#amount").attr('placeholder', formatRupiah(0));
    $("#min").attr('placeholder', formatRupiah(0));
    $("input[name='method']").on('change', function() {
        if ($(this).val() != 'null') {
            $("#amount").removeAttr('readonly')
        } else {
            $("#amount").attr('readonly', 'readonly')
        }
        const data = $(`input[name='method']:checked`).data();
        console.log('data', data);
        $("#min").val(formatRupiah(data.minPayment));
        bonus = data.bonus;
        fee_percent = data.feePercent;
        fee_flat = data.feeFlat;
        $("#gateway").val(data.gateway)
    })
    $("#amount").on('keyup', async function() {
        var amount = parseInt($(this).val()) - fee_flat;
        var newAmount = amount - (amount * (fee_percent / 100));
        var amountBonus = Math.round(newAmount + (amount * (bonus / 100)));
        if (amount > 0) {
            $("#get_balance").val(formatRupiah(amountBonus))
        } else {
            $("#get_balance").val(formatRupiah(0))
        }
    })

    function formatRupiah(bilangan, prefix) {
        var number_string = bilangan.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
    $("#newDeposit").submit(function(e) {
        e.preventDefault()
        var form = new FormData(this);
        form.append('_token', token);
        $("#btn_submit").attr('disabled', 'disabled');
        axios.post("{{url('ajax/deposit')}}", form)
            .then(response => {
                $("#btn_submit").removeAttr('disabled');
                if (response.data.status) {
                    setTimeout(function() {
                        swal.fire({
                            html: response.data.message,
                            icon: 'success',
                            buttonsStyling: true,
                            showCancelButton: true,
                            confirmButtonText: 'Lanjut Ke Pembayaran',
                            cancelButtonText: 'Tutup',
                            customClass: {
                                cancelButton: 'btn font-weight-bold btn-danger',
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(result => {
                            if (result.isConfirmed) {
                                window.location.href = "{{url('deposit/invoice')}}/" + response.data.id;
                            }
                        })
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            html: "<span>" + response.data.message + "</span>",
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                $("#btn_submit").removeAttr('disabled');
                if (error.response) {
                    const data = error.response.data;
                    var errorAjax = data.errors;
                    let errorMessage = '';
                    Object.keys(errorAjax).map(function(key) {
                        errorMessage += errorAjax[key][0] + '<br/>'
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorMessage,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Server mengalami masalah!',
                    })
                }
            });
    })
</script>
@endsection