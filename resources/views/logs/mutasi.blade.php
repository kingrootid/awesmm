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
                                <th>Type</th>
                                <th>Jumlah</th>
                                <th>Pesan</th>
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
@endsection
@section('js')
<script>
    var table = $('#simpletable').DataTable({
        ajax: "{{url('data/mutasi')}}",
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
                data: 'amount',
                name: 'amount'
            },
            {
                data: 'note',
                name: 'note'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
        ],
    });
</script>
@endsection