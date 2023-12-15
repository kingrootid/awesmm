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
                                <th>Browser Agent</th>
                                <th>Alamat IP</th>
                                <th>Login Pada</th>
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
        ajax: "{{url('data/login')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'user_agent',
                name: 'user_agent'
            },
            {
                data: 'ip_address',
                name: 'ip_address'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
        ],
    });
</script>
@endsection