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
                    <div class="row mb-3">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <select name="category" id="category" class="form-control form-select">
                                    <option value="">Filter Category</option>
                                    @foreach($category as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-100" id="search">Search</button>
                            </div>
                        </div>
                    </div>
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Favorit</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Harga /1000</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Rata Rata Process</th>
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
<div class="modal fade modalDetail" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Detail Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="footable table table-hover">
                        <tbody>
                            <tr>
                                <td class="alert alert-primary" width="25%"><strong>ID</strong></td>
                                <td id="id"></td>
                            </tr>
                            <tr>
                                <td class="alert alert-primary"><strong>Layanan</strong></td>
                                <td id="name"></td>
                            </tr>
                            <tr>
                                <td class="alert alert-primary"><strong>Description</strong></td>
                                <td class="text-wrap" id="description"></td>
                            </tr>

                            <tr>
                                <td class="alert alert-primary"><strong>Min</strong></td>
                                <td id="min"></td>
                            </tr>

                            <tr>
                                <td class="alert alert-primary"><strong>Max</strong></td>
                                <td id="max"></td>
                            </tr>
                            <tr>
                                <td class="alert alert-primary"><strong>Type</strong></td>
                                <td id="type"></td>
                            </tr>
                            <tr>
                                <td class="alert alert-primary"><strong>AVERAGE TIME <span class="ml-1 mr-1 fa fa-exclamation-circle" data-bs-toggle="tooltip" data-placement="right" title="Waktu rata-rata didasarkan pada 10 pesanan terakhir."></span></strong></td>
                                <td id="average"></td>
                            </tr>
                        </tbody>
                    </table>
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
    var table = $('#simpletable').DataTable({
        ajax: {
            url: "{{url('data/price/social')}}",
            type: "GET",
            data: function(d) {
                d.filter_order = $('#filter_order').val();
                d.urutan = $('#urutan').val();
                d.category = $('#category').val();
            }
        },
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id',
                orderable: false
            },
            {
                data: 'favorite',
                name: 'favorite',
                orderable: false
            },
            {
                data: 'category',
                name: 'categories.name',
                orderable: false
            },
            {
                data: 'name',
                name: 'name',
                orderable: false
            },
            {
                data: 'price',
                name: 'price',
                orderable: false
            },
            {
                data: 'min',
                name: 'min',
                orderable: false
            },
            {
                data: 'max',
                name: 'max',
                orderable: false
            },
            {
                data: 'avg_time',
                name: 'avg_time',
                orderable: false
            },
            {
                data: 'detail',
                name: 'detail',
                orderable: false
            },
        ],
    });
    $("#search").on("click", function() {
        table.draw();
    });

    function fav(id) {
        $.ajax({
            type: "POST",
            data: {
                service: id,
                _token: token
            },
            url: "{{ url('ajax/favorite-services') }}",
            dataType: "JSON",
            success: function(data) {
                if (!data.status) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi Kesalahan!',
                    })
                } else {
                    table.ajax.reload();
                }
            },
        });
    }

    function detail(id) {
        $(".modalDetail").modal('show');
        $.ajax({
            type: "POST",
            data: {
                id: id,
                _token: token
            },
            dataType: "json",
            url: "{{url('ajax/detail-social')}}",
            success: function(data) {
                $("#id").html(data.data.id);
                $("#name").html(data.data.name);
                $("#type").html(data.data.type);
                $("#description").html(data.data.description);
                $("#min").html(data.data.min);
                $("#max").html(data.data.max);
                $("#average").html(!data.average ? 'Tidak ada data' : data.average);
            }
        })
    }
</script>
@endsection