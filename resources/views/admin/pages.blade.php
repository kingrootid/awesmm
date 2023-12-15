@extends('admin.template')
@section('view')
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header" style="display: flex; justify-items:center; justify-content:space-between; ">
                <h5 style="align-self: center;">{{$page}} Management</h5>
            </div>
            <div class="card-body">
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Action</th>
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
        ajax: "{{url('admin/data/pages')}}",
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'pages',
                name: 'pages'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },
        ],
    });
</script>
@endsection