@extends('admin.template')
@section('view')
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header" style="display: flex; justify-items:center; justify-content:space-between; ">
                <h5 style="align-self: center;">{{$page}} Management</h5>
                <div class="align-self-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modalAdd"><i class="fas fa-plus-square"></i> Tambah Data</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <select class="form-select" name="provider" id="provider">
                                <option value="">Pilih Provider</option>
                                @foreach($provider as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <select class="form-select" name="category" id="category">
                                <option value="">Pilih Category</option>
                                @foreach($category as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100" id="search">Search</button>
                        </div>
                    </div>
                </div>
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Harga /1000</th>
                                <th>Profit /1000</th>
                                <th>Min/Max</th>
                                <th>Type</th>
                                <th>Provider</th>
                                <th>Layanan ID</th>
                                <th>Status</th>
                                <th>Cancel Button</th>
                                <th>Refill Button</th>
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
<div class="modal fade modalAdd" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="add" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group mb-3">
                        <label>Category</label>
                        <select class="form-select" name="category_id" required>
                            <option value="">-- Select Category --</option>
                            @foreach($category as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="description" placeholder="Deskripsi Layanan" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Harga</label>
                                <input type="text" class="form-control" name="price" placeholder="Harga" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Profit</label>
                                <input type="text" class="form-control" name="profit" placeholder="Profit" value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Min</label>
                                <input type="text" class="form-control" name="min" placeholder="Min" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Max</label>
                                <input type="text" class="form-control" name="max" placeholder="Max" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Provider</label>
                                <select class="form-select" name="provider" required>
                                    <option value="">-- Select Provider --</option>
                                    @foreach($provider as $p)
                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Layanan ID</label>
                                <input type="text" class="form-control" name="service_id" placeholder="ID Layanan" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Type</label>
                        <select class="form-select" name="type" required>
                            <option value="Default">Default</option>
                            <option value="Custom Comments">Custom Comments</option>
                            <option value="Custom Likes">Custom Likes</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Cancel Button</legend>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_canceled" id="status" value="1">
                                <label class="form-check-label">
                                    Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_canceled" id="status" value="0">
                                <label class="form-check-label">
                                    Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Refill Button</legend>
                        <div class="col-12  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_refill" id="refill" value="1">
                                <label class="form-check-label">
                                    Aktif
                                </label>
                            </div>
                            <div class=" form-check">
                                <input class="form-check-input" type="radio" name="is_refill" id="refill" value="0">
                                <label class="form-check-label">
                                    Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade modalEdit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="edit" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="status" value="edit">
                    <div class="form-group mb-3">
                        <label>Category</label>
                        <select class="form-select" id="edit_category_id" name="category_id" required>
                            <option value="">-- Select Category --</option>
                            @foreach($category as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Nama Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" placeholder="Deskripsi Layanan" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Harga</label>
                                <input type="text" class="form-control" id="edit_price" name="price" placeholder="Harga" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Profit</label>
                                <input type="text" class="form-control" id="edit_profit" name="profit" placeholder="Profit" value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Min</label>
                                <input type="text" class="form-control" id="edit_min" name="min" placeholder="Min" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Max</label>
                                <input type="text" class="form-control" id="edit_max" name="max" placeholder="Max" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Provider</label>
                                <select class="form-select" id="edit_provider" name="provider" required>
                                    <option value="">-- Select Provider --</option>
                                    @foreach($provider as $p)
                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Layanan ID</label>
                                <input type="text" class="form-control" id="edit_service_id" name="service_id" placeholder="ID Layanan" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Status Layanan</legend>
                        <div class="col-12  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_services" id="edit_status" value="1">
                                <label class="form-check-label">
                                    Aktif
                                </label>
                            </div>
                            <div class=" form-check">
                                <input class="form-check-input" type="radio" name="status_services" id="edit_status" value="0">
                                <label class="form-check-label">
                                    Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Type</label>
                        <select class="form-select" name="type" id="edit_type" required>
                            <option value="Default">Default</option>
                            <option value="Custom Comments">Custom Comments</option>
                            <option value="Custom Likes">Custom Likes</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Cancel Button</legend>
                        <div class="col-12  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_canceled" id="edit_is_canceled" value="1">
                                <label class="form-check-label">
                                    Aktif
                                </label>
                            </div>
                            <div class=" form-check">
                                <input class="form-check-input" type="radio" name="is_canceled" id="edit_is_canceled" value="0">
                                <label class="form-check-label">
                                    Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Refill Button</legend>
                        <div class="col-12  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_refill" id="id_is_refill" value="1">
                                <label class="form-check-label">
                                    Aktif
                                </label>
                            </div>
                            <div class=" form-check">
                                <input class="form-check-input" type="radio" name="is_refill" id="id_is_refill" value="0">
                                <label class="form-check-label">
                                    Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Edit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade modalHapus" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="hapus" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="hapus_id" value="">
                    <input type="hidden" name="status" value="hapus">
                    <div class="form-group mb-3">
                        <label>Category</label>
                        <select class="form-select" disabled id="hapus_category_id" name="category_id" required>
                            <option value="">-- Select Category --</option>
                            @foreach($category as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" disabled id="hapus_name" name="name" placeholder="Nama Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" disabled id="hapus_description" name="description" placeholder="Deskripsi Layanan" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Harga</label>
                                <input type="text" class="form-control" disabled id="hapus_price" name="price" placeholder="Harga" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Profit</label>
                                <input type="text" class="form-control" disabled id="hapus_profit" name="profit" placeholder="Profit" value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Min</label>
                                <input type="text" class="form-control" disabled id="hapus_min" name="min" placeholder="Min" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Max</label>
                                <input type="text" class="form-control" disabled id="hapus_max" name="max" placeholder="Max" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Provider</label>
                                <select class="form-select" disabled id="hapus_provider" name="provider" required>
                                    <option value="">-- Select Provider --</option>
                                    @foreach($provider as $p)
                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label>Layanan ID</label>
                                <input type="text" class="form-control" disabled id="hapus_service_id" name="service_id" placeholder="ID Layanan" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Status Layanan</legend>
                        <div class="col-12  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_services" disabled id="hapus_status" value="1">
                                <label class="form-check-label"">
                                    Aktif
                                </label>
                            </div>
                            <div class=" form-check">
                                    <input class="form-check-input" type="radio" name="status_services" disabled id="hapus_status" value="0">
                                    <label class="form-check-label">
                                        Tidak
                                    </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Type</label>
                        <select class="form-select" name="type" id="hapus_type" disabled>
                            <option value="Default">Default</option>
                            <option value="Custom Comments">Custom Comments</option>
                            <option value="Custom Likes">Custom Likes</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Cancel Button</legend>
                        <div class="col-12  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_canceled" id="hapus_is_canceled" value="1">
                                <label class="form-check-label"">
                                    Aktif
                                </label>
                            </div>
                            <div class=" form-check">
                                    <input class="form-check-input" type="radio" name="is_canceled" id="hapus_is_canceled" value="0">
                                    <label class="form-check-label">
                                        Tidak
                                    </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    var table = $('#simpletable').DataTable({
        ajax: {
            url: "{{url('admin/data/services')}}",
            type: "GET",
            data: function(d) {
                d.category = $('#category').val();
                d.provider = $('#provider').val();
            }
        },
        processing: true,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'category_id',
                name: 'category_id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'description',
                name: 'description'
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
                data: 'min_max',
                name: 'min_max'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'provider',
                name: 'provider'
            },
            {
                data: 'service_id',
                name: 'service_id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'is_canceled',
                name: 'is_canceled'
            },
            {
                data: 'is_refill',
                name: 'is_refill'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            }
        ],
    });
    $("#search").on("click", function() {
        table.draw();
    });
    $("#add").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/services')}}", form)
            .then(response => {
                $(".modalAdd").modal('hide');
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
                            $(".modalAdd").modal('hide');
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
                $(".modalAdd").modal('hide')
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

    function edit(id) {
        $(".modalEdit").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('admin/data/services')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_name").val(data.name);
                $("#edit_category_id").val(data.category_id);
                $("#edit_description").val(data.description);
                $("#edit_price").val(data.price);
                $("#edit_profit").val(data.profit);
                $("#edit_min").val(data.min);
                $("#edit_max").val(data.max);
                $("#edit_type").val(data.type);
                $("#edit_provider").val(data.provider);
                $("#edit_service_id").val(data.service_id);
                $("input[id='edit_status'][value='" + data.status + "']").prop('checked', true);
                $("input[id='edit_is_canceled'][value='" + data.is_canceled + "']").prop('checked', true);
                $("input[id='edit_is_refill'][value='" + data.is_refill + "']").prop('checked', true);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/services')}}", form)
            .then(response => {
                $(".modalEdit").modal('hide');
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
                            $(".modalEdit").modal('hide');
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
                $(".modalEdit").modal('hide')
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

    function hapus(id) {
        $(".modalHapus").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('admin/data/services')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_name").val(data.name);
                $("#hapus_category_id").val(data.category_id);
                $("#hapus_description").val(data.description);
                $("#hapus_price").val(data.price);
                $("#hapus_profit").val(data.profit);
                $("#hapus_min").val(data.min);
                $("#hapus_max").val(data.max);
                $("#hapus_type").val(data.type);
                $("#hapus_provider").val(data.provider);
                $("#hapus_service_id").val(data.service_id);
                $("input[id='hapus_status'][value='" + data.status + "']").prop('checked', true);
                $("input[id='hapus_is_canceled'][value='" + data.is_canceled + "']").prop('checked', true);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/services')}}", form)
            .then(response => {
                $(".modalHapus").modal('hide');
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
                            $(".modalHapus").modal('hide');
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
                $(".modalHapus").modal('hide')
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