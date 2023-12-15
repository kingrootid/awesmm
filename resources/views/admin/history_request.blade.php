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
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID Pemesanan</th>
                                <th>ID Pemesanan Provider</th>
                                <th>ID Permintaan Provider</th>
                                <th>User</th>
                                <th>Provider</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Log Process</th>
                                <th>Log Response</th>
                                <th>Tanggal</th>
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
                <h5 class="modal-title h4" id="myLargeModalLabel">Edit Permintaan Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="edit">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group mb-3">
                        <label>Status Permintaan</label>
                        <select class="form-control" name="status" id="edit_status">
                            <option value="Pending">Pending</option>
                            <option value="Process">Process</option>
                            <option value="Success">Success</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
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
    var table = $('#simpletable').DataTable({
        ajax: "{{url('admin/data/request-history')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'order_id',
                name: 'order_id'
            },
            {
                data: 'provider_order_id',
                name: 'provider_order_id'
            },
            {
                data: 'provider_request_id',
                name: 'provider_request_id'
            },
            {
                data: 'users_name',
                name: 'users.name'
            },
            {
                data: 'provider_name',
                name: 'providers.name'
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
                data: 'log_process',
                name: 'log_process'
            },
            {
                data: 'log_respond',
                name: 'log_respond'
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

    function edit(id) {
        $("#modalEdit").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('admin/data/request-history')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_status").val(data.status);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/order-request')}}", form)
            .then(response => {
                $("#modalEdit").modal('hide');
                if (response.data.error == 0) {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $("#modalEdit").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
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
                $("#modalEdit").modal('hide')
                setTimeout(function() {
                    swal.fire({
                        text: error.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok lets check',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-danger',
                        },
                    });
                }, 200)
            });
    })
</script>
@endsection