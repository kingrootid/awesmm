@extends('admin.template')
@section('view')
<div class="row">
    <div class="col-md-8 m-auto">
        <div class="card chat-card">
            <div class="card-header card-header-tambahan">
                <a href="{{url('/tickets')}}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                <h5>{{$page}}</h5>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="row">
                        @foreach($replies as $reply)
                        @if(!$reply['is_admin'])
                        <div class="col-8 mr-auto">
                            <div class="card">
                                <div class="card-body">
                                    <blockquote class="card-blockquote mb-0">
                                        <figure class="mb-0">
                                            <blockquote class="blockquote">
                                                <p class="lead">{{ $reply['message'] }}</p>
                                            </blockquote>
                                            <figcaption class="blockquote-footer fs-13 text-end mb-0">
                                                <p class="text-muted m-b-0"><i class="fa fa-clock-o m-r-10"></i>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($reply['created_at']))->diffForHumans() }}</p>
                                            </figcaption>
                                        </figure>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-8 ml-auto">
                            <div class="card">
                                <div class="card-body">
                                    <blockquote class="card-blockquote mb-0">
                                        <figure class="mb-0">
                                            <blockquote class="blockquote">
                                                <p class="lead">{{ $reply['message'] }}</p>
                                            </blockquote>
                                            <figcaption class="blockquote-footer fs-13 text-end mb-0">
                                                <p class="text-muted m-b-0"><i class="fa fa-clock-o m-r-10"></i>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($reply['created_at']))->diffForHumans() }}</p>
                                            </figcaption>
                                        </figure>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="form-group m-t-15">
                        <form id="reply" method="POST">
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <input type="hidden" name="status" value="reply">
                            <label for="message">Send message</label>
                            <textarea name="message" class="form-control" rows="3"></textarea>
                            <button class="btn btn-primary btn-icon w-100" type="submit">
                                <i class="fal fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card chat-card">
            <div class="card-header">
                <h5>Data Informasi</h5>
            </div>
            <div class="card-body">
                Ticket ID : #{{ $ticket->id }}<br />
                Subject : {{ $ticket->type }}<br />
                Order ID : <br />
                @if($order_id)
                @foreach ($order_id as $item => $value)
                {{ $item }} :
                @foreach ($value as $item2 => $value2)
                {{ $value2 }},
                @endforeach
                <br />
                @endforeach
                @endif
                <br />
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $("#reply").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        formData.append('_token', token);
        $.ajax({
            type: "POST",
            url: "{{url('admin/ajax/tickets')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status) {
                    $(this).trigger("reset");
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Berhasil Membalas Ticket',
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message,
                    })
                }
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: error.responseJSON.message
                })
            }
        });
    })
</script>
@endsection