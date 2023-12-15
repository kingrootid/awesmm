@extends('admin.template')
@section('view')
<!-- [ breadcrumb ] end -->
<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-md-12 col-xl-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                            Total User Balance</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span>
                                {{ rupiah(balance_all_user()) }} IDR
                            </span>
                        </h4>
                        <p class="m-b-0">Total All User : {{ count_user() }} <i class="feather icon-arrow-up m-l-10"></i></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary rounded fs-3">
                            <i class="bx bx-dollar-circle text-primary"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                            Total All Order</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span>
                                {{ count_order()['total'] }}
                            </span>
                        </h4>
                        <p class="m-b-0">Social Media : {{ count_order()['sosmed'] }}</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary rounded fs-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                            Total Deposit User
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span>
                                {{ rupiah(count_deposit()['amount']) }}
                            </span>
                        </h4>
                        <p class="m-b-0">Dari Total Deposit : {{ count_deposit()['count'] }} <i class="feather icon-arrow-up"></i></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary rounded fs-3">
                            <i class="fas fa-wallet text-primary"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
    <!-- [ sample-page ] start -->
    <div class="col-sm-12 col-md-12">
        <div class="card">

            <div class="card-header">
                <h5>Stastik 7 Hari Sebelumnya Seluruh Pesanan</h5>
            </div>
            <div class="card-body">
                <canvas id="chart-area-1" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row" id="saldo_provider"></div>
@endsection
@section('script')
<script src="{{ url('assets') }}/libs/chart.js/chart.min.js"></script>
<script>
    // var data = `{!! json_encode(getDays7Before()) !!}`
    // [ area-chart ] Start
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "{{ url('ajax/getSaldoProvider') }}",
        success: function(data) {
            let dataHtml = '';
            for (let dp of data) {
                dataHtml += `
                <div class="col-md-6 col-xl-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    Sisa Saldo ${dp.name}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span>
                                        ${dp.balance}
                                    </span>
                                </h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-primary rounded fs-3">
                                    <i class="fas fa-dollar-sign text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `
            };
            $("#saldo_provider").append(dataHtml)
        }
    })
    var jsonData = JSON.parse(`{!! json_encode(order7days()) !!}`)
    var bar = document.getElementById("chart-area-1").getContext('2d');
    var data1 = {
        labels: jsonData.date,
        datasets: [{
            label: "Sosmed",
            data: jsonData.sosmed,
            fill: true,
            borderWidth: 4,
            borderColor: '#4680ff',
            backgroundColor: '#4680ff',
            hoverborderColor: '#4680ff',
            hoverBackgroundColor: '#4680ff',
        }, {
            label: "PPOB",
            data: jsonData.ppob,
            fill: true,
            cubicInterpolationMode: 'monotone',
            borderWidth: 0,
            borderColor: '#0e9e4a',
            backgroundColor: '#0e9e4a',
            hoverborderColor: '#0e9e4a',
            hoverBackgroundColor: '#0e9e4a',
        }, {
            label: "Topup Games",
            data: jsonData.games,
            fill: true,
            borderWidth: 4,
            borderColor: '#9ccc65',
            backgroundColor: '#9ccc65',
            hoverborderColor: '#9ccc65',
            hoverBackgroundColor: '#9ccc65',
        }]
    };
    var myBarChart = new Chart(bar, {
        type: 'line',
        data: data1,
        responsive: true,
        options: {
            barValueSpacing: 20,
            maintainAspectRatio: false,
        }
    });
</script>
@endsection