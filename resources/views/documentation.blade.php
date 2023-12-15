@extends('template')
@section('view')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-code mr-1"></i> Documentation API</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>HTTP Method</th>
                            <td>POST</td>
                        </tr>
                        <tr>
                            <th>Response Format</th>
                            <td>JSON</td>
                        </tr>
                        <tr>
                            <th>Base URL</th>
                            <td>{{ url('api/v1') }}</td>
                        </tr>
                        <tr>
                            <th>API ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>API Key</th>
                            <td>
                                @if(empty($user->api_key))
                                <a href="javascript:;" class="btn btn-primary" onclick="generate();"><i class="fas fa-random mr-3"></i>Generate API Key</a>
                                @else
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" value="{{ $user->api_key }}" readonly>
                                    <div class="addon-input-group">
                                        <a href="javascript:;" class="btn btn-primary btn-sm" style="width: 100px;" onclick="copy_text('API Key', '{{ $user->api_key }}');"><i class="fas fa-copy me-1"></i>Salin</a>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                            <i class="fas fa-user mr-2 align-middle"></i> <span class="d-md-inline-block">Profil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="false">
                            <i class="fas fa-tags mr-2 align-middle"></i> <span class="d-md-inline-block">Layanan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="false">
                            <i class="fas fa-cart-plus mr-2 align-middle"></i> <span class="d-md-inline-block">Pemesanan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">
                            <i class="fas fa-check-circle mr-2 align-middle"></i> <span class="d-md-inline-block">Status</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="50%" class="table-primary">Endpoint</th>
                                    <td>{{ url('api/v1/profile') }}</td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">Parameter</th>
                                    <th width="50%" class="table-primary">Isi</th>
                                </tr>
                                <tr>
                                    <td width="50%">api_id</th>
                                    <td width="50%">Your API ID</th>
                                </tr>
                                <tr>
                                    <td width="50%">api_key</th>
                                    <td width="50%">Your API Key</th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="table-primary">Example Response</th>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-success">Success</th>
                                    <th width="50%" class="table-danger">Fail</th>
                                </tr>
                                <tr>
                                    <td>
                                        <pre><code class="json">{
    "message": "Success Get Data Profile",
    "status": true,
    "data": [
        {
            "id": 1, // ID Profile
            "name": "RootWritter", // Nama Profile
            "email": "RootWritter@aol.com", // Email Profile
            "balance": "0" // Saldo Profile
        }
    ]
}</code></pre>
                                        <small class="fw-bold text-danger">*Gray text (comments/descriptions) is not included in the response.</small>
                                    </td>
                                    <td>
                                        <pre><code class="json">{
    "message": "Credential not matched!",
    "status": false
}</code></pre>
                                        <small class="fw-bold text-danger">*Gray text (comments/descriptions) is not included in the response.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">List of failed responses</th>
                                    <td>
                                        <li>Credential Not Matched</li>
                                        <li>Unauthorized</li>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="50%" class="table-primary">Endpoint</th>
                                    <td>{{ url('api/v1/services') }}</td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">Parameter</th>
                                    <th width="50%" class="table-primary">Isi</th>
                                </tr>
                                <tr>
                                    <td width="50%">api_id</th>
                                    <td width="50%">Your API ID</th>
                                </tr>
                                <tr>
                                    <td width="50%">api_key</th>
                                    <td width="50%">Your API Key</th>
                                </tr>
                                <tr>
                                    <td width="50%">category_id <span class="text-primary">(Optional)</span></th>
                                    <td width="50%">Filter Category ID</th>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">Category ID List</th>
                                    <td>
                                        @foreach($category as $category)
                                        {{ $category->id }} - {{ $category->name}}<br />
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="table-primary">Example Response</th>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-success">Success</th>
                                    <th width="50%" class="table-danger">Fail</th>
                                </tr>
                                <tr>
                                    <td>
                                        <pre><code class="json">{
    "message": "Success Get Data Services",
    "status": true,
    "data": [
        {
            "id": 61,
            "category": "Instagram Followers",
            "name": "Instagram Followers Test Services",
            "description": "Instagram Followers Test Services",
            "price": 812175,
            "min": 5,
            "max": 150,
            "type": "Normal"
        },
        {
            "id": 61,
            "category": "Instagram Custom Comments",
            "name": "Custom Comments",
            "description": "Custom Comments",
            "price": 812175,
            "min": 5,
            "max": 150,
            "type": "Custom Comments"
        },
        {
            "id": 582,
            "category": "Instagram Custom Like",
            "name": "Instagram Comment Likes [10K] [SPECIFIC COMMENT] [Refill: No] [Max: 10K] [Start Time: 0-1 Hour] [Speed: 5K/Day]  ⚡️",
            "description": "Instagram Comment Likes [10K] [SPECIFIC COMMENT] [Refill: No] [Max: 10K] [Start Time: 0-1 Hour] [Speed: 5K/Day]  ⚡️",
            "price": 21420,
            "min": 20,
            "max": 10000,
            "type": "Custom Likes"
        }
    ]
}</code></pre>
                                        <small class="fw-bold text-danger">*Gray text (comments/descriptions) is not included in the response.</small>
                                    </td>
                                    <td>
                                        <pre><code class="json">{
    "message": "Credential not matched!",
    "status": false
}</code></pre>
                                        <small class="fw-bold text-danger">*Gray text (comments/descriptions) is not included in the response.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">List of failed responses</th>
                                    <td>
                                        <li>Credential Not Matched</li>
                                        <li>Unauthorized</li>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="50%" class="table-primary align-middle">Type</th>
                                    <td>
                                        <select class="select2 form-control form-control-sm" id="form-type">
                                            <option value="Default">Default</option>
                                            <option value="Custom Comments">Custom Comments</option>
                                            <option value="Comment Likes">Comment Likes</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">Endpoint</th>
                                    <td>{{ url('api/v1/order') }}</td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">Parameter</th>
                                    <th width="50%" class="table-primary">Isi</th>
                                </tr>
                                <tr>
                                    <td width="50%">api_id</th>
                                    <td width="50%">Your API ID</th>
                                </tr>
                                <tr>
                                    <td width="50%">api_key</th>
                                    <td width="50%">Your API Key</th>
                                </tr>
                                <tr>
                                    <td width="50%">service</th>
                                    <td width="50%">Service ID <a href="{{ url('price-list/social') }}" target="_blank">(Service List)</a></th>
                                </tr>
                                <tr>
                                    <td width="50%">target</th>
                                    <td width="50%">Link to page</th>
                                </tr>
                                <tr id="tDefault">
                                    <td width="50%">quantity</th>
                                    <td width="50%">Needed quantity</th>
                                </tr>
                                <tr class="d-none" id="tCustomComments">
                                    <td width="50%">comments</th>
                                    <td width="50%">Comments list separated by <em class="text-primary">\r\n</em> or <em class="text-primary">\n</em></th>
                                </tr>
                                <tr class="d-none" id="tCustomLikes">
                                    <td width="50%">userame</th>
                                    <td width="50%">Username of the comment owner</th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="table-primary">Example Response</th>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-success">Success</th>
                                    <th width="50%" class="table-danger">Fail</th>
                                </tr>
                                <tr>
                                    <td>
                                        <pre><code class="json">{
    "status": true,
    "message": "Success to Order",
    "data": {
        "order_id": 111, // Order ID
        "service_name": "RootWritter Services", // Service Name
        "quantity": 5, // Quantity
        "price": 4060.875 // Price
    }
}</code></pre>
                                        <small class="fw-bold text-danger">*Gray text (comments/descriptions) is not included in the response.</small>
                                    </td>
                                    <td>
                                        <pre><code class="json">{
    "message": "Credential not matched!",
    "status": false
}</code></pre>
                                        <small class="fw-bold text-danger">*Gray text (comments/descriptions) is not included in the response.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">List of failed responses</th>
                                    <td>
                                        <li>Credential Not Matched</li>
                                        <li>Unauthorized</li>
                                        <li>Failed to get service or service not active</li>
                                        <li>Comments cannot be empty!</li>
                                        <li>Quantity cannot be empty!</li>
                                        <li>Your Balance is too low to order this service, Please top up your balance!</li>
                                        <li>Failed to Order. Please Contact Administrator</li>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="status" role="tabpanel" aria-labelledby="status-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="50%" class="table-primary">Endpoint</th>
                                    <td>{{ url('api/v1/status') }}</td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">Parameter</th>
                                    <th width="50%" class="table-primary">Isi</th>
                                </tr>
                                <tr>
                                    <td width="50%">api_id</th>
                                    <td width="50%">Your API ID</th>
                                </tr>
                                <tr>
                                    <td width="50%">api_key</th>
                                    <td width="50%">Your API Key</th>
                                </tr>
                                <tr>
                                    <td width="50%">order_id</th>
                                    <td width="50%">Order ID</th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="table-primary">Example Response</th>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-success">Success</th>
                                    <th width="50%" class="table-danger">Fail</th>
                                </tr>
                                <tr>
                                    <td>
                                        <pre><code class="json">{
    "message": "Success Get Data Profile",
    "status": true,
    "data": {
        "id": 1,
        "service_name": "RootWritter Services",
        "qty": 5,
        "price": 4060.875,
        "start_count": 0,
        "remains": 0,
        "status": "Success"
    }
}</code></pre>
                                        <small class="fw-bold text-danger">*Gray text (comments/descriptions) is not included in the response.</small>
                                    </td>
                                    <td>
                                        <pre><code class="json">{
    "message": "Credential not matched!",
    "status": false
}</code></pre>
                                        <small class="fw-bold text-danger">*Gray text (comments/descriptions) is not included in the response.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">List of failed responses</th>
                                    <td>
                                        <li>Credential Not Matched</li>
                                        <li>Unauthorized</li>
                                        <li>Order Not Found</li>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%" class="table-primary">List of statuses</th>
                                    <td>
                                        <li>Pending</li>
                                        <li>Processing</li>
                                        <li>Success</li>
                                        <li>Error</li>
                                        <li>Partial</li>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script>
    $("#form-type").on('change', function(e) {
        e.preventDefault();
        var type = $(this).val();
        if (type == 'Default') {
            $('#tDefault').removeClass('d-none');
            $('#tCustomComments').addClass('d-none');
            $('#tCustomLikes').addClass('d-none');
        } else if (type == 'Custom Comments') {
            $('#tDefault').addClass('d-none');
            $('#tCustomComments').removeClass('d-none');
            $('#tCustomLikes').addClass('d-none');
        } else if (type == 'Comment Likes') {
            $('#tDefault').removeClass('d-none');
            $('#tCustomComments').addClass('d-none');
            $('#tCustomLikes').removeClass('d-none');
        }
    })

    function generate() {
        $.ajax({
            url: "{{ url('ajax/generate-api-key') }}",
            type: "POST",
            data: {
                _token: token
            },
            success: function(data) {
                window.location.reload();
            }
        });
    }

    function copy_text(title, text) {
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.setAttribute("id", "dummy_id");
        document.getElementById("dummy_id").value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
        Swal.fire({
            title: 'Yeay!',
            icon: 'success',
            html: title + ' berhasil disalin.',
            confirmButtonText: 'Okay',
            customClass: {
                confirmButton: 'btn btn-primary',
            },
            buttonsStyling: false,
        });
    }
</script>
@endsection