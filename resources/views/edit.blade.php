@extends('layouts.master')


@section('content')

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">

                <h1 class="my-4">Edit
                    <small>{{ $post->title }}</small>
                </h1>

                {{--  @if ($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $error }}</strong>
                        </div>
                    @endforeach
                @endif  --}}
                <!-- form Post -->
                <form method="POST" action="{{ route('update.post', $post->id) }}" enctype="multipart/form-data">
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
                    <button type="submit" class="btn btn-primary mb-5 float-right">Update</button>
                  </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
  <!-- /.container -->

@endsection

