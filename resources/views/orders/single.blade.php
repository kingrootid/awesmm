@extends('template')
@section('view')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body border-bottom" style="padding-bottom:.5rem;">
                <div class="row gx-1 gy-3 pb-3">
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnAll" onclick="filterCategory('btnAll', '0');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/other.svg" width="30"><span style="margin-left:8px; margin-top:1px;">Semua</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnInstagram" onclick="filterCategory('btnInstagram', 'Instagram');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/instagram.svg" width="30"><span style="margin-left:8px; margin-top:1px;">Instagram</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnFacebook" onclick="filterCategory('btnFacebook', 'Facebook');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/facebook.svg" width="30"><span style="margin-left:8px; margin-top:1px;">Facebook</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnTwitter" onclick="filterCategory('btnTwitter', 'Twitter');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/twitter.svg" width="30"><span style="margin-left:8px; margin-top:1px;">Twitter</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnTiktok" onclick="filterCategory('btnTiktok', 'Tiktok');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/tiktok.svg" width="30"><span style="margin-left:8px; margin-top:1px;">Tiktok</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnShopee" onclick="filterCategory('btnShopee', 'Shopee');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/shopee.png" width="30"><span style="margin-left:8px; margin-top:1px;">Shopee</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnGoogle" onclick="filterCategory('btnGoogle', 'Google');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/google.svg" width="30"><span style="margin-left:8px; margin-top:1px;">Google</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnTelegram" onclick="filterCategory('btnTelegram', 'Telegram');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/telegram.svg" width="30"><span style="margin-left:8px; margin-top:1px;">Telegram</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnTokopedia" onclick="filterCategory('btnTokopedia', 'Tokopedia, Toko pedia');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/tokopedia.png" width="30"><span style="margin-left:8px; margin-top:1px;">Tokopedia</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnSpotify" onclick="filterCategory('btnSpotify', 'Spotify');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/spotify.png" width="30"><span style="margin-left:8px; margin-top:1px;">Spotify</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnDiscord" onclick="filterCategory('btnDiscord', 'Discord');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/discord.png" width="30"><span style="margin-left:8px; margin-top:1px;">Discord</span></span></button>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-3 d-grid">
                        <button type="button" class="btn btn-outline-primary btn-sm d-block text-nowrap mb-1 btnFilter btnYoutube" onclick="filterCategory('btnYoutube', 'Youtube');"><span class="d-flex align-items-center"><img src="{{  asset('icon') }}/youtube.svg" width="30"><span style="margin-left:8px; margin-top:1px;">Youtube</span></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-12">
        <div class="card">
            <h5 class="card-header">Pemesanan Baru Social Media</h5>
            <div class="tabs-menu1">
                <ul class="nav nav-pills nav-success mb-3" role="tablist">
                    <li class="nav-item waves-effect waves-light mr-1"><a href="#general" data-bs-toggle="tab" class="nav-link nav-order active" id="btn-general"><i class="fas fa-adjust me-2"></i>Umum</a></li>
                    <li class="nav-item waves-effect waves-light mr-1"><a href="#favorite" data-bs-toggle="tab" class="nav-link nav-order" id="btn-favorite"><i class="far fa-star me-2"></i>Favorit</a></li>
                    <li class="nav-item waves-effect waves-light mr-1"><a href="#search" data-bs-toggle="tab" class="nav-link nav-order" id="btn-search"><i class="fas fa-search me-2"></i>Cari ID</a></li>
                </ul>
            </div>
            <form id="form-sosmed" method="POST">
                <div class="card-body">
                    @csrf
                    <input type="hidden" name="type" value="normal" id="type_order">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <div class="form-group mb-3">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="category" id="category">
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Layanan <span class="text-danger">*</span></label>
                                <select class="form-control" id="service">
                                    <option value="null">-- Tidak Ada Layanan --</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane" id="favorite" role="tabpanel">
                            <div class="form-group mb-3">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="category" id="favorite_category">
                                    <option value="null">Silahkan Pilih Category Favorit</option>
                                    @foreach($fav_category as $fc)
                                    <option value="{{ $fc['category_id'] }}">{{ $fc['category'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Layanan <span class="text-danger">*</span></label>
                                <select class="form-control" id="favorite_service">
                                    <option value="null">-- Tidak Ada Layanan --</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane" id="search" role="tabpanel">
                            <div class="form-group mb-3">
                                <label>ID Layanan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="service-id">
                                    <div class="input-group-addon">
                                        <a href="javascript:;" class="btn btn-primary" id="btnSearch"><i class="fas fa-search"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="service" id="selected_services">
                    <div class="form-group mb-3">
                        <label>Note</label>
                        <textarea id="description" class="form-control" name="note" rows="3" disabled></textarea>
                        <div id="canceled"></div>
                        <div id="refill"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label>Minimal</label>
                                <input type="text" class="form-control" id="min" readonly placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label>Maximal</label>
                                <input type="text" class="form-control" id="max" readonly placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label>Harga / 1000</label>
                                <input type="text" class="form-control" id="price" readonly placeholder="0">
                                <!-- <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                    <input type="text" class="form-control" placeholder="0" aria-label="harga" id="price" readonly aria-describedby="basic-addon1">
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Rata Rata Process Layanan <button type="button" class="btn btn-info btn-sm rounded" data-bs-toggle="tooltip" data-placement="right" title="Rata Rata Process Layanan Dalam Quantity 1000">
                                <i class="fas fa-info"></i>
                            </button></label>
                        <input type="text" class="form-control" id="avarage" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-3">
                                <label>Jumlah</label>
                                <input type="number" class="form-control" name="quantity" id="amount" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-3">
                                <label>Target</label>
                                <input type="text" class="form-control" name="target" id="target">
                            </div>
                        </div>
                    </div>
                    <div id="bodyss" style="display: none;">
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="form-control" name="custom_comments" id="custom_comments" placeholder="Pisahkan Tiap Baris komentar dengan enter"></textarea>
                        </div>
                    </div>
                    <div id="customLike" style="display: none;">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username of Creator Comments">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Total Harga</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                            <input type="text" class="form-control" placeholder="0" aria-label="harga" id="total" readonly aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submit">Pesan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="card">
            <h5 class="card-header"><i class="fas fa-info-circle"></i>Informasi</h5>
            <div class="card-body">
                <b>Rules Pemesanan:</b>
                <ul>
                    <li>Pastikan Anda memenginput data yang benar sesuai format yang pada kolom <b>deskripsi</b>, karena kami tidak bisa <b>membatalkan pesanan</b>.</li>
                    <li><b>Jangan</b> menggunakan <b>lebih dari satu layanan sekaligus</b> untuk data/target yang sama. Harap tunggu status <em>Success</em> pada pesanan sebelumnya baru melakukan pesanan kepada data/target yang sama. Hal ini <b>tidak akan membantu mempercepat orderan Anda</b> karena kedua orderan bisa jadi berstatus <em>Success</em> tetapi hanya tercapai target dari salah satu pesanan dan <b>tidak ada pengembalian dana</b>.</li>
                    <li>Setelah pesanan berhasil, jika data/target yang diinput tidak ditemukan (diubah atau menjadi private), pesanan akan otomatis menjadi <em>Success</em> dan <b>tidak ada pengembalian dana</b>.</li>
                    <li>Jika status pesanan <em>Error</em> & <em>Partial</em>, saldo Anda akan otomatis dikembalikan.</li>
                    <li>Jumlah <b>Maksimal Pesanan</b> menunjukkan kapasitas layanan tersebut untuk satu target, bukan menunjukkan kapasitas sekali pemesanan. Apabila Anda telah menggunakan semua kapasitas <b>Maksimal Pesanan</b> layanan, Anda tidak bisa menggunakan layanan itu lagi dan harus menggunakan layanan yang lain. Oleh karena itu kami menyediakan banyak layanan dengan kapasitas <b>Maksimal Pesanan</b> yang lebih besar.</li>
                    <li>Dengan melakukan pemesanan, Anda dianggap sudah memahami dan menyetujui <b><em>Syarat & Ketentuan.</em></b></li>
                </ul>
                <br>
                <b>Penting!</b>
                <ul>
                    <li>Jika Anda mendapat pesan gagal saat melakukan pemesanan, silakan informasikan layanan tersebut melalui <em><b><a href="../ticket/new">Tiket</a></b></em> atau hubungi Admin.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function formatRupiah(bilangan) {
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
        return 'Rp. ' + rupiah;
    }
    $("btn_general, #btn_favorite, #btn_search").click(function() {
        console.log('sadkasd');
    })

    function filterCategory(btn, category) {
        $.ajax({
            type: "POST",
            data: {
                category: category,
                _token: token
            },
            url: "{{ url('ajax/showCategory') }}",
            dataType: "JSON",
            success: function(data) {
                if (!data.status) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi Kesalahan!',
                    })
                } else {
                    var html = `<option value='null'>Pilih Category</option>`
                    for (let category in data.data) {
                        html += `<option value='${data.data[category]['id']}'>${data.data[category]['name']}</option>`
                    }
                    $("#category").html(html);
                    $(`.btnFilter`).removeClass('active')
                    $(`.${btn}`).addClass('active')
                }
            },
        });
    }
    filterCategory('btnAll');
    $(document).ready(function() {
        $('select').select2();
        $("#category").on('change', function() {
            var category = $(this).val();
            $.ajax({
                url: "{{ url('ajax/getServices') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    category: category,
                    _token: token
                },
                success: function(data) {
                    if (!data.status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi Kesalahan!',
                        })
                    } else {
                        var dataServices;
                        $("#service").html();
                        dataServices += '<option value="">-- Silahkan Pilih Layanan --</option>';
                        for (let services of data.data) {
                            dataServices += `<option value="${services.id}">${services.id} - ${services.name} ${services.price} </option>`;
                        }
                        $("#service").html(dataServices);
                    }
                }
            });
        });
        $("#btnSearch").click(function() {
            var service = $("#service-id").val();
            $.ajax({
                url: "{{ url('ajax/priceSosmed') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    service: service,
                    _token: token
                },
                success: function(data) {
                    if (!data.status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi Kesalahan!',
                        })
                    } else {
                        if (data.data.type == "Custom Comments") {
                            $("#amount").attr('disabled', true)
                            $("#type_order").val('cc');
                            $("#bodyss").css('display', 'block');
                            $("#customLike").css('display', 'none');
                        } else if (data.data.type == "Custom Likes") {
                            $("#type_order").val('cl')
                            $("#bodyss").css('display', 'none');
                            $("#customLike").css('display', 'block');
                        } else {
                            $("#bodyss").css('display', 'none');
                            $("#customLike").css('display', 'none');
                        }
                        let canceled = "";
                        $("#canceled").html("");
                        if (data.data.is_canceled == "1") {
                            canceled = `<span class="text-success"><i class="fas fa-check-circle"></i> Support Cancel Button</span>`
                        } else {
                            canceled = `<span class="text-danger"><i class="fas fa-times-circle"></i> Tidak Support Cancel Button</span>`
                        }
                        $("#canceled").html(canceled)
                        let refill = "";
                        $("#refill").html("");
                        if (data.data.is_refill == "1") {
                            refill = `<span class="text-success"><i class="fas fa-check-circle"></i> Support Refill Button</span>`
                        } else {
                            refill = `<span class="text-danger"><i class="fas fa-times-circle"></i> Tidak Support Refill Button</span>`
                        }
                        $("#refill").append(refill)
                        $("#avarage").val(data.average);
                        $("#price").val(data.data.price);
                        $("#description").val(data.data.description);
                        $("#min").val(data.data.min);
                        $("#max").val(data.data.max);
                        $("#selected_services").val(data.data.id)
                    }
                }
            });
        })
        $("#favorite_category").on('change', function() {
            var category = $(this).val();
            $.ajax({
                url: "{{ url('ajax/favgetServices') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    category: category,
                    _token: token
                },
                success: function(data) {
                    if (!data.status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi Kesalahan!',
                        })
                    } else {
                        var dataServices;
                        $("#favorite_service").html();
                        dataServices += '<option value="">-- Silahkan Pilih Layanan --</option>';
                        for (let services of data.data) {
                            dataServices += `<option value="${services.id}">${services.id} - ${services.name} ${services.price} </option>`;
                        }
                        $("#favorite_service").html(dataServices);
                    }
                }
            });
        });
        $("#favorite_service").on('change', function() {
            var service = $(this).val();
            $.ajax({
                url: "{{ url('ajax/priceSosmed') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    service: service,
                    _token: token
                },
                success: function(data) {
                    if (!data.status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi Kesalahan!',
                        })
                    } else {
                        if (data.data.type == "Custom Comments") {
                            $("#amount").attr('disabled', true)
                            $("#type_order").val('cc');
                            $("#bodyss").css('display', 'block');
                            $("#customLike").css('display', 'none');
                        } else if (data.data.type == "Custom Likes") {
                            $("#type_order").val('cl')
                            $("#bodyss").css('display', 'none');
                            $("#customLike").css('display', 'block');
                        } else {
                            $("#bodyss").css('display', 'none');
                            $("#customLike").css('display', 'none');
                        }
                        let canceled = "";
                        $("#canceled").html("");
                        if (data.data.is_canceled == "1") {
                            canceled = `<span class="text-success"><i class="fas fa-check-circle"></i> Support Cancel Button</span>`
                        } else {
                            canceled = `<span class="text-danger"><i class="fas fa-times-circle"></i> Tidak Support Cancel Button</span>`
                        }
                        $("#canceled").html(canceled)
                        let refill = "";
                        $("#refill").html("");
                        if (data.data.is_refill == "1") {
                            refill = `<span class="text-success"><i class="fas fa-check-circle"></i> Support Refill Button</span>`
                        } else {
                            refill = `<span class="text-danger"><i class="fas fa-times-circle"></i> Tidak Support Refill Button</span>`
                        }
                        $("#refill").append(refill)
                        $("#avarage").val(data.average);
                        $("#price").val(data.data.price);
                        $("#description").val(data.data.description);
                        $("#min").val(data.data.min);
                        $("#max").val(data.data.max);
                        $("#selected_services").val(data.data.id)
                    }
                }
            });
        });
        $("#service").on('change', function() {
            var service = $(this).val();
            $.ajax({
                url: "{{ url('ajax/priceSosmed') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    service: service,
                    _token: token
                },
                success: function(data) {
                    if (!data.status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi Kesalahan!',
                        })
                    } else {
                        if (data.data.type == "Custom Comments") {
                            $("#amount").attr('disabled', true)
                            $("#type_order").val('cc');
                            $("#bodyss").css('display', 'block');
                            $("#customLike").css('display', 'none');
                        } else if (data.data.type == "Custom Likes") {
                            $("#type_order").val('cl')
                            $("#bodyss").css('display', 'none');
                            $("#customLike").css('display', 'block');
                        } else {
                            $("#bodyss").css('display', 'none');
                            $("#customLike").css('display', 'none');
                        }
                        let canceled = "";
                        $("#canceled").html("");
                        if (data.data.is_canceled == "1") {
                            canceled = `<span class="text-success"><i class="fas fa-check-circle"></i> Support Cancel Button</span>`
                        } else {
                            canceled = `<span class="text-danger"><i class="fas fa-times-circle"></i> Tidak Support Cancel Button</span>`
                        }
                        $("#canceled").html(canceled)
                        let refill = "";
                        $("#refill").html("");
                        if (data.data.is_refill == "1") {
                            refill = `<span class="text-success"><i class="fas fa-check-circle"></i> Support Refill Button</span>`
                        } else {
                            refill = `<span class="text-danger"><i class="fas fa-times-circle"></i> Tidak Support Refill Button</span>`
                        }
                        $("#refill").append(refill)
                        $("#avarage").val(data.average);
                        $("#price").val(data.data.price);
                        $("#description").val(data.data.description);
                        $("#min").val(data.data.min);
                        $("#max").val(data.data.max);
                        $("#selected_services").val(data.data.id)
                    }
                }
            });
        });
    });
    $("#custom_comments").on("keypress", function() {
        var custom_comments = $(this).val().split("\n");
        var quantity = custom_comments.length;
        $('#amount').val(quantity);
        $.ajax({
            type: "POST",
            data: {
                services: $('#selected_services').val(),
                quantity: quantity,
                _token: token
            },
            url: "{{ url('ajax/TotalPriceSosmed') }}",
            dataType: "JSON",
            success: function(data) {
                if (data == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi Kesalahan!',
                    })
                } else {
                    $('#total').val(data.total);
                }
            },
        });
    });
    $('#amount').on('keyup', function() {
        quantity = $('#amount').val();
        $.ajax({
            type: "POST",
            data: {
                services: $('#selected_services').val(),
                quantity: quantity,
                _token: token
            },
            url: "{{ url('ajax/TotalPriceSosmed') }}",
            dataType: "JSON",
            success: function(data) {
                if (data == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi Kesalahan!',
                    })
                } else {
                    $('#total').val(data.total);
                }
            },
        });
    });
    $("#form-sosmed").submit(function(e) {
        $("#submit").attr('disabled', true);
        $("#submit").html('<i class="fa fa-spinner fa-spin"></i> Memproses');
        e.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post(`{{ url('ajax/orderSosmed') }}`, form)
            .then(result => {
                if (!result.data.status) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: result.data.message,
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Pemesanan Berhasil!',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(function() {
                        // window.location.href = "{{ url('history/social') }}";
                    });
                }
                $("#submit").attr('disabled', false);
                $("#submit").html('Pesan');
            }).catch(error => {
                console.log(error);
                if (error.response) {
                    const data = error.response.data;
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: data.message,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Server mengalami masalah!',
                    })
                }
                $("#submit").attr('disabled', false);
                $("#submit").html('Pesan');
            })
    });
</script>
@endsection