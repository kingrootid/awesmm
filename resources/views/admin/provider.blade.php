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
                <div class="dt-responsive table-responsive">
                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>API Order</th>
                                <th>API Status</th>
                                <th>API Service</th>
                                <th>API Profile</th>
                                <th>API Refill</th>
                                <th>API Key</th>
                                <th>API ID</th>
                                <th>Markup</th>
                                <th>Type Provider</th>
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
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Order</label>
                        <input type="url" class="form-control" name="api_url_order" placeholder="URL API Order Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Status</label>
                        <input type="url" class="form-control" name="api_url_status" placeholder="URL API Status Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Service</label>
                        <input type="url" class="form-control" name="api_url_service" placeholder="URL API Services Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Profile</label>
                        <input type="url" class="form-control" name="api_url_profile" placeholder="URL API Profile Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Profile</label>
                        <input type="url" class="form-control" name="api_url_refill" placeholder="URL API Refill Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API KEY</label>
                        <input type="text" class="form-control" name="api_key" placeholder="API KEY Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API ID</label>
                        <input type="text" class="form-control" name="api_id" placeholder="API ID Provider">
                    </div>
                    <div class="form-group mb-3">
                        <label>Markup</label>
                        <input type="number" class="form-control" name="markup" placeholder="Markup Service for auto get services" value="0">
                    </div>
                    <div class="form-group mb-3">
                        <label>Type</label>
                        <select class="form-control" name="type" required>
                            <option value="LUAR">LUAR</option>
                            <option value="INDO">INDO</option>
                            <option value="INDO OLD">INDO OLD</option>
                            <option value="UNDRCTRL">UNDRCTRL</option>
                            <option value="BuzzerPanel">BuzzerPanel</option>
                            <option value="Manual">Manual</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
                        <label>Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Nama Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Order</label>
                        <input type="url" class="form-control" id="edit_api_url_order" name="api_url_order" placeholder="URL API Order Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Status</label>
                        <input type="url" class="form-control" id="edit_api_url_status" name="api_url_status" placeholder="URL API Status Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Service</label>
                        <input type="url" class="form-control" id="edit_api_url_service" name="api_url_service" placeholder="URL API Services Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Profile</label>
                        <input type="url" class="form-control" id="edit_api_url_profile" name="api_url_profile" placeholder="URL API Profile Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Profile</label>
                        <input type="url" class="form-control" id="edit_api_url_refill" name="api_url_refill" placeholder="URL API Refill Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API KEY</label>
                        <input type="text" class="form-control" id="edit_api_key" name="api_key" placeholder="API KEY Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API ID</label>
                        <input type="text" class="form-control" id="edit_api_id" name="api_id" placeholder="API ID Provider">
                    </div>
                    <div class="form-group mb-3">
                        <label>Markup</label>
                        <input type="number" class="form-control" id="edit_markup" name="markup" placeholder="Markup Service for auto get services" value="0">
                    </div>
                    <div class="form-group mb-3">
                        <label>Type</label>
                        <select class="form-control" id="edit_type" name="type" required>
                            <option value="LUAR">LUAR</option>
                            <option value="INDO">INDO</option>
                            <option value="INDO OLD">INDO OLD</option>
                            <option value="UNDRCTRL">UNDRCTRL</option>
                            <option value="BuzzerPanel">BuzzerPanel</option>
                            <option value="Manual">Manual</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Edit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
                        <label>Name</label>
                        <input type="text" class="form-control" id="hapus_name" name="name" placeholder="Nama Provider" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Order</label>
                        <input type="url" class="form-control" id="hapus_api_url_order" name="api_url_order" placeholder="URL API Order Provider" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Status</label>
                        <input type="url" class="form-control" id="hapus_api_url_status" name="api_url_status" placeholder="URL API Status Provider" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Service</label>
                        <input type="url" class="form-control" id="hapus_api_url_service" name="api_url_service" placeholder="URL API Services Provider" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Profile</label>
                        <input type="url" class="form-control" id="hapus_api_url_profile" name="api_url_profile" placeholder="URL API Services Provider" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>API URL Profile</label>
                        <input type="url" class="form-control" id="hapus_api_url_refill" name="api_url_refill" placeholder="URL API Refill Provider" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>API KEY</label>
                        <input type="text" class="form-control" id="hapus_api_key" name="api_key" placeholder="API KEY Provider" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>API ID</label>
                        <input type="text" class="form-control" id="hapus_api_id" name="api_id" placeholder="API ID Provider" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>Markup</label>
                        <input type="number" class="form-control" id="hapus_markup" name="markup" placeholder="Markup Service for auto get services" value="0" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>Type</label>
                        <select class="form-control" id="hapus_type" name="type" disabled>
                            <option value="LUAR">LUAR</option>
                            <option value="INDO">INDO</option>
                            <option value="INDO OLD">INDO OLD</option>
                            <option value="UNDRCTRL">UNDRCTRL</option>
                            <option value="BuzzerPanel">BuzzerPanel</option>
                            <option value="Manual">Manual</option>
                        </select>
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
        ajax: "{{url('admin/data/provider')}}",
        processing: true,
        search: false,
        serverSide: true,
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'api_url_order',
                name: 'api_url_order'
            },
            {
                data: 'api_url_status',
                name: 'api_url_status'
            },
            {
                data: 'api_url_service',
                name: 'api_url_service'
            },
            {
                data: 'api_url_profile',
                name: 'api_url_profile'
            },
            {
                data: 'api_url_refill',
                name: 'api_url_refill'
            },
            {
                data: 'api_key',
                name: 'api_key'
            },
            {
                data: 'api_id',
                name: 'api_id'
            },
            {
                data: 'markup',
                name: 'markup'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            }
        ],
    });
    $("#add").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/provider')}}", form)
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
            url: "{{url('admin/data/provider')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_name").val(data.name);
                $("#edit_api_url_status").val(data.api_url_status);
                $("#edit_api_url_order").val(data.api_url_order);
                $("#edit_api_url_service").val(data.api_url_service);
                $("#edit_api_url_profile").val(data.api_url_profile);
                $("#edit_api_url_refill").val(data.api_url_refill);
                $("#edit_api_key").val(data.api_key);
                $("#edit_api_id").val(data.api_id);
                $("#edit_markup").val(data.markup);
                $("#edit_type").val(data.type);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/provider')}}", form)
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
            url: "{{url('admin/data/provider')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_name").val(data.name);
                $("#hapus_api_url_status").val(data.api_url_status);
                $("#hapus_api_url_order").val(data.api_url_order);
                $("#hapus_api_url_service").val(data.api_url_service);
                $("#hapus_api_url_profile").val(data.api_url_profile);
                $("#hapus_api_url_refill").val(data.api_url_refill);
                $("#hapus_api_key").val(data.api_key);
                $("#hapus_api_id").val(data.api_id);
                $("#hapus_markup").val(data.markup);
                $("#hapus_type").val(data.type);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/provider')}}", form)
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