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
                <div class="row mb-3">
                    <div class="col-md-6 col-sm-12">
                        <select name="status" id="search_status" class="form-select">
                            <option value="">Filter Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Success">Success</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <button class="btn btn-primary w-100" id="search">Search</button>
                    </div>
                </div>
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Get</th>
                                <th>Status</th>
                                <th>Tanggal & Jam</th>
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
    $("#search").on("click", function() {
        table.draw();
    });
    var table = $('#simpletable').DataTable({
        ajax: {
            url: "{{url('admin/data/history_deposits')}}",
            type: "GET",
            data: function(d) {
                d.status = $('#search_status').val();
            }
        },
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'user_name',
                name: 'users.name'
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
                data: 'action',
                name: 'action',
                orderable: false
            }
        ],
    });

    function accept(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "To Accept this deposit?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: {
                        action: 'accept',
                        id: id,
                        _token: token
                    },
                    dataType: "json",
                    url: "{{url('admin/ajax/deposit')}}",
                    success: function(data) {
                        if (data.error == 0) {
                            setTimeout(function() {
                                swal.fire({
                                    text: data.message,
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: {
                                        confirmButton: 'btn font-weight-bold btn-primary',
                                    },
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            }, 200);
                        } else {
                            setTimeout(function() {
                                swal.fire({
                                    text: data.message,
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok lets check',
                                    customClass: {
                                        confirmButton: 'btn font-weight-bold btn-danger',
                                    },
                                });
                            }, 200);
                        }
                    }
                })
            }
        })
    }

    function tarik(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "To Retake this deposit?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: {
                        action: 'tarik',
                        id: id,
                        _token: token
                    },
                    dataType: "json",
                    url: "{{url('admin/ajax/deposit')}}",
                    success: function(data) {
                        if (data.error == 0) {
                            setTimeout(function() {
                                swal.fire({
                                    text: data.message,
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: {
                                        confirmButton: 'btn font-weight-bold btn-primary',
                                    },
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            }, 200);
                        } else {
                            setTimeout(function() {
                                swal.fire({
                                    text: data.message,
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok lets check',
                                    customClass: {
                                        confirmButton: 'btn font-weight-bold btn-danger',
                                    },
                                });
                            }, 200);
                        }
                    }
                })
            }
        })
    }

    function cancel(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "To Cancel this deposit?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: {
                        action: 'cancel',
                        id: id,
                        _token: token
                    },
                    dataType: "json",
                    url: "{{url('admin/ajax/deposit')}}",
                    success: function(data) {
                        if (data.error == 0) {
                            setTimeout(function() {
                                swal.fire({
                                    text: data.message,
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: {
                                        confirmButton: 'btn font-weight-bold btn-primary',
                                    },
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            }, 200);
                        } else {
                            setTimeout(function() {
                                swal.fire({
                                    text: data.message,
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok lets check',
                                    customClass: {
                                        confirmButton: 'btn font-weight-bold btn-danger',
                                    },
                                });
                            }, 200);
                        }
                    }
                })
            }
        })
    }
</script>
@endsection