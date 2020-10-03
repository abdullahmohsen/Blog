@extends('layouts.master')

@section('content')

    <div class="container">

        <div class="m-auto text-center">
            <div id="msgSuccessEdit" class="text-center alert alert-success"></div>
            <div id="msgErrorsEdit" class="text-center alert alert-danger"></div>
        </div>
        <h1 class="mb-4">Edit post</h1>
        <form method="post" action="" id="form_edit" enctype= "multipart/form-data">
            @csrf
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" class="form-control" name="title" value="{{ $post->title }}">
                </div>
                <div class="form-group">
                    <label>Desc:</label>
                    <textarea class="form-control" name="desc" cols="30" rows="5">{{ $post->desc }}</textarea>
                </div>
                <div class="form-group">
                    <label>Content:</label>
                    <textarea class="form-control" name="content" cols="30" rows="5">{{ $post->content }}</textarea>
                </div>
                <img width="250px" class="img-fluid" src="{{ asset('assets/uploads/'.$post->image) }}">

                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" class="d-block">
                </div>
            </div>
                <input id="save_edit" class="btn btn-primary" type="submit" value="Update">
            </div>
        </form>
    </div>
@endsection

@section('scripts')


<script src="{{ asset('assets') }}/vendor/jquery/jquery-3.5.1.min.js"></script>

<script>

    $('#msgSuccessEdit').hide()
    $('#msgErrorsEdit').hide()

    $(document).on('click', '#save_edit', function(e){
        e.preventDefault();

        $('#msgSuccessEdit').hide()
        $('#msgErrorsEdit').hide()
        $('#msgErrorsEdit').empty()

        let formData = new FormData($('#form_edit')[0]);

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: "{{ route('update.ajaxpost') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,

            success:function(data)
            {
                $('#msgSuccessEdit').show()
                $('#msgSuccessEdit').text(data.success);
                setTimeout(function() {
                    $('#msgSuccessEdit').fadeOut('fast');
                }, 3000);
                
            },
            error: function (xhr, status, error)
            {
                $('#msgErrorsEdit').show()
                $.each(xhr.responseJSON.errors, function(key, item)
                {
                    $('#msgErrorsEdit').append("<p class='mb-0'>" + item + "</p>")
                    setTimeout(function() {
                        $('#msgErrorsEdit').fadeOut('fast');
                    }, 3000);
                })
            }
        })
    });
</script>


@endsection
