@extends('layouts.master')

@section('styles')
    <style>
        .title {
            font-size: 84px;
        }
    </style>

@endsection


@section('content')

    <div class="d-flex justify-content-center align-items-center">
        <div class="text-center mb-5">
            <div class="title mb-4">
                Video Viewer ({{ $video->viewers }})
            </div>

            {{--  put the video here  --}}
            

        </div>
    </div>

@endsection

