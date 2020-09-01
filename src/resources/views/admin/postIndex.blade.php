@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach( $posts as $post)  
                {{ $post }}
            @endforeach
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
