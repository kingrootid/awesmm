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
                                <th>ID Pemesanan</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Detail</th>
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
                $("#order_id").val(data.order_id);
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
        ajax: "{{url('data/request-history')}}",
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
                data: 'detail',
                name: 'detail'
            },
        ],
    });
</script>
@endsection