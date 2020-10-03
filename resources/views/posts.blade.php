@extends('layouts.master')


@section('content')
    <!-- Page Content -->
    <div class="container mb-5">
        <div class="row">

            <div class="m-auto text-center">
                <div id="msgSuccessDelete" class="text-center alert alert-success" style="display: none;"></div>
                <div id="msgErrorsDelete" class="text-center alert alert-danger" style="display: none;"></div>
            </div>

                <div class="d-flex justify-content-between align-items-center my-4 w-100">
                    <h1>{{ __('messages.All Posts') }}</h1>
                    {{--  <a href="{{ route('create.ajaxpost') }}" class="btn btn-primary">Create Post</a>  --}}
                    <button href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        {{ __('messages.Create Post') }}
                    </button>
                </div>


                @if(count($posts) > 0)
                    @foreach($posts as $post)
                        <div class="row mb-5 postRow{{$post->id}}">
                            <div class="col-md-4">
                                <img class="card-img-top" src="{{ asset('assets/uploads/'.$post->image) }}" alt="Card image cap">
                                <div class="card-footer text-muted">
                                    Posted on {{ $post->created_at }} - by {{ $post->user->name}}
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h2 class="card-title">{{ $post->title }}</h2>
                                <p class="card-text">{{ $post->desc }}</p>
                                <a href="{{ route('show.post', $post->id) }}" class="btn btn-primary w-25">Read More &rarr;</a>

                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $post->user_id)
                                        //Edit btn AJAX
                                        <a href="{{ route('edit.ajaxpost', $post->id) }}" class="btn btn-success edit_btn d-block mt-1 w-25" data-toggle="modal" data-target="#exampleModalEdit">Edit &rarr;</a>
                                        //delete btn AJAX
                                        <a post_id="{{ $post->id }}" class="text-white btn btn-danger delete_btn d-block mt-1 w-25">Delete &rarr;</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No posts found</p>
                @endif

        </div>
    </div>
@endsection

<!-- Create and Store Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header mb-2">
            <h5 class="modal-title" id="exampleModalLabel">Create post</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="m-auto text-center">
            <div id="msgSuccess" class="text-center alert alert-success"></div>
            <div id="msgErrors" class="text-center alert alert-danger"></div>
        </div>
        <form method="post" action="" id="form_post" enctype= "multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="form-group">
                    <label>Desc:</label>
                    <textarea class="form-control" name="desc" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Content:</label>
                    <textarea class="form-control" name="content" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" class="d-block">
                </div>
            </div>
            <div class="modal-footer">
                <input id="save_post" class="btn btn-primary" type="submit" value="Add">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>


<!-- Edit and Update Modal -->
<div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header mb-2">
            <h5 class="modal-title" id="exampleModalLabel">Edit post</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="m-auto text-center">
            <div id="msgSuccessEdit" class="text-center alert alert-success"></div>
            <div id="msgErrorsEdit" class="text-center alert alert-danger"></div>
        </div>
        <form method="post" action="" id="form_edit" enctype= "multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="post_id" value="{{ $post->id }}">

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
            <div class="modal-footer">
                <input id="save_edit" class="btn btn-primary" type="submit" value="Update">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>


@section('scripts')

    <!-- jquery core JavaScript -->
    <script src="{{ asset('assets') }}/vendor/jquery/jquery-3.5.1.min.js"></script>

    <!-- Create and Store -->
    <script>
        $('#msgSuccess').hide()
        $('#msgErrors').hide()

        //console.log("Hello");
        //$('#save_post').submit(function(e){
        //$('#save_post').on('submit', function(e){

        $(document).on('click', '#save_post', function(e){
            e.preventDefault();

            $('#msgSuccess').hide()
            $('#msgErrors').hide()
            $('#msgErrors').empty()

            let formData = new FormData($('#form_post')[0]);

            //console.log(formData);

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{ route('store.ajaxpost') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,

                success:function(data)
                {
                    //console.log(data.success);
                    $('#msgSuccess').show()
                    $('#msgSuccess').text(data.success);
                    setTimeout(function() {
                        $('#msgSuccess').fadeOut('fast');
                    }, 3000);

                    //Close the Modal and add the post without reload then show the msgSuccess in the home page in a few min.
                    //$('#exampleModal').modal('hide');
                    location.reload();
                },
                error: function (xhr, status, error)
                {
                    $('#msgErrors').show()
                    $.each(xhr.responseJSON.errors, function(key, item)
                    {
                        $('#msgErrors').append("<p class='mb-0'>" + item + "</p>")
                        setTimeout(function() {
                            $('#msgErrors').fadeOut('fast');
                        }, 3000);
                    })
                }
            })
        });
    </script>

    <!-- Edit and Update -->
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

    <!-- Delete -->
    <script>
        $('#msgSuccessDelete').hide()
        $('#msgErrorsDelete').hide()

        $(document).on('click', '.delete_btn', function(e){
            e.preventDefault();
            let post_id = $(this).attr('post_id');

            $('#msgSuccessDelete').hide()
            $('#msgErrorsDelete').hide()
            $('#msgErrorsDelete').empty()

            $.ajax({
                type: 'POST',
                url: "{{ route('destroy.ajaxpost') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': post_id
                },
                success:function(data)
                {
                    $('#msgSuccessDelete').show()
                    $('#msgSuccessDelete').text(data.success);
                    setTimeout(function() {
                        $('#msgSuccessDelete').fadeOut('fast');
                     }, 3000);
                    $('.postRow'+data.id).remove();
                },
                error: function (xhr, status, error)
                {
                    $('#msgErrorsDelete').show()
                    $.each(xhr.responseJSON.errors, function(key, item)
                    {
                        $('#msgErrorsDelete').append(item)
                        setTimeout(function() {
                            $('#msgErrorsDelete').fadeOut('fast');
                         }, 3000);
                    })
                }
            })
        });
    </script>


@endsection

