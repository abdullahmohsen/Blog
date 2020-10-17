@extends('layouts.master')


@section('content')

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <h1 class="mb-4">Create post</h1>

                <!-- form Post -->
                <form method="POST" action="{{ route('store.post') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" class="form-control" name="title">
                        @error('title')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Desc:</label>
                        <textarea class="form-control" name="desc" cols="30" rows="5"></textarea>
                        @error('desc')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Content:</label>
                        <textarea class="form-control" name="content" cols="30" rows="5"></textarea>
                        @error('content')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Image:</label>
                        <input type="file" name="image" class="d-block">
                    </div>
                    <button type="submit" class="btn btn-primary mb-5 float-right">Add</button>
                  </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
  <!-- /.container -->

@endsection

