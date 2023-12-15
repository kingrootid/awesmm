@extends('admin.template')
@section('view')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h5>{{$page}} Management</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="mb-1 col-md-4">
                        <select class="select2 form-select" name="provider">
                            <option value="null">Silahkan Pilih Provider</option>
                            @foreach($provider as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1 col-md-4">
                        <input class="form-control" type="text" name="datefilter" placeholder="Masukan Filter Tanggal" />
                    </div>
                    <div class="mb-1 col-md-4 d-grid">
                        <button type="button" id="filter" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr class="table-warning">
                            <th>Pending</th>
                            <td id="pending">Rp 0 dari 0 pesanan.</td>
                        </tr>
                        <tr class="table-info">
                            <th>Processing</th>
                            <td id="processing">Rp 0 dari 0 pesanan.</td>
                        </tr>
                        <tr class="table-success">
                            <th>Success</th>
                            <td id="success">Rp 0 dari 0 pesanan.</td>
                        </tr>
                        <tr class="table-danger">
                            <th>Error</th>
                            <td id="error">Rp 0 dari 0 pesanan.</td>
                        </tr>
                        <tr class="table-danger">
                            <th>Partial</th>
                            <td id="partial">Rp 0 dari 0 pesanan.</td>
                        </tr>
                        <tr>
                            <th>Total Penggunaan Saldo Member</th>
                            <td id="use_balance">Rp 0 dari 0 pesanan.</td>
                        </tr>
                        <tr>
                            <th>Total Penggunaan Saldo Provider</th>
                            <td id="provider_price">Rp 0 dari 0 pesanan.</td>
                        </tr>
                        <tr>
                            <th>Total Profit Bersih</th>
                            <td id="profit">Rp 0 dari 0 pesanan.</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Zero config table end -->
</div>
@endsection
@section('script')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    var token = '{{ csrf_token() }}'
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        },
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    function formatRupiah(bilangan) {
        var number_string = bilangan.toString().replace(/[^,\d]/g, ''),
            split = number_string.split('.'),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp. ' + rupiah;
    }
    $("#filter").click(function(e) {
        e.preventDefault();
        var provider = $("select[name='provider']").val();
        var datefilter = $("input[name='datefilter']").val();
        $.ajax({
            url: "{{ url('ajax/report-order') }}",
            type: "POST",
            data: {
                _token: token,
                provider: provider,
                datefilter: datefilter
            },
            success: function(data) {
                var total;
                var rateUsd = "{{ get_config('rate_usd') }}";
                $("#pending").html(`${formatRupiah(Math.round(data.pending.all_pending_price))} dari ${data.pending.order_pending} pesanan.`);
                $("#processing").html(`${formatRupiah(Math.round(data.processing.all_processing_price))} dari ${data.processing.order_processing} pesanan.`);
                $("#success").html(`${formatRupiah(Math.round(data.success.all_success_price))} dari ${data.success.order_success} pesanan.`);
                $("#error").html(`${formatRupiah(Math.round(data.error.all_error_price))} dari ${data.error.order_error} pesanan.`);
                $("#partial").html(`${formatRupiah(Math.round(data.partial.all_partial_price))} dari ${data.partial.order_partial} pesanan.`);
                $("#use_balance").html(`${formatRupiah(Math.round(data.count_order.all_total_price))} dari ${data.count_order.all_total_order} pesanan.`);
                if (provider == 1) {
                    total = data.count_provider.all_provider_price * rateUsd
                    $("#provider_price").html(`Rp. ${total} dari ${data.count_order.all_total_order} pesanan.`);
                } else {
                    total = data.count_provider.all_provider_price
                    $("#provider_price").html(`${formatRupiah(Math.round(data.count_provider.all_provider_price))} dari ${data.count_order.all_total_order} pesanan.`);
                }
                $("#profit").html(`${formatRupiah(Math.round(data.count_order.all_total_price - total))} dari ${data.count_order.all_total_order} pesanan.`);
            }
        });
    })
</script>
@endsection