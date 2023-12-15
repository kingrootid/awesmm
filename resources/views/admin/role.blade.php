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
                                <th>Total Pembelanjaan</th>
                                <th>Total Discount</th>
                                <th>Bonus Deposit</th>
                                <th>Private Role</th>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Total Pembelanjaan</label>
                        <input type="text" class="form-control" name="total_spend" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Total Discount</label>
                        <input type="text" class="form-control" name="total_discount" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bonus Deposit</label>
                        <input type="text" class="form-control" name="bonus_deposit" required>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Private Role</legend>
                        <div class="col-12  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="private" value="1">
                                <label class="form-check-label"">
                                    Ya
                                </label>
                            </div>
                            <div class=" form-check">
                                    <input class="form-check-input" type="radio" name="private" value="0">
                                    <label class="form-check-label">
                                        Tidak
                                    </label>
                            </div>
                        </div>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="status" value="edit">
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Total Pembelanjaan</label>
                        <input type="text" class="form-control" id="edit_total_spend" name="total_spend" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Total Discount</label>
                        <input type="text" class="form-control" id="edit_total_discount" name="total_discount" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bonus Deposit</label>
                        <input type="text" class="form-control" id="edit_bonus_deposit" name="bonus_deposit" required>
                    </div>
                    <div class="row mb-3">
                        <legend class="col-12">Private Role</legend>
                        <div class="col-12  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="private" value="1">
                                <label class="form-check-label"">
                                    Ya
                                </label>
                            </div>
                            <div class=" form-check">
                                    <input class="form-check-input" type="radio" name="private" value="0">
                                    <label class="form-check-label">
                                        Tidak
                                    </label>
                            </div>
                        </div>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Hapus Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="hapus_id" value="">
                    <input type="hidden" name="status" value="hapus">
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="hapus_name" name="name" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label>Total Pembelanjaan</label>
                        <input type="text" class="form-control" id="hapus_total_spend" name="total_spend" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label>Total Discount</label>
                        <input type="text" class="form-control" id="hapus_total_discount" name="total_discount" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bonus Deposit</label>
                        <input type="text" class="form-control" id="hapus_bonus_deposit" name="bonus_deposit" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bonus Deposit</label>
                        <input type="text" class="form-control" id="hapus_price" name="price" required>
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
        ajax: "{{url('admin/data/role')}}",
        processing: true,
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
                data: 'total_spend',
                name: 'total_spend'
            },
            {
                data: 'total_discount',
                name: 'total_discount'
            },
            {
                data: 'bonus_deposit',
                name: 'bonus_deposit'
            },
            {
                data: 'private',
                name: 'private'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },
        ],
    });
    $("#add").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/role')}}", form)
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
            url: "{{url('admin/data/role')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_name").val(data.name);
                $("#edit_total_spend").val(data.total_spend);
                $("#edit_total_discount").val(data.total_discount);
                $("#edit_bonus_deposit").val(data.bonus_deposit);
                $("#edit_price").val(data.price);
                $("input[name='private'][value='" + data.private + "']").prop('checked', true);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/role')}}", form)
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
            url: "{{url('admin/data/role')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_name").val(data.name);
                $("#hapus_total_spend").val(data.total_spend);
                $("#hapus_total_discount").val(data.total_discount);
                $("#hapus_bonus_deposit").val(data.bonus_deposit);
                $("#hapus_price").val(data.price);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/role')}}", form)
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