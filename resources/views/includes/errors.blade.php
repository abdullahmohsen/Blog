@if ($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <strong>{{ $error }}</strong>
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
