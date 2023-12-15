@extends('admin.template')
@section('view')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form id="edit" method="POST">
                <div class="card-body">
                    <input type="hidden" name="id" id="edit_id" value="{{ $pages['id'] }}">
                    <input type="hidden" name="status" value="edit">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" id="edit_name" readonly value="{{ $pages['pages'] }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Content</label>
                        <textarea class="form-control" name="content" id="edit_content">{{ $pages['content'] }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#edit_content'), {
            ckfinder: {
                uploadUrl: "{{url('admin/ajax/uploadImage').'?_token='.csrf_token()}}",
            }
        })
        .catch(error => {
            console.error(error);
        });
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/pages')}}", form)
            .then(response => {
                $("#modalEdit").modal('hide');
                if (response.data.error == 0) {
                    setTimeout(function() {
                        Swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = "{{ url('admin/pages') }}"
                            }
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        Swal.fire({
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
                    Swal.fire({
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