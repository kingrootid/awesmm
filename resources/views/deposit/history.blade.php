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
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Get</th>
                                <th>Status</th>
                                <th>Tanggal & Jam</th>
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
@endsection
@section('script')
<script>
    var table = $('#simpletable').DataTable({
        ajax: "{{url('data/deposit-history')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'method',
                name: 'method'
            },
            {
                data: 'amount',
                name: 'amount'
            },
            {
                data: 'get',
                name: 'get'
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

    function invoice(id) {
        window.location.href = "{{url('deposit/invoice')}}/" + id;
    }
</script>
@endsection