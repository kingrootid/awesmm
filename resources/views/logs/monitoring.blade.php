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
                                <th>ID</th>
                                <th>Nama Layanan</th>
                                <th>Quantity</th>
                                <th>Rata Rata Pengiriman</th>
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
@endsection
@section('script')
<script>
    var table = $('#simpletable').DataTable({
        ajax: "{{url('data/monitoring')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false

            },
            {
                data: 'service_name',
                name: 'service_name',
                orderable: false
            },
            {
                data: 'quantity',
                name: 'quantity',
                orderable: false
            },
            {
                data: 'timediff',
                name: 'timediff',
                orderable: false
            },
        ],
    });
</script>
@endsection