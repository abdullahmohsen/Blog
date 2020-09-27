@extends('layout.master')


@section('content')

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">

                <h1 class="my-4">Show
                    <small>{{ $post->title }}</small>
                </h1>

                <!-- Blog Post -->
                <div class="card mb-4">
                    <img class="card-img-top" src="{{ asset('assets/uploads/'.$post->image) }}" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title">{{ $post->title }}</h2> <hr>
                        <h6 class="mb-0">Description:</h6>
                        <p class="card-text">{{ $post->desc }}</p>
                        <h6 class="mb-0">Content:</h6>
                        <p class="card-text">{{ $post->content }}</p>
                        <a href="{{ route('edit.post', $post->id) }}" class="btn btn-success">Edit</a>
                        <a href="{{ route('destroy.post', $post->id) }}" class="btn btn-danger">Delete</a>
                    </div>
                    <div class="card-footer text-muted">
                        Posted on {{ $post->created_at }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
  <!-- /.container -->

@endsection

