@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Room</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{route('rooms.store')}}">
                            @csrf
                            @include('roomCrud.form')
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

