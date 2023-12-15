@extends('template')
@section('view')
<!-- [ Invoice ] start -->
<div class="container" id="printTable">
    <div>
        <div class="card">
            <div class="card-body">
                <div class="invoice-contact">
                    <div class="invoice-box">
                        <table class="table table-responsive invoice-table table-borderless p-l-20">
                            <tbody>
                                <tr>
                                    <td><a href="{{ url('/') }}" class="b-brand">
                                            <img src="{{asset('/')}}{{get_config('logo')}}" alt="{{ get_config('logo')}}" class="img-fluid">
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ get_config('site_name') }}</td>
                                </tr>
                                <tr>
                                    <td>Indonesia</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row invoive-info">
                    <div class="col-md-4 col-xs-12 invoice-client-info">
                        <h6>Client Information :</h6>
                        <h6 class="m-0">{{ $userInvoice->name }}</h6>
                        <p class="m-0">{{ $userInvoice->phone }}</p>
                        <p>{{ $userInvoice->email }}</p>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <h6>Deposit Information :</h6>
                        <table class="table table-responsive invoice-table invoice-order table-borderless">
                            <tbody>
                                <tr>
                                    <th>Date :</th>
                                    <td>{{ $deposit->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Status :</th>
                                    <td>
                                        @if($deposit->status == "Pending")
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($deposit->status == "Success")
                                        <span class="badge bg-success">Success</span>
                                        @elseif($deposit->status == "Canceled")
                                        <span class="badge bg-danger">Canceled</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Id :</th>
                                    <td>
                                        #{{ $deposit->id }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <h6 class="m-b-20">Invoice Number <span>#{{ $deposit->id }}</span></h6>
                        <h6 class="text-uppercase text-primary">Total Due :
                            <span>{{ rupiah($deposit->amount) }}</span>
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table invoice-detail-table">
                                <thead>
                                    <tr class="thead-default">
                                        <th>Nomor Deposit</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Jumlah Transfer</th>
                                        <th>Saldo diterima</th>
                                        <th>Status</th>
                                        <th>Log Status Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>Deposit #{{ $deposit->id }}</b></td>
                                        <td><b>{{ $deposit->method }}</b></td>
                                        <td>{{ rupiah($deposit->amount) }}</td>
                                        <td>{{ rupiah($deposit->get) }}</td>
                                        <td>
                                            @if($deposit->status == "Pending")
                                            <span class="badge bg-warning">Pending</span>
                                            @elseif($deposit->status == "Success")
                                            <span class="badge bg-success">Success</span>
                                            @elseif($deposit->status == "Canceled")
                                            <span class="badge bg-danger">Canceled</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ !$deposit->log_payment ? '-' : $deposit->log_payment }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-responsive invoice-table invoice-total">
                            <tbody>
                                <tr>
                                    <th>Sub Total :</th>
                                    <td>{{ rupiah($deposit->amount) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Fee :</th>
                                    <td>- {{ rupiah($deposit->fee) }}</td>
                                </tr>
                                <tr class="text-info">
                                    <td>
                                        <hr />
                                        <h5 class="text-primary m-r-10">Total :</h5>
                                    </td>
                                    <td>
                                        <hr />
                                        <h5 class="text-primary">{{ rupiah($deposit->amount) }}</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <h6>Cara Melakukan Pembayaran :</h6>
                        {!! htmlspecialchars_decode(nl2br($deposit->note)) !!}
                    </div>
                    <div class="col-sm-4">
                        @if($deposit->qr_url)
                        <h6>QR :</h6>
                        <img src="{{ $deposit->qr_url }}" alt="QR Code" class="img-fluid">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center print-btn">
            <div class="col-sm-12 invoice-btn-group text-center">
                @if($deposit->url_payment)
                <a href="{{ $deposit->url_payment }}" class="btn waves-effect waves-light btn-success m-b-10"><i class="fas fa-paper-plane"></i> Ke Halaman Pembayaran</a>
                @endif
                <button type="button" class="btn waves-effect waves-light btn-primary btn-print-invoice m-b-10">Print</button>
                <button type="button" class="btn waves-effect waves-light btn-secondary m-b-10 ">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- [ Invoice ] end -->
@endsection
@section('script')
@endsection