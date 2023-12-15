@extends('admin.template')
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
                    <div class="row">
                        <div class="col-lg-6">
                            <select class="form-select mb-3 status" aria-label="Default select example">
                                <option value="" selected>Filter Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Success">Success</option>
                                <option value="Partial">Partial</option>
                                <option value="Canceled">Canceled</option>
                                <option value="Error">Error</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary w-100 waves-effect waves-light" id="search">Search</button>
                        </div>
                    </div>
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>User</th>
                                <th>Layanan</th>
                                <th>Target</th>
                                <th>Harga</th>
                                <th>Total Potong Saldo Provider</th>
                                <th>Jumlah Pemesanan</th>
                                <th>Jumlah Awal</th>
                                <th>Jumlah Kurang</th>
                                <th>Status</th>
                                <th>Provider</th>
                                <th>Tanggal</th>
                                <th>Dibuat</th>
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
                    <label>Order ID Provider</label>
                    <input type="text" class="form-control" id="order_id" readonly>
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
                <div class="form-group">
                    <label>Profit</label>
                    <input type="text" class="form-control" id="profit" readonly>
                </div>
                <div class="form-group">
                    <label>Log API Order</label>
                    <textarea class="form-control" id="logs_order" readonly></textarea>
                </div>
                <div class="form-group">
                    <label>Log API Status</label>
                    <textarea class="form-control" id="logs_status" readonly></textarea>
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
<div id="modalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Edit Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editOrder" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" class="form-control" id="edit_id" readonly>
                    </div>
                    <div class="form-group">
                        <label>Order ID Provider</label>
                        <input type="text" class="form-control" id="edit_order_id" readonly>
                    </div>
                    <div class="form-group">
                        <label>Layanan</label>
                        <input type="text" class="form-control" id="edit_service" readonly>
                    </div>
                    <div class="form-group">
                        <label>Target</label>
                        <input type="text" class="form-control" id="edit_target" readonly>
                    </div>
                    <div class="form-group">
                        <label>Custom Comments</label>
                        <textarea class="form-control" id="edit_custom_comments" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label>Custom Link</label>
                        <input type="text" class="form-control" id="edit_custom_link" readonly>
                    </div>
                    <div class="form-group">
                        <label>Start Count</label>
                        <input type="text" class="form-control" name="start_count" id="edit_start_count">
                    </div>
                    <div class="form-group">
                        <label>Remains</label>
                        <input type="text" class="form-control" name="remains" id="edit_remains">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Success">Success</option>
                            <option value="Partial">Partial</option>
                            <option value="Canceled">Canceled</option>
                            <option value="Error">Error</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function formatRupiah(bilangan) {
        var number_string = bilangan.toString().replace(/[^,\d]/g, ''),
            split = number_string.split('.'),
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

    function detail(id) {
        $("#modalDetail").modal('show');
        $.ajax({
            url: "{{url('admin/ajax/detail-social')}}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $("#id").val(data.id);
                $("#order_id").val(data.order_id);
                $("#service").val(data.service_name);
                $("#target").val(data.target);
                $("#custom_comments").val(data.comments);
                $("#custom_link").val(data.link);
                $("#quantity").val(data.quantity);
                $("#profit").val(formatRupiah(data.profit));
                $("#start_count").val(data.start_count);
                $("#remains").val(data.remains);
                $("#logs_order").val(data.logs_order);
                $("#logs_status").val(data.logs_status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function edit(id) {
        $("#modalEdit").modal('show');
        $.ajax({
            url: "{{url('admin/ajax/detail-social')}}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_order_id").val(data.order_id);
                $("#edit_service").val(data.service_name);
                $("#edit_target").val(data.target);
                $("#edit_custom_comments").val(data.comments);
                $("#edit_custom_link").val(data.link);
                $("#edit_quantity").val(data.quantity);
                $("#edit_status").val(data.status);
                $("#edit_start_count").val(data.start_count);
                $("#edit_remains").val(data.remains);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    $("#search").on("click", function() {
        table.draw();
    });
    var table = $('#simpletable').DataTable({
        ajax: {
            url: "{{url('admin/data/history_sosmed')}}",
            type: "GET",
            data: function(d) {
                d.status = $('.status').val();
            }
        },
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
                data: 'users_name',
                name: 'users.name'
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
                data: 'profit',
                name: 'profit'
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
                data: 'status',
                name: 'status'
            },
            {
                data: 'provider_name',
                name: 'providers.name'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'detail',
                name: 'detail'
            },
        ],
    });
    $("#editOrder").submit(function(e) {
        e.preventDefault();
        var form = new FormData($("#editOrder")[0]);
        form.append('_token', token);
        form.append('id', $("#edit_id").val());
        $.ajax({
            url: "{{url('admin/ajax/edit-social')}}",
            type: "POST",
            data: form,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $("#modalEdit").modal('hide');
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message,
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                    })
                    table.ajax.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });

    })
</script>
@endsection