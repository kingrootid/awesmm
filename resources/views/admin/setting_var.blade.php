@extends('admin.template')
@section('view')
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{$page}}</h5>
            </div>
            <form method="POST" id="submit">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">Nama Website</label>
                        <input type="text" class="form-control" name="site_name" value="{{ get_config('site_name') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Logo Website ( Terang )</label>
                        <input type="file" class="form-control" name="logo" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Logo Website ( Gelap )</label>
                        <input type="file" class="form-control" name="logo_dark" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Icon Website</label>
                        <input type="file" class="form-control" name="icon" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Meta description</label>
                        <textarea class="form-control" name="meta_description">{{ get_config('meta_description') }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Meta keywords</label>
                        <textarea class="form-control" name="meta_keyword">{{ get_config('meta_keyword') }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Theme Color Website</label>
                        <input type="text" class="form-control" name="meta_color" value="{{ get_config('meta_color') }}">
                        <small class="text-danger">*untuk mobile warna chrome taskbar</small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Provider Markup</label>
                        <input type="text" class="form-control" name="provider_markup" value="{{ get_config('provider_markup') }}">
                        <small class="text-danger">persen / fixed</small><br />
                        <small class="text-danger">bertujuan untuk mengatur pengambilan profit untuk provider</small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Rate USD</label>
                        <input type="text" class="form-control" name="rate_usd" value="{{ get_config('rate_usd') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Bonus Payment Gateway</label>
                        <input type="text" class="form-control" name="bonus_payment_gateway" value="{{ get_config('bonus_payment_gateway') }}">
                        <small class="text-danger">bertujuan untuk mengatur bonus payment gateway</small><br />
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Setting Minimal Deposit</label>
                        <input type="text" class="form-control" name="deposit_minimal" value="{{ get_config('deposit_minimal') }}">
                        <small class="text-danger">bertujuan untuk mengatur minimal deposit</small><br />
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Setting Minimal Deposit</label>
                        <input type="text" class="form-control" name="saldo_minimal" value="{{ get_config('saldo_minimal') }}">
                        <small class="text-danger">bertujuan untuk mengatur minimal deposit</small><br />
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Zero config table end -->
</div>
@endsection
@section('script')
<script>
    $("#submit").on('submit', function(e) {
        e.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('admin/ajax/setting-update')}}", form)
            .then(response => {
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
                            window.location.reload();
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