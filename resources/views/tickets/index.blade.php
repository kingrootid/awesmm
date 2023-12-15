@extends('template')
@section('view')
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header card-header-tambahan">
                <h5>{{$page}}</h5>
                <div class="float-right">
                    <button class="btn  btn-primary" data-bs-toggle="modal" data-bs-target=".modalAdd"><i class="fas fa-plus-square"></i> Tambahkan Ticket Baru</button>
                </div>
            </div>
            <div class="card-body">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Tanggal Laporan</th>
                                <th>Aksi</th>
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
<div class="modal fade modalAdd" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="add" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Ticket Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group">
                        <label class="floating-label">Type</label>
                        <select class="form-select" name="type" id="type">
                            <option value="Pemesanan">Pemesanan</option>
                            <option value="Refill">Refill</option>
                            <option value="Speed Up">Speed Up</option>
                            <option value="Cancel">Cancel</option>
                            <option value="Deposit">Deposit</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group mb-1" id="orderId" style="display: none;">
                        <label>Masukan Order ID</label>
                        <input type="text" class="form-control" name="orderId">
                        <span class="text-danger">Pisahkan Setiap order id dengan , (koma) dan tidak ada spasi | <b>13452,2442,23422</b></span>
                    </div>
                    <div class="form-group">
                        <label>Isi Pesan</label>
                        <textarea class="form-control" name="message" placeholder="Masukkan Pesan Anda"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $("#type").on('change', function() {
        var data = $(this).val();
        if (data == "Refill" || data == "Speed Up" || data == "Cancel") {
            $("#orderId").css('display', 'block');
        } else {
            $("#orderId").css('display', 'none');
        }
    });
    var table = $('#simpletable').DataTable({
        ajax: "{{url('data/tickets')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action'
            }
        ],
    });

    function reply(id) {
        window.location.href = "{{url('tickets/reply')}}/" + id;
    }

    function tutup(id) {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Ticket ini akan ditutup! dan tidak dapat dibuka kembali",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tutup!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('_token', token);
                formData.append('ticket_id', id);
                formData.append('status', 'close');
                $.ajax({
                    type: "POST",
                    url: "{{url('ajax/tickets')}}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (!data.error) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Ticket berhasil ditutup!',
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message,
                            })
                        }
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Server mengalami masalah!',
                        })
                    }
                });
            }
        })
    }
    $("#add").submit(function(e) {
        e.preventDefault();
        var form = $('#add')[0];
        var formData = new FormData(form);
        formData.append('_token', token);
        $.ajax({
            type: "POST",
            url: "{{url('ajax/tickets')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (!data.error) {
                    $('#add').trigger("reset");
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Ticket berhasil ditambahkan',
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message,
                    })
                }
                $('#modalAdd').modal('hide');
            },
            error: function(data) {
                $('#modalAdd').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Server mengalami masalah!',
                })
            }
        });
    });
</script>
@endsection