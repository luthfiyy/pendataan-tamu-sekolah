@if (!empty(session('success')))
    <div class="alert alert-success" role="alert" style="margin-top: 20px">
        {{ session('success') }}
    </div>
@endif

@if (!empty(session('error')))
    <div class="alert alert-danger" role="alert" style="margin-top: 20px">
        {{ session('error') }}
    </div>
@endif