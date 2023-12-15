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
                                <th>Name</th>
                                <th>Note</th>
                                <th>Min</th>
                                <th>Bonus</th>
                                <th>Rate</th>
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
        <form id="add" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Add Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Icon</label>
                        <input type="file" class="form-control" name="icon">
                    </div>
                    <div class="form-group mb-3">
                        <label>Note</label>
                        <textarea class="form-control" rows="10" name="note" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Min</label>
                        <input type="text" class="form-control" name="min" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bonus</label>
                        <input type="number" class="form-control" name="bonus" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Rate</label>
                        <input type="text" class="form-control" name="rate" required>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="status" value="edit">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Icon</label>
                        <input type="file" class="form-control" name="icon">
                    </div>
                    <div class="form-group mb-3">
                        <label>Note</label>
                        <textarea class="form-control" rows="10" id="edit_note" name="note" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Min</label>
                        <input type="text" class="form-control" id="edit_min" name="min" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bonus</label>
                        <input type="number" class="form-control" id="edit_bonus" name="bonus" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Rate</label>
                        <input type="text" class="form-control" id="edit_rate" name="rate" required>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Hapus Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="hapus_id" value="">
                    <input type="hidden" name="status" value="hapus">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" id="hapus_name" name="name" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label>Icon</label>
                        <input type="file" class="form-control" name="icon">
                    </div>
                    <div class="form-group mb-3">
                        <label>Note</label>
                        <textarea class="form-control" rows="10" id="hapus_note" name="note" disabled></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Min</label>
                        <input type="text" class="form-control" id="hapus_min" name="min" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bonus</label>
                        <input type="text" class="form-control" id="hapus_bonus" name="bonus" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label>Rate</label>
                        <input type="text" class="form-control" id="hapus_rate" name="rate" disabled>
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
        ajax: "{{url('admin/data/method')}}",
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
                data: 'note',
                name: 'note'
            },
            {
                data: 'min',
                name: 'min'
            }, {
                data: 'bonus',
                name: 'bonus'
            },
            {
                data: 'rate',
                name: 'rate'
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
        axios.post("{{url('admin/ajax/method')}}", form)
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
            url: "{{url('admin/data/method')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_name").val(data.name);
                $("#edit_note").val(data.note);
                $("#edit_min").val(data.min);
                $("#edit_bonus").val(data.bonus);
                $("#edit_rate").val(data.rate);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/method')}}", form)
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
            url: "{{url('admin/data/method')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_name").val(data.name);
                $("#hapus_note").val(data.note);
                $("#hapus_min").val(data.min);
                $("#hapus_bonus").val(data.bonus);
                $("#hapus_rate").val(data.rate);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/method')}}", form)
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