@extends('template')
@section('view')
<div class="row">
    <!-- Zero config table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{$page}}</h5>
            </div>
            <div class="card-body">
                {!! $content !!}
            </div>
        </div>
    </div>
    <!-- Zero config table end -->
</div>
@endsection