@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @forelse($friends as $friend)
                    @include('partials.user', ['user' => $friend])
                    @empty
                    No tienes amigos todavia
                @endforelse
            </div>
        </div>
    </div>
@endsection
