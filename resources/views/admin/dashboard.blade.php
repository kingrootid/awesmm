@extends('admin.template')
@section('view')
<div class="row">
    <div class="col-md-12 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                            <div class="avatar-title rounded bg-primary bg-gradient">
                                <i data-eva="pie-chart-2" class="fill-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total User Balance</p>
                        <h4 class="mb-0">{{ rupiah(balance_all_user()) }} IDR</h4>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                            <div class="avatar-title rounded bg-primary bg-gradient">
                                <i data-eva="pie-chart-2" class="fill-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total Order</p>
                        <h4 class="mb-0"> {{ count_order()['total'] }}</h4>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                            <div class="avatar-title rounded bg-primary bg-gradient">
                                <i data-eva="pie-chart-2" class="fill-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total Deposit</p>
                        <h4 class="mb-0"> {{ rupiah(count_deposit()['amount']) }}</h4>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
    </div>
</div>
<div class="row">
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
        url: "{{ url('admin/ajax/getSaldoProvider') }}",
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