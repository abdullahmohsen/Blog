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
                    <button href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#postCreateModel">
                        {{ __('messages.Create Post') }}
                    </button>
                </div>


                @if(count($posts) > 0)
                    @foreach($posts as $post)
                        <div class="row mb-5 postRow{{$post->id}}">
                            <div class="col-md-4">
                                <img class="card-img-top" src="{{ asset('assets/uploads/'.$post->image) }}" alt="Card image cap">
                                <div class="card-footer text-muted">
                                    Posted on {{ $post->created_at }} - by {{ $post->user->name }}
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <h2 class="card-title">{{ $post->title }}</h2>
                                    <a class="btn btn-primary showbtn text-white" data-id="{{ $post->id }}" data-title="{{ $post->title }}" data-image="{{ asset('assets/uploads/'.$post->image) }}"
                                        data-desc="{{ $post->desc }}" data-content="{{ $post->content }}" data-created_at="{{ $post->created_at }}" data-user_name="{{ $post->user->name }}">Show</a>
                                </div>
                                <p class="card-text">{{ $post->desc }}</p>
                                <a href="{{ route('show.post', $post->id) }}" class="btn btn-primary w-25">Read More &rarr;</a>

                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $post->user_id)

                                        {{--  Edit btn AJAX  --}}
                                        <a class="text-white btn btn-success editbtn d-block mt-1 w-25" data-id="{{ $post->id }}" data-title="{{ $post->title }}"
                                            data-desc="{{ $post->desc }}" data-content="{{ $post->content }}" data-image="{{ asset('assets/uploads/'.$post->image) }}">Edit &rarr;</a>

                                        {{--  delete btn AJAX  --}}
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

<!-- Show Modal -->
<div class="modal fade" id="postShowModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content postRow{{$post->id}}">
            <div class="modal-header mb-2">
                <h5 class="modal-title" id="exampleModalLabel">Show
                    <small id="title_show"></small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Blog Post -->
                <div class="card mb-4">
                    <img class="card-img-top" id="image_show" src="" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title" id="title_show1"></h2>
                        <hr>
                        <h6 class="mb-0">Description:</h6>
                        <p class="card-text" id="desc_show"></p>
                        <h6 class="mb-0">Content:</h6>
                        <p class="card-text" id="content_show"></p>
                    </div>
                    <div class="card-footer text-muted">
                        Posted on <span id="created_at"></span> by <span id="user_name"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Create and Store Modal -->
<div class="modal fade" id="postCreateModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <form id="createFormID" enctype= "multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" class="form-control" name="title">
                    <small id="title_error" class="form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Desc:</label>
                    <textarea class="form-control" name="desc" cols="30" rows="5"></textarea>
                    <small id="desc_error" class="form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Content:</label>
                    <textarea class="form-control" name="content" cols="30" rows="5"></textarea>
                    <small id="content_error" class="form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" class="d-block">
                    <small id="image_error" class="form-text text-danger"></small>
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
<div class="modal fade" id="postEditModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <form id="editFormID" enctype= "multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="id">

                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" class="form-control" name="title" id="title">
                </div>
                <div class="form-group">
                    <label>Desc:</label>
                    <textarea class="form-control" name="desc" id="desc" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Content:</label>
                    <textarea class="form-control" name="content" id="content" cols="30" rows="5"></textarea>
                </div>
                <img width="250px" id="image" class="img-fluid" src="">

                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" class="d-block">
                </div>
            </div>
            <div class="modal-footer">
                <input id="update_edit" class="btn btn-primary" type="submit" value="Update">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>


@section('scripts')

    <!-- Show -->
    <script>

        $(document).on('click', '.showbtn', function(){

            $('#id_show').text($(this).data('id'));
            $('#title_show').text($(this).data('title'));
            $('#title_show1').text($(this).data('title'));
            $('#desc_show').text($(this).data('desc'));
            $('#content_show').text($(this).data('content'));
            $('#image_show').attr('src', $(this).data('image'));
            $('#created_at').text($(this).data('created_at'));
            $('#user_name').text($(this).data('user_name'));

            $('#postShowModel').modal('show');
        });
    </script>

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

            //tany tre2a ll error 2-2
            $('#title_error').text('');
            $('#desc_error').text('');
            $('#content_error').text('');
            $('#image_error').text('');

            let formData = new FormData($('#createFormID')[0]);

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
                    //$('#postCreateModel').modal('hide');
                    location.reload();
                },
                error: function (xhr, status, error)
                {
                    {{--  $('#msgErrors').show()  --}} //awol tre2a ll error 1-1
                    $.each(xhr.responseJSON.errors, function(key, item)
                    {
                        $("#" + key + "_error").text(item[0]); //tany tre2a ll error 2-1

                        //awol tre2a ll error 1-2
                        {{--  $('#msgErrors').append("<p class='mb-0'>" + item + "</p>")
                        setTimeout(function() {
                            $('#msgErrors').fadeOut('fast');
                        }, 3000);  --}}
                    })
                }
            })
        });
    </script>

    <!-- Edit and Update -->
    <script>
        $('#msgSuccessEdit').hide()
        $('#msgErrorsEdit').hide()

        //$(document).ready(function(){
        //    $('.editbtn').on('click', function(){
        //        $('#postEditModel').modal('show');


        $(document).on('click', '.editbtn', function(){
            $('#editFormID').show();

            $('#id').val($(this).data('id'));
            $('#title').val($(this).data('title'));
            $('#desc').val($(this).data('desc'));
            $('#content').val($(this).data('content'));
            $('#image').attr('src', $(this).data('image'));

            $('#postEditModel').modal('show');
        });

        //{{--  $('.model-footer').on('click', '#update_edit', function(){  --}}


        $(document).on('click', '#update_edit', function(e){
            e.preventDefault();

            let formData = new FormData($('#editFormID')[0]);

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
                    location.reload();
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

