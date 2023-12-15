@extends('template')
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
                    @foreach($replies as $reply)
                    @if(!$reply['is_admin'])
                    <div class="row m-b-20 send-chat">
                        <div class="col">
                            <div class="msg">
                                <p class="m-b-0">{{ $reply['message'] }}</p>
                            </div>
                            <p class="text-muted m-b-0"><i class="fa fa-clock-o m-r-10"></i>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($reply['created_at']))->diffForHumans() }}</p>
                        </div>
                    </div>
                    @else
                    <div class="row m-b-20 receiver-chat">
                        <div class="col">
                            <div class="msg">
                                <p class="m-b-0">{{ $reply['message'] }}</p>
                            </div>
                            <p class="text-muted m-b-0"><i class="fa fa-clock-o m-r-10"></i>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($reply['created_at']))->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endif
                    @endforeach
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
            url: "{{url('ajax/tickets')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (!data.error) {
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
                window.location.reload();
            },
            error: function(data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Server mengalami masalah!',
                })
            }
        });
    })
</script>
@endsection