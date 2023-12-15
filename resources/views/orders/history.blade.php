@extends('template')
@section('view')
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{$page}}</h5>
            </div>
            <div class="card-body">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Layanan</th>
                                <th>Target</th>
                                <th>Harga</th>
                                <th>Jumlah Pesan</th>
                                <th>Jumlah Awal</th>
                                <th>Jumlah Kurang</th>
                                <th>Aksi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Zero config table end -->
</div>
<div id="modalDetail" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" class="form-control" id="id" readonly>
                </div>
                <div class="form-group">
                    <label>Layanan</label>
                    <input type="text" class="form-control" id="service" readonly>
                </div>
                <div class="form-group">
                    <label>Target</label>
                    <input type="text" class="form-control" id="target" readonly>
                </div>
                <div class="form-group">
                    <label>Custom Comments</label>
                    <textarea class="form-control" id="custom_comments" readonly></textarea>
                </div>
                <div class="form-group">
                    <label>Custom Link</label>
                    <input type="text" class="form-control" id="custom_link" readonly>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="text" class="form-control" id="quantity" readonly>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jumlah Awal</label>
                            <input type="text" class="form-control" id="start_count" readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jumlah Kurang</label>
                            <input type="text" class="form-control" id="remains" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function detail(id) {
        $("#modalDetail").modal('show');
        $.ajax({
            url: "{{url('ajax/detail-social')}}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $("#id").val(data.id);
                $("#service").val(data.service_name);
                $("#target").val(data.target);
                $("#custom_comments").val(data.comments);
                $("#custom_link").val(data.link);
                $("#quantity").val(data.quantity);
                $("#profit").val(formatRupiah(data.profit));
                $("#start_count").val(data.start_count);
                $("#remains").val(data.remains);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    var table = $('#simpletable').DataTable({
        ajax: "{{url('data/order-history')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'from',
                name: 'from'
            },
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'service_name',
                name: 'service_name'
            },
            {
                data: 'target',
                name: 'target'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'quantity',
                name: 'quantity'
            },
            {
                data: 'start_count',
                name: 'start_count'
            },
            {
                data: 'remains',
                name: 'remains'
            },
            {
                data: 'detail',
                name: 'detail'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
        ],
    });

    function cancel(id) {
        Swal.fire({
            title: 'Anda yakin Cancel Pesanan?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batalkan Pesanan!'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = new FormData();
                form.append('_token', token);
                form.append('action', 'cancel');
                form.append('id', id);
                axios.post(`{{ url('ajax/change-order') }}`, form)
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
                                text: 'Berhasil Melakukan Request Cancel Pesanan!',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
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
                    })
                table.ajax.reload();
            }
        })
    }

    function refill(id) {
        Swal.fire({
            title: 'Anda yakin Cancel Pesanan?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batalkan Pesanan!'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = new FormData();
                form.append('_token', token);
                form.append('action', 'refill');
                form.append('id', id);
                axios.post(`{{ url('ajax/change-order') }}`, form)
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
                                text: 'Berhasil Melakukan Request Cancel Pesanan!',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
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
                    })
                table.ajax.reload();
            }
        })
    }
</script>
@endsection