@extends('template')
@section('view')
<div class="row">
    <div class="col-md-8 col-12 m-auto">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user-cog"></i> Pengaturan Profile</h5>
            </div>
            <form id="update" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Tulis Password Baru">
                        <small class="text-danger">* Kosongkan jika tidak ingin mengganti password</small>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Tulis Konfirmasi Password Baru">
                        <small class="text-danger">* Kosongkan jika tidak ingin mengganti password</small>
                    </div>
                    <div class="form-group">
                        <label>Password saat ini</label>
                        <input type="password" class="form-control" name="current_password" placeholder="Tulis Password Saat Ini">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script>
    $("#update").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        axios.post(`{{ url('ajax/user-settings') }}`, formData)
            .then(res => {
                if (res.data.status) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: res.data.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        text: res.data.message,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                if (error.response) {
                    const data = error.response.data;
                    var errorAjax = data.errors;
                    let errorMessage = '';
                    Object.keys(errorAjax).map(function(key) {
                        errorMessage += errorAjax[key][0] + '<br/>'
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorMessage,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Server mengalami masalah!',
                    })
                }
            });
    });
</script>
@endsection