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
                                <th>Deskripsi Lengkap</th>
                                <th>Deskripsi Singkat</th>
                                <th>Images</th>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Upload New Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control select_type" name="type" data-type="add" required>
                            <option value="null">-- Select Type --</option>
                            <option value="ppob">PPOB</option>
                            <option value="custom">Custom Layanan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control add_category" name="name" required>
                            <option value="null">-- Pilih Type Dahulu --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input class="form-control" type="file" name="image" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category" required>
                            <option value="null">-- Select Category --</option>
                            <option value="topup">Topup</option>
                            <option value="pulsa">Pulsa</option>
                            <option value="internet">Internet</option>
                            <option value="pln">PLN</option>
                            <option value="voucher">Voucher</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi singkat</label>
                        <input class="form-control" type="text" name="short_description" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="long_description" required></textarea>
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
        <form id="edit" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="status" value="edit">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control select_type" id="edit_type" name="type" data-type="edit" required>
                            <option value="null">-- Select Type --</option>
                            <option value="smm">SMM</option>
                            <option value="ppob">PPOB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control edit_category" id="edit_name" name="name" required>
                            <option value="null">-- Pilih Type Dahulu --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input class="form-control" type="file" name="image">
                        <span class="text-danger">* Kosongkan jika tidak ingin mengubah gambar</span>
                    </div>
                    <div class="form-group">
                        <label>Categry</label>
                        <select class="form-control" id="edit_category" name="category" required>
                            <option value="null">-- Select Category --</option>
                            <option value="smm">SMM</option>
                            <option value="topup">Topup</option>
                            <option value="ppob">PPOB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" required></textarea>
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
        <form id="hapus" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Hapus Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="hapus_id" value="">
                    <input type="hidden" name="status" value="hapus">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control select_type" id="hapus_type" name="type" data-type="edit" disabled>
                            <option value="null">-- Select Type --</option>
                            <option value="smm">SMM</option>
                            <option value="ppob">PPOB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control edit_category" id="hapus_name" name="name" disabled>
                            <option value="null">-- Pilih Type Dahulu --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input class="form-control" type="file" name="image" disabled>
                        <span class="text-danger">* Kosongkan jika tidak ingin mengubah gambar</span>
                    </div>
                    <div class="form-group">
                        <label>Categry</label>
                        <select class="form-control" id="hapus_category" name="category" disabled>
                            <option value="null">-- Select Category --</option>
                            <option value="smm">SMM</option>
                            <option value="topup">Topup</option>
                            <option value="ppob">PPOB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="hapus_description" name="description" required></textarea>
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
    var url = "{{url('data/category_images')}}"
    var columns = [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'short_description',
            name: 'short_description'
        },
        {
            data: 'long_description',
            name: 'long_description'
        },
        {
            data: 'path',
            name: 'path'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        },
    ];
    var token = '{{ csrf_token() }}'
    var table = renderDataTable(url, columns);
    $("#add").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/category_images')}}", form)
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
                $(".modalAdd").modal('hide');
                if (error.response) {
                    let errorList = '';
                    errorList += '<ul style="list-style-type: none;">';
                    $.each(error.response.data.errors, function(key, value) {
                        errorList += '<li>' + value + '</li>';
                    });
                    errorList += '</ul>';
                    setTimeout(function() {
                        swal.fire({
                            title: 'Oops...',
                            icon: 'error',
                            html: errorList,
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                } else if (error.request) {
                    // The request was made but no response was received
                    // console.log(error.request);
                    setTimeout(function() {
                        swal.fire({
                            title: 'Oops...',
                            icon: 'error',
                            text: 'Something went wrong!',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                }
                // setTimeout(function() {
                //     swal.fire({
                //         text: error.message,
                //         icon: 'error',
                //         buttonsStyling: false,
                //         confirmButtonText: 'Ok lets check',
                //         customClass: {
                //             confirmButton: 'btn font-weight-bold btn-danger',
                //         },
                //     });
                // }, 200)
            });
    })
    $(".select_type").on('change', (function() {
        const {
            type
        } = $(this).data();
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "{{url('ajax/getCategory')}}/" + $(this).val(),
            success: function(data) {
                $(`.${type}_category`).empty();
                $(`.${type}_category`).append(data);
            }
        })
    }))

    function edit(id) {
        $(".modalEdit").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('data/category_images')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_type").val(data.type);
                $('#edit_type').trigger('change');
                setInterval(function() {
                    $("#edit_name").val(data.name);
                }, 200);
                $("#edit_category").val(data.category);
                $("#edit_description").val(data.description);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/category_images')}}", form)
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
                if (error.response) {
                    let errorList = '';
                    errorList += '<ul style="list-style-type: none;">';
                    $.each(error.response.data.errors, function(key, value) {
                        errorList += '<li>' + value + '</li>';
                    });
                    errorList += '</ul>';
                    setTimeout(function() {
                        swal.fire({
                            title: 'Oops...',
                            icon: 'error',
                            html: errorList,
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                } else if (error.request) {
                    // The request was made but no response was received
                    // console.log(error.request);
                    setTimeout(function() {
                        swal.fire({
                            title: 'Oops...',
                            icon: 'error',
                            text: 'Something went wrong!',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                }
            });
    })

    function hapus(id) {
        $(".modalHapus").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('data/category_images')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_type").val(data.type);
                $('#hapus_type').trigger('change');
                setInterval(function() {
                    $("#hapus_name").val(data.name);
                }, 200);
                $("#hapus_category").val(data.category);
                $("#hapus_description").val(data.description);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/category_images')}}", form)
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