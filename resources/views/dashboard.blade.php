@extends('template')
@section('view')
<div class="row">
    <div class="col-md-4 col-sm-12">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                            Saldo Tersisa</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span>
                                {{ rupiah($user->balance) }}
                            </span>
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-secondary rounded fs-3">
                            <i class="far fa-wallet text-primary"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
    <div class="col-md-4 col-sm-12">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                            Total Pemesanan</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span>
                                {{ rupiah($orders) }}
                            </span>
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-secondary rounded fs-3">
                            <i class="far fa-shopping-cart text-primary"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
    <div class="col-md-4 col-sm-12">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                            Total Deposit</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                            <span>
                                {{ rupiah($deposit) }}
                            </span>
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-secondary rounded fs-3">
                            <i class="far fa-credit-card text-primary"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
    <div class="col-xl-3 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Detail Level</h4>
            </div>
            <div class="card-body">
                <div class="title-head mb-3">
                    <div class="storage-percent">
                        <div class="progress mb-4">
                            {!! nextTarget() !!}
                        </div>
                        <div class="remaining-storage">
                            <div class="text-muted fs-13 mb-1 mt-3">Level Sekarang</div>
                            <div class="fw-bolder fs-14 mb-1 mt-3" style="text-decoration: none; letter-spacing: 1px; background-image: linear-gradient(to right, var(--vz-primary) 0%, #03ab57 100%) !important; -webkit-background-clip: text; color: transparent;">{{ $role->name }}</div>
                        </div>
                        <div class="remaining-storage">
                            <div class="text-muted fs-13 mb-1 mt-1">Total Pesanan Bulan ini (Rp)</div>
                            <div class="fw-semibold fs-14 mb-1 mt-1">{{ rupiah(countOrderPerMonth()) }}</div>
                        </div>
                        <div class="remaining-storage">
                            <div class="text-muted fs-13 mb-1 mt-1">Bonus Deposit Bulan ini (%)</div>
                            <div class="fw-semibold fs-14 mb-1 mt-1">+ {{ persen($role->bonus_deposit) }} %</div>
                        </div>
                        <div class="remaining-storage">
                            <div class="text-muted fs-13 mb-1 mt-1">Potongan Harga Bulan ini (%)</div>
                            <div class="fw-semibold fs-14 mb-1 mt-1">+ {{ persen($role->total_discount) }} %</div>
                        </div>
                        @if(!$user['permanent_role'])
                        @if(!empty(nextRoles()))
                        <hr>
                        <div class="remaining-storage">
                            <div class="text-muted fs-13 mb-1 mt-1">Level Selanjutnya</div>
                            <div class="fw-bolder fs-14 mb-1 mt-1" style="text-decoration: none; letter-spacing: 1px; background-image: linear-gradient(to right, var(--vz-primary) 0%, #03ab57 100%) !important; -webkit-background-clip: text; color: transparent;">{{ nextRoles()['name'] }}</div>
                        </div>
                        <div class="remaining-storage">
                            <div class="text-muted fs-13 mb-1 mt-1">Minimum Pesanan Bulan ini (Rp)</div>
                            <div class="fw-semibold fs-14 mb-1 mt-1">{{ rupiah(nextRoles()['total_spend']) }}</div>
                        </div>
                        <div class="remaining-storage">
                            <div class="text-muted fs-13 mb-1 mt-1">Bonus Deposit Bulan ini (%)</div>
                            <div class="fw-semibold fs-14 mb-1 mt-1">+ {{ persen(nextRoles()['bonus_deposit']) }} %</div>
                        </div>
                        <div class="remaining-storage">
                            <div class="text-muted fs-13 mb-1 mt-1">Potongan Harga Bulan ini (%)</div>
                            <div class="fw-semibold fs-14 mb-1 mt-1">+ {{ persen(nextRoles()['total_discount']) }} %</div>
                        </div>
                        <hr>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <div class="col-xl-9 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Statistik Pemesanan</h4>
            </div>
            <div class="card-body" style="height: 32vh;">
                <canvas id="bar" class="chartjs-chart" data-colors='["--vz-primary-rgb, 0.8", "--vz-primary-rgb, 0.9"]'></canvas>

            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fas fa-bullhorn me-1"></i>Informasi Terbaru</h4>
            </div>
            <div class="card-body border-bottom" style="max-height: 429px; overflow: auto;">
                <div class="row">
                    @foreach($news as $news)
                    @if($news->type == 'SERVICES')
                    <div class="col-md-12">
                        <div class="alert alert-success" role="alert">
                            <div class="alert-body" id="information-body">
                                <h5 class="text-success mb-1"><strong><i class="fas fa-tags"></i> Layanan</strong><span id="tcolor1" class="text-secondary mb-1 float-end"><small>{{ \Carbon\Carbon::parse($news->created_at)->diffForHumans() }}</small></span></h5>
                                <p id="tcolor2" class="text-secondary text-break mb-1">{!! htmlspecialchars_decode(nl2br($news->content)) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif($news->type == 'PROMO')
                    <div class="col-md-12">
                        <div class="alert alert-warning" role="alert">
                            <div class="alert-body" id="information-body">
                                <h5 class="text-warning mb-1"><strong><i class="fas fa-usd"></i> PROMO</strong><span id="tcolor1" class="text-secondary mb-1 float-end"><small>{{ \Carbon\Carbon::parse($news->created_at)->diffForHumans() }}</small></span></h5>
                                <p id="tcolor2" class="text-secondary text-break mb-1">{!! htmlspecialchars_decode(nl2br($news->content)) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif($news->type == 'MAINTENANCE')
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-body" id="information-body">
                                <h5 class="text-danger mb-1"><strong><i class="fas fa-bugs"></i> PERBAIKAN</strong><span id="tcolor1" class="text-secondary mb-1 float-end"><small>{{ \Carbon\Carbon::parse($news->created_at)->diffForHumans() }}</small></span></h5>
                                <p id="tcolor2" class="text-secondary text-break mb-1">{!! htmlspecialchars_decode(nl2br($news->content)) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif($news->type == 'INFO')
                    <div class="col-md-12">
                        <div class="alert alert-info" role="alert">
                            <div class="alert-body" id="information-body">
                                <h5 class="text-primary mb-1"><strong><i class="fas fa-bugs"></i> INFORMASI</strong><span id="tcolor1" class="text-secondary mb-1 float-end"><small>{{ \Carbon\Carbon::parse($news->created_at)->diffForHumans() }}</small></span></h5>
                                <p id="tcolor2" class="text-secondary text-break mb-1">{!! htmlspecialchars_decode(nl2br($news->content)) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <!-- <div class="col-md-12">
                            <hr class="mt-0">
                            <div class="d-grid">
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- Chart JS -->
<script src="{{ asset('assets') }}/libs/chart.js/chart.min.js"></script>
<script type="text/javascript">
    var jsonData = JSON.parse(`{!! json_encode(data7days()) !!}`)
    var bar = document.getElementById("bar").getContext('2d');
    var data1 = {
        labels: jsonData.date,
        datasets: [{
            label: "Pemesanan",
            data: jsonData.orders,
            fill: true,
            borderWidth: 4,
            borderColor: '#4680ff',
            backgroundColor: '#4680ff',
            hoverborderColor: '#4680ff',
            hoverBackgroundColor: '#4680ff',
        }, {
            label: "Deposit",
            data: jsonData.deposit,
            fill: true,
            cubicInterpolationMode: 'monotone',
            borderWidth: 0,
            borderColor: '#0e9e4a',
            backgroundColor: '#0e9e4a',
            hoverborderColor: '#0e9e4a',
            hoverBackgroundColor: '#0e9e4a',
        }]
    };
    var myBarChart = new Chart(bar, {
        type: 'bar',
        data: data1,
        responsive: true,
        options: {
            barValueSpacing: 20,
            maintainAspectRatio: false,
        }
    });
</script>
@endsection